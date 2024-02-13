<?php

declare(strict_types=1);

namespace BitPaySDK\Setup;

require __DIR__ . '/../vendor/autoload.php';

use BitPayKeyUtils\KeyHelper\PrivateKey;
use BitPayKeyUtils\KeyHelper\PublicKey;
use BitPayKeyUtils\Storage\EncryptedFilesystemStorage;
use BitPaySDK\Env;
use GuzzleHttp\Client as GuzzleHttpClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\Yaml\Yaml;

function createConfigFile(
    string $env,
    bool $isProd,
    string $privateKeyLocation,
    string $password,
    ?string $merchantToken,
    ?string $payoutToken
): void {
    $config = [
        "BitPayConfiguration" => [
            "Environment" => $env === 'P' ? 'Prod' : 'Test',
            "EnvConfig"   => [
                'Test' => [
                    "PrivateKeyPath"   => $isProd ? null : $privateKeyLocation,
                    "PrivateKeySecret" => $isProd ? null : $password,
                    "ApiTokens"        => [
                        "merchant" => $isProd ? null : $merchantToken,
                        "payout"  => $isProd ? null : $payoutToken,
                    ],
                    "Proxy" => null,
                ],
                'Prod' => [
                    "PrivateKeyPath"   => $isProd ? $privateKeyLocation : null,
                    "PrivateKeySecret" => $isProd ? $password : null,
                    "ApiTokens"        => [
                        "merchant" => $isProd ? $merchantToken : null,
                        "payout"  => $isProd ? $payoutToken : null,
                    ],
                    "Proxy" => null,
                ],
            ],
        ],
    ];

    $json_data = json_encode($config, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    file_put_contents('BitPay.config.json', $json_data);

    $yml_data = Yaml::dump($config, 8, 4, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    file_put_contents('BitPay.config.yml', $yml_data);
}

function selectTokens(OutputInterface $output, mixed $helper, InputInterface $input): array
{
    $question = new Question('Select the tokens that you would like to request: ');
    $output->writeln('Press M for merchant, P for payout, or B for both: ');
    $possibleAnswers = ['M', 'P', 'B'];
    $question->setAutocompleterValues($possibleAnswers);
    $result = $helper->ask($input, $output, $question);
    if (!$result) {
        throw new \InvalidArgumentException('Missing answer');
    }

    $result = strtoupper($result);

    validateAnswer($result, $possibleAnswers);

    $shouldGenerateMerchant = false;
    $shouldGeneratePayout = false;

    if ($result === 'M') {
        $shouldGenerateMerchant = true;
    }

    if ($result === 'P') {
        $shouldGeneratePayout = true;
    }

    if ($result === 'B') {
        $shouldGenerateMerchant = true;
        $shouldGeneratePayout = true;
    }
    
    return [$shouldGenerateMerchant, $shouldGeneratePayout];
}

function validateAnswer(string $result, array $possibleAnswers): void
{
    if (!\in_array($result, $possibleAnswers, true)) {
        throw new \InvalidArgumentException('Wrong answer ' . $result . ' possible answers: ' . implode(',', $possibleAnswers));
    }
}

function getEnv(OutputInterface $output, QuestionHelper $helper, InputInterface $input): string
{
    $question = new Question('Select target environment: ');
    $output->writeln('Press T for testing or P for production:');
    $possibleAnswers = ['T', 'P'];
    $question->setAutocompleterValues($possibleAnswers);
    $result = $helper->ask($input, $output, $question);
    if (!$result) {
        throw new \RuntimeException('Missing answer');
    }
    $result = strtoupper($result);

    validateAnswer($result, $possibleAnswers);

    return $result;
}

function getPrivateKeyPassword(QuestionHelper $helper, InputInterface $input, OutputInterface $output): ?string
{
    $question = new Question('Please write password to encrypt your PrivateKey: ');
    $password = $helper->ask($input, $output, $question);
    if (!$password) {
        throw new \InvalidArgumentException('Encrypt password cannot be empty');
    }
    return $password;
}

function getPrivateKeyLocation(QuestionHelper $helper, InputInterface $input, OutputInterface $output): string
{
    $question = new Question('Please write full path with filename for private key or press enter to generate private key in root directory: ');
    $privateKeyLocation = $helper->ask($input, $output, $question);
    if (!$privateKeyLocation) {
        $privateKeyLocation = __DIR__ . '/PrivateKey.key';
    }

    return $privateKeyLocation;
}

function getPublicKey(string $privateKeyLocation, string $password): PublicKey {
    $privateKey = new PrivateKey($privateKeyLocation);
    $storageEngine = new EncryptedFilesystemStorage($password);
    try {
        //  Use the EncryptedFilesystemStorage to load the Merchant's encrypted private key with the Master Password.
        $privateKey = $storageEngine->load($privateKeyLocation);
    } catch (\Exception $ex) {
        //  Check if the loaded keys is a valid key
        if (!$privateKey->isValid()) {
            $privateKey->generate();
        }

        //  Encrypt and store it securely.
        //  This Master password could be one for all keys or a different one for each Private Key
        $storageEngine->persist($privateKey);
    }

    // Generate the public key from the private key every time (no need to store the public key).
    return $privateKey->getPublicKey();
}

function getSin(PublicKey $publicKey): string
{
    return $publicKey->getSin()->__toString();
}

function generateToken(
    OutputInterface $output,
    string $facade,
    string $sin,
    string $apiUrl
): ?string {
    $url = $apiUrl . '/tokens';

    $postData = json_encode([
        'id' => $sin,
        'facade' => $facade,
    ], JSON_THROW_ON_ERROR);
    $headers = [
        'Content-Type' => 'application/json',
        'x-accept-version' => Env::BITPAY_API_VERSION,
        'x-bitpay-plugin-info' => Env::BITPAY_PLUGIN_INFO,
        'x-bitpay-api-frame' => Env::BITPAY_API_FRAME,
        'x-bitpay-api-frame-version' => Env::BITPAY_API_FRAME_VERSION
    ];

    $client = new GuzzleHttpClient();
    $response = $client->request('POST', $url, [
        'headers' => $headers,
        'body' => stripslashes($postData)
    ])->getBody()->__toString();

    $resultData = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    if (array_key_exists('error', $resultData)) {
        throw new \RuntimeException($resultData['error']);
    }

    $token = $resultData['data'][0]['token'];

    $output->writeln(strtoupper($facade) . ' facade');
    $output->writeln('    -> Pairing code: ' . $resultData['data'][0]['pairingCode']);
    $output->writeln('    -> Token: ' . $token);
    $output->writeln('');

    return $token;
}

/**
 * @param OutputInterface $output
 * @param string $apiUrl
 * @return void
 */
function successMessage(OutputInterface $output, string $apiUrl): void
{
    $output->writeln('Configuration generated successfully!');
    $output->writeln('Please, copy the above pairing code/s and approve on your BitPay Account at the following link:');
    $output->writeln($apiUrl . '/dashboard/merchant/api-tokens');
    $output->writeln('Once you have this Pairing Code/s approved you can move the generated files to a secure location and start using the Client');
}

$help = "Generate new private key. Make sure you provide an easy recognizable name to your private key\n";
$help .= "NOTE: In case you are providing the BitPay services to your clients,\n";
$help .= "you MUST generate a different key per each of your clients\n";
$help .= "WARNING: It is EXTREMELY IMPORTANT to place this key files in a very SECURE location";

function getMerchantToken(
    bool $shouldGenerateMerchant,
    OutputInterface $output,
    string $sin,
    string $apiUrl
): ?string {
    if ($shouldGenerateMerchant) {
        return generateToken($output, 'merchant', $sin, $apiUrl);
    }

    return null;
}

function getPayoutToken(
    bool $shouldGeneratePayout,
    OutputInterface $output,
    string $sin,
    string $apiUrl
): ?string {
    if ($shouldGeneratePayout) {
        return generateToken($output, 'payout', $sin, $apiUrl);
    }
    return null;
}

(new SingleCommandApplication())
    ->setName('Generate new private key')
    ->setDescription('Generate new private key. Make sure you provide an easy recognizable name to your private key')
    ->setHelp($help)
    ->setCode(function (InputInterface $input, OutputInterface $output): int {
        $helper = $this->getHelper('question');
        
        try {
            $env = getEnv($output, $helper, $input);
            $apiUrl = $env === 'P' ? 'https://bitpay.com' : 'https://test.bitpay.com';
            $password = getPrivateKeyPassword($helper, $input, $output);
            $privateKeyLocation = getPrivateKeyLocation($helper, $input, $output);
            
            [$shouldGenerateMerchant, $shouldGeneratePayout] = selectTokens($output, $helper, $input);
            $publicKey = getPublicKey($privateKeyLocation, $password);
            $sin = getSin($publicKey);

            $merchantToken = getMerchantToken($shouldGenerateMerchant, $output, $sin, $apiUrl);
            $payoutToken = getPayoutToken($shouldGeneratePayout, $output, $sin, $apiUrl);

            createConfigFile($env, $env === 'P', $privateKeyLocation, $password, $merchantToken, $payoutToken);
            successMessage($output, $apiUrl);
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    })->run();
