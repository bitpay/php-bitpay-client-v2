<?php

declare(strict_types=1);

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * Object containing the refund request parameters.
 */
class RefundParams
{
    protected ?string $requesterType = null;
    protected ?string $requesterEmail = null;
    protected ?float $amount = null;
    protected ?string $currency = null;
    protected ?string $email = null;
    protected ?string $purchaserNotifyEmail = null;
    protected ?string $refundAddress = null;
    protected ?string $supportRequestEid = null;

    public function __construct()
    {
    }

    /**
     * Gets Requester type
     *
     * Set to "purchaser"
     *
     * @return string|null requester type
     */
    public function getRequesterType(): ?string
    {
        return $this->requesterType;
    }

    /**
     * Sets requester type
     *
     * Set to "purchaser"
     *
     * @param string $requesterType the requester type
     * @return void
     */
    public function setRequesterType(string $requesterType): void
    {
        $this->requesterType = $requesterType;
    }

    /**
     * Gets Purchaser's email address stored on the invoice
     *
     * @return string|null purchaser's email address stored on the invoice
     */
    public function getRequesterEmail(): ?string
    {
        return $this->requesterEmail;
    }

    /**
     * Sets Purchaser's email address stored on the invoice
     *
     * @param string $requesterEmail purchaser's email address stored on the invoice
     */
    public function setRequesterEmail(string $requesterEmail): void
    {
        $this->requesterEmail = $requesterEmail;
    }

    /**
     * Gets Amount to be refunded in the currency indicated in the refund object.
     *
     * @return float|null the amounts
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * Sets Amount to be refunded in the currency indicated in the refund object.
     *
     * @param float $amount the amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Get currency
     *
     * Reference currency used for the refund, usually the same as the currency used to create the invoice.
     *
     * @return string|null the currency
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Sets currency
     *
     * Reference currency used for the refund, usually the same as the currency used to create the invoice.
     *
     * @param string $currency the currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Gets Purchaser's email address stored on the invoice
     *
     * @return string|null purchaser's email address stored on the invoice
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Sets Purchaser's email address stored on the invoice
     *
     * @param string $email purchaser's email address stored on the invoice
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Gets purchaser notify email.
     *
     * Email address to which the refund link was sent.
     * This is equal to the refundEmail used when submitting the refund request.
     *
     * @return string|null the purchaser notify email
     */
    public function getPurchaserNotifyEmail(): ?string
    {
        return $this->purchaserNotifyEmail;
    }

    /**
     * Sets purchaser notify email.
     *
     * Email address to which the refund link was sent.
     * This is equal to the refundEmail used when submitting the refund request.
     *
     * @param string $purchaserNotifyEmail the purchaser notify email
     */
    public function setPurchaserNotifyEmail(string $purchaserNotifyEmail): void
    {
        $this->purchaserNotifyEmail = $purchaserNotifyEmail;
    }

    /**
     * Gets refund address.
     *
     * Contains the cryptocurrency address provided by the customer via the refund link which was emailed to him.
     *
     * @return string|null the refund address
     */
    public function getRefundAddress(): ?string
    {
        return $this->refundAddress;
    }

    /**
     * Sets refund address.
     *
     * Contains the cryptocurrency address provided by the customer via the refund link which was emailed to him.
     *
     * @param string $refundAddress the refund address
     */
    public function setRefundAddress(string $refundAddress): void
    {
        $this->refundAddress = $refundAddress;
    }

    /**
     * Gets support request eid.
     *
     * Contains the refund requestId.
     *
     * @return string|null the support request eid
     */
    public function getSupportRequestEid(): ?string
    {
        return $this->supportRequestEid;
    }

    /**
     * Sets support request eid.
     *
     * Contains the refund requestId.
     *
     * @param string $supportRequestEid the support request eid
     */
    public function setSupportRequestEid(string $supportRequestEid): void
    {
        $this->supportRequestEid = $supportRequestEid;
    }

    /**
     * Gets RefundParams as array
     *
     * @return array RefundParams as array
     */
    public function toArray(): array
    {
        return [
            'requesterType' => $this->getRequesterType(),
            'requesterEmail' => $this->getRequesterEmail(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'email' => $this->getEmail(),
            'purchaserNotifyEmail' => $this->getPurchaserNotifyEmail(),
            'refundAddress' => $this->getRefundAddress(),
        ];
    }
}
