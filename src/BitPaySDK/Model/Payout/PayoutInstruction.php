<?php


namespace BitPaySDK\Model\Payout;


/**
 *
 * @package Bitpay
 */
class PayoutInstruction
{
    const STATUS_PAID  = "paid";
    const MethodVwap24 = "vwap_24hr";

    protected $_amount;
    protected $_address;
    protected $_label = "";
    protected $_walletProvider;

    protected $_id;

    /**
     * @var PayoutInstructionBtcSummary
     */
    protected $_btc;
    protected $_transactions;
    protected $_status;

    /**
     * Constructor, create a PayoutInstruction object.
     *
     * @param $amount  float BTC amount.
     * @param $address string Bitcoin address.
     */
    public function __construct(float $amount = null, string $address = null)
    {
        $this->_amount = $amount;
        $this->_address = $address;
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    public function getAddress()
    {
        return $this->_address;
    }

    public function setAddress(string $address)
    {
        $this->_address = $address;
    }

    public function getLabel()
    {
        return $this->_label;
    }

    public function setLabel(string $label)
    {
        $this->_label = $label;
    }

    public function getWalletProvider()
    {
        return $this->_walletProvider;
    }

    public function setWalletProvider(string $walletProvider)
    {
        $this->_walletProvider = $walletProvider;
    }

    // Response fields
    //

    public function getId()
    {
        return $this->_id;
    }

    public function setId(string $id)
    {
        $this->_id = $id;
    }

    public function getBtc()
    {
        return $this->_btc ? $this->_btc->toArray() : null;
    }

    public function setBtc(PayoutInstructionBtcSummary $btc)
    {
        $this->_btc = $btc;
    }

    public function getTransactions()
    {
        return $this->_transactions;
    }

    public function setTransactions(array $transactions)
    {
        $this->_transactions = $transactions;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    public function toArray()
    {
        $elements = [
            'amount'       => $this->getAmount(),
            'address'      => $this->getAddress(),
            'label'        => $this->getLabel(),
            'id'           => $this->getId(),
            'btc'          => $this->getBtc(),
            'transactions' => $this->getTransactions(),
            'status'       => $this->getStatus(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
