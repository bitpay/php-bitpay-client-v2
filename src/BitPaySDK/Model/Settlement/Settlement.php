<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Settlement;

/**
 * Settlement data object
 */
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

    /**
     * Gets id
     *
     * String identifying the settlement; this id will also be in the description of the corresponding bank settlement.
     *
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets id
     *
     * String identifying the settlement; this id will also be in the description of the corresponding bank settlement.
     *
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->_id = $id;
    }

    /**
     * Gets account id
     *
     * String identifying the BitPay merchant. For internal use, this field can be ignored in merchant implementations.
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->_accountId;
    }

    /**
     * Sets account id
     *
     * String identifying the BitPay merchant. For internal use, this field can be ignored in merchant implementations.
     *
     * @param string $accountId
     */
    public function setAccountId(string $accountId)
    {
        $this->_accountId = $accountId;
    }

    /**
     * Gets currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the settlement.
     * Supported settlement currencies are listed on https://bitpay.com/docs/settlement
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * Sets currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the settlement.
     * Supported settlement currencies are listed on https://bitpay.com/docs/settlement
     *
     * @param string $currency
     */
    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    /**
     * Gets Object containing the settlement info provided by the Merchant in his BitPay account settings
     *
     * @return PayoutInfo
     */
    public function getPayoutInfo()
    {
        return $this->_payoutInfo;
    }

    /**
     * Sets Object containing the settlement info provided by the Merchant in his BitPay account settings
     *
     * @param PayoutInfo $payoutInfo
     */
    public function setPayoutInfo(PayoutInfo $payoutInfo)
    {
        $this->_payoutInfo = $payoutInfo;
    }

    /**
     * Gets Status of the settlement. Possible statuses are "new", "processing", "rejected" and "completed".
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Sets Status of the settlement. Possible statuses are "new", "processing", "rejected" and "completed".
     *
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    /**
     * Gets date created
     *
     * Timestamp when the settlement was created. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string
     */
    public function getDateCreated()
    {
        return $this->_dateCreated;
    }

    /**
     * Sets date created
     *
     * Timestamp when the settlement was created. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $dateCreated
     */
    public function setDateCreated(string $dateCreated)
    {
        $this->_dateCreated = $dateCreated;
    }

    /**
     * Gets date executed
     *
     * Timestamp when the settlement was executed. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string
     */
    public function getDateExecuted()
    {
        return $this->_dateExecuted;
    }

    /**
     * Sets date executed
     *
     * Timestamp when the settlement was executed. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $dateExecuted
     */
    public function setDateExecuted(string $dateExecuted)
    {
        $this->_dateExecuted = $dateExecuted;
    }

    /**
     * Gets date completed
     *
     * Timestamp when the settlement was completed. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string
     */
    public function getDateCompleted()
    {
        return $this->_dateCompleted;
    }

    /**
     * Sets date completed
     *
     * Timestamp when the settlement was completed. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $dateCompleted
     */
    public function setDateCompleted(string $dateCompleted)
    {
        $this->_dateCompleted = $dateCompleted;
    }

    /**
     * Gets opening date
     *
     * corresponds to the closingDate of the previous settlement executed.
     * For the first settlement of an account the value will be the BitPay merchant account creation date.
     * UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string
     */
    public function getOpeningDate()
    {
        return $this->_openingDate;
    }

    /**
     * Sets opening date
     *
     * corresponds to the closingDate of the previous settlement executed.
     * For the first settlement of an account the value will be the BitPay merchant account creation date.
     * UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $openingDate
     */
    public function setOpeningDate(string $openingDate)
    {
        $this->_openingDate = $openingDate;
    }

    /**
     * Gets closing date.
     *
     * Date & time for last ledger entry used for the settlement. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string
     */
    public function getClosingDate()
    {
        return $this->_closingDate;
    }

    /**
     * Sets closing date.
     *
     * Date & time for last ledger entry used for the settlement. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $closingDate
     */
    public function setClosingDate(string $closingDate)
    {
        $this->_closingDate = $closingDate;
    }

    /**
     * Gets Balance of the ledger at the openingDate
     *
     * @return float
     */
    public function getOpeningBalance()
    {
        return $this->_openingBalance;
    }

    /**
     * Sets Balance of the ledger at the openingDate
     *
     * @param float $openingBalance
     */
    public function setOpeningBalance(float $openingBalance)
    {
        $this->_openingBalance = $openingBalance;
    }

    /**
     * Gets ledger entries sum.
     *
     * Sum of all ledger entries in the settlement, this means all the debits & credits
     * which happened between openingDate and closingDate
     *
     * @return mixed
     */
    public function getLedgerEntriesSum()
    {
        return $this->_ledgerEntriesSum;
    }

    /**
     * Sets ledger entries sum.
     *
     * Sum of all ledger entries in the settlement, this means all the debits & credits
     * which happened between openingDate and closingDate
     *
     * @param float $ledgerEntriesSum
     */
    public function setLedgerEntriesSum(float $ledgerEntriesSum)
    {
        $this->_ledgerEntriesSum = $ledgerEntriesSum;
    }

    /**
     * Gets with holdings
     *
     * Array of withholdings. Withholdings are kept on the ledger to be used later and thus withheld
     * from this settlement. Each withholding is a JSON object containing a code, amount and description field.
     *
     * @return array
     */
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

    /**
     * Sets with holdings
     *
     * Array of withholdings. Withholdings are kept on the ledger to be used later and thus withheld
     * from this settlement. Each withholding is a JSON object containing a code, amount and description field.
     *
     * @param array $withHoldings
     */
    public function setWithHoldings(array $withHoldings)
    {
        $this->_withHoldings = $withHoldings;
    }

    /**
     * Gets Sum of all amounts that are withheld from settlement
     *
     * @return float
     */
    public function getWithHoldingsSum()
    {
        return $this->_withHoldingsSum;
    }

    /**
     * Sets Sum of all amounts that are withheld from settlement
     *
     * @param float $withHoldingsSum
     */
    public function setWithHoldingsSum(float $withHoldingsSum)
    {
        $this->_withHoldingsSum = $withHoldingsSum;
    }

    /**
     * Gets total amount sent to the merchant; 2 decimals.
     *
     * totalAmount = openingBalance + ledgerEntriesSum - withholdingsSum
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->_totalAmount;
    }

    /**
     * Sets total amount sent to the merchant; 2 decimals.
     *
     * totalAmount = openingBalance + ledgerEntriesSum - withholdingsSum
     *
     * @param float $totalAmount
     */
    public function setTotalAmount(float $totalAmount)
    {
        $this->_totalAmount = $totalAmount;
    }

    /**
     * Gets Array of ledger entries listing the various debits and credits which are settled in the report.
     *
     * The total sum of all ledger entries is reported in the field ledgerEntriesSum.
     * A description of all ledger codes can be found
     *
     * @return array
     */
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

    /**
     * Sets Array of ledger entries listing the various debits and credits which are settled in the report.
     *
     * The total sum of all ledger entries is reported in the field ledgerEntriesSum.
     * A description of all ledger codes can be found
     *
     * @param array $ledgerEntries
     */
    public function setLedgerEntries(array $ledgerEntries)
    {
        $this->_ledgerEntries = $ledgerEntries;
    }

    /**
     * Gets API token for the corresponding settlement resource.
     *
     * This token is actually derived from the merchant facade token used during the query.
     * This token is required to fetch the reconciliation report
     *
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Sets API token for the corresponding settlement resource.
     *
     * This token is actually derived from the merchant facade token used during the query.
     * This token is required to fetch the reconciliation report
     *
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    /**
     * Returns the Settlement object as array
     *
     * @return array
     */
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
