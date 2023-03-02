<?php

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

/**
 *
 * @package Bitpay
 */
class PayoutRecipient
{
    protected ?string $email = null;
    protected ?string $guid = null;
    protected ?string $label = null;
    protected ?string $reference = null;
    protected ?string $notificationURL = null;
    protected ?string $account = null;
    protected ?string $status = null;
    protected ?string $id = null;
    protected ?string $shopperId = null;
    protected ?string $token = null;
    protected ?string $supportPhone = null;

    /**
     * Constructor, create a minimal Recipient object.
     *
     * @param string|null $email string Recipient email address to which the invite shall be sent.
     * @param string|null $label string Recipient nickname assigned by the merchant (Optional).
     * @param string|null $notificationURL string URL to which BitPay sends webhook notifications to inform the merchant about the
     *                         status of a given recipient. HTTPS is mandatory (Optional).
     */
    public function __construct(string $email = null, string $label = null, string $notificationURL = null)
    {
        $this->email = $email;
        $this->label = $label;
        $this->notificationURL = $notificationURL;
    }

    // Required fields
    //

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
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    // Optional fields
    //

    /**
     * Gets guid.
     *
     * @return string|null
     */
    public function getGuid(): ?string
    {
        return $this->guid;
    }

    /**
     * Sets guid.
     *
     * @param string $guid
     */
    public function setGuid(string $guid): void
    {
        $this->guid = $guid;
    }

    /**
     * Gets label.
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Sets label.
     *
     * @param string|null $label
     */
    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    /**
     * Gets reference.
     *
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Sets reference.
     *
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * Gets notification url.
     *
     * @return string|null
     */
    public function getNotificationURL(): ?string
    {
        return $this->notificationURL;
    }

    /**
     * Sets notification url.
     *
     * @param string|null $notificationURL
     */
    public function setNotificationURL(?string $notificationURL): void
    {
        $this->notificationURL = $notificationURL;
    }

    // Response fields
    //

    /**
     * Gets account.
     *
     * @return string|null
     */
    public function getAccount(): ?string
    {
        return $this->account;
    }

    /**
     * Sets account.
     *
     * @param string $account
     */
    public function setAccount(string $account): void
    {
        $this->account = $account;
    }

    /**
     * Gets status.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets status.
     *
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Gets id.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets id.
     *
     * @param string|null $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets Shopper ID.
     *
     * @return string|null
     */
    public function getShopperId(): ?string
    {
        return $this->shopperId;
    }

    /**
     * Sets Shopper ID.
     *
     * @param string|null $shopperId
     */
    public function setShopperId(?string $shopperId): void
    {
        $this->shopperId = $shopperId;
    }

    /**
     * Gets token.
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Sets token.
     *
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Gets support phone.
     *
     * @return string|null
     */
    public function getSupportPhone(): ?string
    {
        return $this->supportPhone;
    }

    /**
     * Sets support phone.
     *
     * @param string $supportPhone
     */
    public function setSupportPhone(string $supportPhone): void
    {
        $this->supportPhone = $supportPhone;
    }

    /**
     * Return an array with values of all fields.
     *
     * @return array
     */
    public function toArray(): array
    {
        $elements = [
            'email' => $this->getEmail(),
            'guid' => $this->getGuid(),
            'label' => $this->getLabel(),
            'reference' => $this->getReference(),
            'notificationURL' => $this->getNotificationURL(),
            'account' => $this->getAccount(),
            'status' => $this->getStatus(),
            'id' => $this->getId(),
            'shopperId' => $this->getShopperId(),
            'token' => $this->getToken(),
            'supportPhone' => $this->getSupportPhone()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
