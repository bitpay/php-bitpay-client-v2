<?php


namespace BitPaySDK\Model\Settlement;


class Settlement
{
    protected $_id;
    protected $_accountId;
    protected $_currency;
    protected $_payoutInfo;
    protected $_status;
    protected $_dateCreated;
    protected $_dateExecuted;
    protected $_dateCompleted;
    protected $_openingDate;
    protected $_closingDate;
    protected $_openingBalance;
    protected $_ledgerEntriesSum;
    protected $_withHoldings;
    protected $_withHoldingsSum;
    protected $_totalAmount;
    protected $_ledgerEntries;
    protected $_token;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId(String $id)
    {
        $this->_id = $id;
    }

    public function getAccountId()
    {
        return $this->_accountId;
    }

    public function setAccountId(String $accountId)
    {
        $this->_accountId = $accountId;
    }

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function setCurrency(String $currency)
    {
        $this->_currency = $currency;
    }

    public function getPayoutInfo()
    {
        return $this->_payoutInfo;
    }

    public function setPayoutInfo(PayoutInfo $payoutInfo)
    {
        $this->_payoutInfo = $payoutInfo;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus(String $status)
    {
        $this->_status = $status;
    }

    public function getDateCreated()
    {
        return $this->_dateCreated;
    }

    public function setDateCreated(string $dateCreated)
    {
        $this->_dateCreated = $dateCreated;
    }

    public function getDateExecuted()
    {
        return $this->_dateExecuted;
    }

    public function setDateExecuted(string $dateExecuted)
    {
        $this->_dateExecuted = $dateExecuted;
    }

    public function getDateCompleted()
    {
        return $this->_dateCompleted;
    }

    public function setDateCompleted(string $dateCompleted)
    {
        $this->_dateCompleted = $dateCompleted;
    }

    public function getOpeningDate()
    {
        return $this->_openingDate;
    }

    public function setOpeningDate(string $openingDate)
    {
        $this->_openingDate = $openingDate;
    }

    public function getClosingDate()
    {
        return $this->_closingDate;
    }

    public function setClosingDate(string $closingDate)
    {
        $this->_closingDate = $closingDate;
    }

    public function getOpeningBalance()
    {
        return $this->_openingBalance;
    }

    public function setOpeningBalance(float $openingBalance)
    {
        $this->_openingBalance = $openingBalance;
    }

    public function getLedgerEntriesSum()
    {
        return $this->_ledgerEntriesSum;
    }

    public function setLedgerEntriesSum(float $ledgerEntriesSum)
    {
        $this->_ledgerEntriesSum = $ledgerEntriesSum;
    }

    public function getWithHoldings()
    {
        $withHoldings = [];

        foreach ($this->_withHoldings as $withHolding) {
            if ($withHolding instanceof WithHoldings) {
                array_push($withHoldings, $withHolding->toArray());
            } else {
                array_push($withHoldings, $withHolding);
            }
        }

        return $withHoldings;
    }

    public function setWithHoldings(array $withHoldings)
    {
        $this->_withHoldings = $withHoldings;
    }

    public function getWithHoldingsSum()
    {
        return $this->_withHoldingsSum;
    }

    public function setWithHoldingsSum(float $withHoldingsSum)
    {
        $this->_withHoldingsSum = $withHoldingsSum;
    }

    public function getTotalAmount()
    {
        return $this->_totalAmount;
    }

    public function setTotalAmount(float $totalAmount)
    {
        $this->_totalAmount = $totalAmount;
    }

    public function getLedgerEntries()
    {
        $ledgerEntries = [];

        foreach ($this->_ledgerEntries as $ledgerEntrie) {
            if ($ledgerEntrie instanceof SettlementLedgerEntry) {
                array_push($ledgerEntries, $ledgerEntrie->toArray());
            } else {
                array_push($ledgerEntries, $ledgerEntrie);
            }
        }

        return $ledgerEntries;
    }

    public function setLedgerEntries(array $ledgerEntries)
    {
        $this->_ledgerEntries = $ledgerEntries;
    }

    public function getToken()
    {
        return $this->_token;
    }

    public function setToken(String $token)
    {
        $this->_token = $token;
    }

    public function toArray()
    {
        $elements =
            [
                'id'               => $this->getId(),
                'accountId'        => $this->getAccountId(),
                'currency'         => $this->getCurrency(),
                'payoutInfo'       => $this->getPayoutInfo(),
                'status'           => $this->getStatus(),
                'dateCreated'      => $this->getDateCreated(),
                'dateExecuted'     => $this->getDateExecuted(),
                'dateCompleted'    => $this->getDateCompleted(),
                'openingDate'      => $this->getOpeningDate(),
                'closingDate'      => $this->getClosingDate(),
                'openingBalance'   => $this->getOpeningBalance(),
                'ledgerEntriesSum' => $this->getLedgerEntriesSum(),
                'withHoldings'     => $this->getWithHoldings(),
                'withHoldingsSum'  => $this->getWithHoldingsSum(),
                'totalAmount'      => $this->getTotalAmount(),
                'ledgerEntries'    => $this->getLedgerEntries(),
                'token'            => $this->getToken(),
            ];

        return $elements;
    }
}