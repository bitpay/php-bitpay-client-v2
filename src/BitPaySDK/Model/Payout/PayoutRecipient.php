<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

/**
 * @package Bitpay
 * @see <a href="https://bitpay.readme.io/reference/payouts">REST API Payouts</a>
 */
class PayoutRecipient
{
    protected ?string $email = null;
    protected ?string $guid = null;
    protected ?string $label = null;
    protected ?string $notificationURL = null;
    protected ?string $status = null;
    protected ?string $id = null;
    protected ?string $shopperId = null;
    protected ?string $token = null;

    /**
     * Constructor, create a minimal Recipient object.
     *
     * @param string|null $email string Recipient email address to which the invite shall be sent.
     * @param string|null $label string Recipient nickname assigned by the merchant (Optional).
     * @param string|null $notificationURL string URL to which BitPay sends webhook notifications to inform
     *                         the merchant about the status of a given recipient. HTTPS is mandatory (Optional).
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
            'notificationURL' => $this->getNotificationURL(),
            'status' => $this->getStatus(),
            'id' => $this->getId(),
            'shopperId' => $this->getShopperId(),
            'token' => $this->getToken(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
