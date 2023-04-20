<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model;

use Exception;
use ReflectionClass;

/**
 * Object containing currency information
 */
class Currency
{
    // Crypto
    public const BCH  = "BCH";
    public const BTC  = "BTC";
    public const ETH  = "ETH";
    public const USDC = "USDC";
    public const GUSD = "GUSD";
    public const PAX  = "PAX";
    public const XRP  = "XRP";
    public const BUSD = "BUSD";
    public const DOGE = "DOGE";
    public const LTC  = "LTC";
    public const SHIB  = "SHIB";

    // FIAT
    public const AED = "AED";
    public const AFN = "AFN";
    public const ALL = "ALL";
    public const AMD = "AMD";
    public const ANG = "ANG";
    public const AOA = "AOA";
    public const ARS = "ARS";
    public const AUD = "AUD";
    public const AWG = "AWG";
    public const AZN = "AZN";
    public const BAM = "BAM";
    public const BBD = "BBD";
    public const BDT = "BDT";
    public const BGN = "BGN";
    public const BHD = "BHD";
    public const BIF = "BIF";
    public const BMD = "BMD";
    public const BND = "BND";
    public const BOB = "BOB";
    public const BOV = "BOV";
    public const BRL = "BRL";
    public const BSD = "BSD";
    public const BTN = "BTN";
    public const BWP = "BWP";
    public const BYR = "BYR";
    public const BZD = "BZD";
    public const CAD = "CAD";
    public const CDF = "CDF";
    public const CHE = "CHE";
    public const CHF = "CHF";
    public const CHW = "CHW";
    public const CLF = "CLF";
    public const CLP = "CLP";
    public const CNY = "CNY";
    public const COP = "COP";
    public const COU = "COU";
    public const CRC = "CRC";
    public const CUC = "CUC";
    public const CUP = "CUP";
    public const CVE = "CVE";
    public const CZK = "CZK";
    public const DJF = "DJF";
    public const DKK = "DKK";
    public const DOP = "DOP";
    public const DZD = "DZD";
    public const EGP = "EGP";
    public const ERN = "ERN";
    public const ETB = "ETB";
    public const EUR = "EUR";
    public const FJD = "FJD";
    public const FKP = "FKP";
    public const GBP = "GBP";
    public const GEL = "GEL";
    public const GHS = "GHS";
    public const GIP = "GIP";
    public const GMD = "GMD";
    public const GNF = "GNF";
    public const GTQ = "GTQ";
    public const GYD = "GYD";
    public const HKD = "HKD";
    public const HNL = "HNL";
    public const HRK = "HRK";
    public const HTG = "HTG";
    public const HUF = "HUF";
    public const IDR = "IDR";
    public const ILS = "ILS";
    public const INR = "INR";
    public const IQD = "IQD";
    public const IRR = "IRR";
    public const ISK = "ISK";
    public const JMD = "JMD";
    public const JOD = "JOD";
    public const JPY = "JPY";
    public const KES = "KES";
    public const KGS = "KGS";
    public const KHR = "KHR";
    public const KMF = "KMF";
    public const KPW = "KPW";
    public const KRW = "KRW";
    public const KWD = "KWD";
    public const KYD = "KYD";
    public const KZT = "KZT";
    public const LAK = "LAK";
    public const LBP = "LBP";
    public const LKR = "LKR";
    public const LRD = "LRD";
    public const LSL = "LSL";
    public const LYD = "LYD";
    public const MAD = "MAD";
    public const MDL = "MDL";
    public const MGA = "MGA";
    public const MKD = "MKD";
    public const MMK = "MMK";
    public const MNT = "MNT";
    public const MOP = "MOP";
    public const MRU = "MRU";
    public const MUR = "MUR";
    public const MVR = "MVR";
    public const MWK = "MWK";
    public const MXN = "MXN";
    public const MXV = "MXV";
    public const MYR = "MYR";
    public const MZN = "MZN";
    public const NAD = "NAD";
    public const NGN = "NGN";
    public const NIO = "NIO";
    public const NOK = "NOK";
    public const NPR = "NPR";
    public const NZD = "NZD";
    public const OMR = "OMR";
    public const PAB = "PAB";
    public const PEN = "PEN";
    public const PGK = "PGK";
    public const PHP = "PHP";
    public const PKR = "PKR";
    public const PLN = "PLN";
    public const PYG = "PYG";
    public const QAR = "QAR";
    public const RON = "RON";
    public const RSD = "RSD";
    public const RUB = "RUB";
    public const RWF = "RWF";
    public const SAR = "SAR";
    public const SBD = "SBD";
    public const SCR = "SCR";
    public const SDG = "SDG";
    public const SEK = "SEK";
    public const SGD = "SGD";
    public const SHP = "SHP";
    public const SLL = "SLL";
    public const SOS = "SOS";
    public const SRD = "SRD";
    public const SSP = "SSP";
    public const STN = "STN";
    public const SVC = "SVC";
    public const SYP = "SYP";
    public const SZL = "SZL";
    public const THB = "THB";
    public const TJS = "TJS";
    public const TMT = "TMT";
    public const TND = "TND";
    public const TOP = "TOP";
    public const TRY = "TRY";
    public const TTD = "TTD";
    public const TWD = "TWD";
    public const TZS = "TZS";
    public const UAH = "UAH";
    public const UGX = "UGX";
    public const USD = "USD";
    public const USN = "USN";
    public const UYI = "UYI";
    public const UYU = "UYU";
    public const UZS = "UZS";
    public const VEF = "VEF";
    public const VND = "VND";
    public const VUV = "VUV";
    public const WST = "WST";
    public const XAF = "XAF";
    public const XCD = "XCD";
    public const XDR = "XDR";
    public const XOF = "XOF";
    public const XPF = "XPF";
    public const XSU = "XSU";
    public const XUA = "XUA";
    public const YER = "YER";
    public const ZAR = "ZAR";
    public const ZMW = "ZMW";
    public const ZWL = "ZWL";

    protected ?string $code = null;
    protected ?string $symbol = null;
    protected ?int $precision = null;
    protected ?bool $currentlySettled = null;
    protected ?string $name = null;
    protected ?string $plural = null;
    protected ?string $alts = null;
    protected ?string $minimum = null;
    protected ?bool $sanctioned = null;
    protected ?string $decimals = null;
    protected array $payoutFields = [];
    protected array $settlementMinimum = [];

    /**
     * Currency validation
     *
     * @param string $value the currency value
     * @return bool
     */
    public static function isValid(string $value): bool
    {
        try {
            $reflect = new ReflectionClass(Currency::class);

            return array_key_exists($value, $reflect->getConstants());
        } catch (Exception) {
            return false;
        }
    }

    public function __construct()
    {
    }

    /**
     * Get ISO 4217 3-character currency code
     *
     * @return string|null the code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Sets ISO 4217 3-character currency code
     *
     * @param string $code the code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Display symbol
     *
     * @return string|null the symbol
     */
    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    /**
     * Sets symbol
     *
     * @param string|null $symbol
     */
    public function setSymbol(?string $symbol = null): void
    {
        $this->symbol = $symbol;
    }

    /**
     * Number of decimal places
     *
     * @return int|null the precision
     */
    public function getPrecision(): ?int
    {
        return $this->precision;
    }

    /**
     * Sets number of decimal places
     *
     * @param int $precision the precision
     */
    public function setPrecision(int $precision): void
    {
        $this->precision = $precision;
    }

    /**
     * Gets currently settled value
     *
     * @return bool|null
     */
    public function getCurrentlySettled(): ?bool
    {
        return $this->currentlySettled;
    }

    /**
     * Sets currently settled value
     *
     * @param bool $currentlySettled
     */
    public function setCurrentlySettled(bool $currentlySettled): void
    {
        $this->currentlySettled = $currentlySettled;
    }

    /**
     * Gets currency name
     *
     * @return string|null the name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets currency name
     *
     * @param string $name the name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets English plural form
     *
     * @return string|null the plural form
     */
    public function getPlural(): ?string
    {
        return $this->plural;
    }

    /**
     * Sets English plural form
     *
     * @param string $plural the plural form
     */
    public function setPlural(string $plural): void
    {
        $this->plural = $plural;
    }

    /**
     * Gets alternative currency name(s)
     *
     * @return string|null the alts
     */
    public function getAlts(): ?string
    {
        return $this->alts;
    }

    /**
     * Sets alternative currency name(s)
     *
     * @param string $alts the alts
     */
    public function setAlts(string $alts): void
    {
        $this->alts = $alts;
    }

    /**
     * Gets minimum supported value when creating an invoice, bill or payout for instance
     *
     * @return string|null the minimum
     */
    public function getMinimum(): ?string
    {
        return $this->minimum;
    }

    /**
     * Sets minimum supported value when creating an invoice, bill or payout for instance
     *
     * @param string $minimum the minimum
     */
    public function setMinimum(string $minimum): void
    {
        $this->minimum = $minimum;
    }

    /**
     * Gets if the currency is linked to a sanctionned country
     *
     * @return bool|null the sanctioned
     */
    public function getSanctioned(): ?bool
    {
        return $this->sanctioned;
    }

    /**
     * Sets if the currency is linked to a sanctionned country
     *
     * @param bool $sanctioned the sanctioned
     */
    public function setSanctioned(bool $sanctioned): void
    {
        $this->sanctioned = $sanctioned;
    }

    /**
     * Gets decimal precision
     *
     * @return string|null decimals
     */
    public function getDecimals(): ?string
    {
        return $this->decimals;
    }

    /**
     * Sets decimal precision
     *
     * @param string $decimals decimals
     */
    public function setDecimals(string $decimals): void
    {
        $this->decimals = $decimals;
    }

    /**
     * Gets payout fields
     *
     * @return array the payout fields
     */
    public function getPayoutFields(): array
    {
        return $this->payoutFields;
    }

    /**
     * Sets payout fields
     *
     * @param array $payoutFields the payout fields
     */
    public function setPayoutFields(array $payoutFields): void
    {
        $this->payoutFields = $payoutFields;
    }

    /**
     * Gets settlement minimum
     *
     * @return array the settlement minimum
     */
    public function getSettlementMinimum(): array
    {
        return $this->settlementMinimum;
    }

    /**
     * Sets settlement minimum
     *
     * @param array $settlementMinimum the settlement minimum
     */
    public function setSettlementMinimum(array $settlementMinimum): void
    {
        $this->settlementMinimum = $settlementMinimum;
    }

    /**
     * Gets currency data as array
     *
     * @return array currency data as array
     */
    public function toArray(): array
    {
        $elements = [
            'code'              => $this->getCode(),
            'symbol'            => $this->getSymbol(),
            'precision'         => $this->getPrecision(),
            'currentlySettled'  => $this->getCurrentlySettled(),
            'name'              => $this->getName(),
            'plural'            => $this->getPlural(),
            'alts'              => $this->getAlts(),
            'minimum'           => $this->getMinimum(),
            'sanctioned'        => $this->getSanctioned(),
            'decimals'          => $this->getDecimals(),
            'payoutFields'      => $this->getPayoutFields(),
            'settlementMinimum' => $this->getSettlementMinimum(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
