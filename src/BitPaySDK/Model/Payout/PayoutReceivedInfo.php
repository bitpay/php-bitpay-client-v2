<?php

declare(strict_types=1);

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

/**
 *
 * @package Bitpay
 */
class PayoutReceivedInfo
{
    protected ?string $name = null;
    protected ?string $email = null;
    protected ?PayoutReceivedInfoAddress $address = null;

    /**
     * PayoutReceivedInfo constructor.
     */
    public function __construct()
    {
    }

    /**
     * Gets name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets name.
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets email.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Sets email.
     *
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Gets address.
     *
     * @return PayoutReceivedInfoAddress|null
     */
    public function getAddress(): ?PayoutReceivedInfoAddress
    {
        return $this->address;
    }

    /**
     * Sets address.
     *
     * @param PayoutReceivedInfoAddress $address
     */
    public function setAddress(PayoutReceivedInfoAddress $address): void
    {
        $this->address = $address;
    }

    /**
     * Return array with values of all fields.
     *
     * @return array
     */
    public function toArray(): array
    {
        /**
         * @todo In a future version, instead of removing values that are not
         *       set, update this logic to only include elements that *are*
         *       set. This will mitigate errors when calling toArray() on
         *       elements that are not set. This should be done universally.
         */
        $elements = [
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'address' => $this->getAddress()->toArray(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
