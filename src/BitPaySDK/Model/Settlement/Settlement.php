<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Settlement;

use BitPaySDK\Exceptions\SettlementException;

/**
 * Settlement data object.
 * @see <a href="https://bitpay.readme.io/reference/settlements">Settlements</a>
 */
class Settlement
{
    protected ?string $id = null;
    protected ?string $accountId = null;
    protected ?string $currency = null;
    protected ?PayoutInfo $payoutInfo = null;
    protected ?string $status = null;
    protected ?string $dateCreated = null;
    protected ?string $dateExecuted = null;
    protected ?string $dateCompleted = null;
    protected ?string $openingDate = null;
    protected ?string $closingDate = null;
    protected ?float $openingBalance = null;
    protected ?float $ledgerEntriesSum = null;
    protected array $withHoldings = [];
    protected ?float $withHoldingsSum = null;
    protected ?float $totalAmount = null;
    protected array $ledgerEntries = [];
    protected ?string $token = null;

    public function __construct()
    {
    }

    /**
     * Gets id
     *
     * String identifying the settlement; this id will also be in the description of the corresponding bank settlement.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets id
     *
     * String identifying the settlement; this id will also be in the description of the corresponding bank settlement.
     *
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets account id
     *
     * String identifying the BitPay merchant. For internal use, this field can be ignored in merchant implementations.
     *
     * @return string|null
     */
    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    /**
     * Sets account id
     *
     * String identifying the BitPay merchant. For internal use, this field can be ignored in merchant implementations.
     *
     * @param string $accountId
     */
    public function setAccountId(string $accountId): void
    {
        $this->accountId = $accountId;
    }

    /**
     * Gets currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the settlement.
     * Supported settlement currencies are listed on https://bitpay.com/docs/settlement
     *
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Sets currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the settlement.
     * Supported settlement currencies are listed on https://bitpay.com/docs/settlement
     *
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Gets Object containing the settlement info provided by the Merchant in his BitPay account settings
     *
     * @return PayoutInfo|null
     */
    public function getPayoutInfo(): ?PayoutInfo
    {
        return $this->payoutInfo;
    }

    /**
     * Sets Object containing the settlement info provided by the Merchant in his BitPay account settings
     *
     * @param PayoutInfo $payoutInfo
     */
    public function setPayoutInfo(PayoutInfo $payoutInfo): void
    {
        $this->payoutInfo = $payoutInfo;
    }

    /**
     * Gets Status of the settlement. Possible statuses are "new", "processing", "rejected" and "completed".
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status of the settlement. Possible statuses are "new", "processing", "rejected" and "completed".
     *
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Gets date created
     *
     * Timestamp when the settlement was created. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string|null
     */
    public function getDateCreated(): ?string
    {
        return $this->dateCreated;
    }

    /**
     * Sets date created
     *
     * Timestamp when the settlement was created. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $dateCreated
     */
    public function setDateCreated(string $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * Gets date executed
     *
     * Timestamp when the settlement was executed. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string|null
     */
    public function getDateExecuted(): ?string
    {
        return $this->dateExecuted;
    }

    /**
     * Sets date executed
     *
     * Timestamp when the settlement was executed. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $dateExecuted
     */
    public function setDateExecuted(string $dateExecuted): void
    {
        $this->dateExecuted = $dateExecuted;
    }

    /**
     * Gets date completed
     *
     * Timestamp when the settlement was completed. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string|null
     */
    public function getDateCompleted(): ?string
    {
        return $this->dateCompleted;
    }

    /**
     * Sets date completed
     *
     * Timestamp when the settlement was completed. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $dateCompleted
     */
    public function setDateCompleted(string $dateCompleted): void
    {
        $this->dateCompleted = $dateCompleted;
    }

    /**
     * Gets opening date
     *
     * corresponds to the closingDate of the previous settlement executed.
     * For the first settlement of an account the value will be the BitPay merchant account creation date.
     * UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string|null
     */
    public function getOpeningDate(): ?string
    {
        return $this->openingDate;
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
    public function setOpeningDate(string $openingDate): void
    {
        $this->openingDate = $openingDate;
    }

    /**
     * Gets closing date.
     *
     * Date & time for last ledger entry used for the settlement. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string|null
     */
    public function getClosingDate(): ?string
    {
        return $this->closingDate;
    }

    /**
     * Sets closing date.
     *
     * Date & time for last ledger entry used for the settlement. UTC date, ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $closingDate
     */
    public function setClosingDate(string $closingDate): void
    {
        $this->closingDate = $closingDate;
    }

    /**
     * Gets Balance of the ledger at the openingDate
     *
     * @return float|null
     */
    public function getOpeningBalance(): ?float
    {
        return $this->openingBalance;
    }

    /**
     * Sets Balance of the ledger at the openingDate
     *
     * @param float $openingBalance
     */
    public function setOpeningBalance(float $openingBalance): void
    {
        $this->openingBalance = $openingBalance;
    }

    /**
     * Gets ledger entries sum.
     *
     * Sum of all ledger entries in the settlement, this means all the debits & credits
     * which happened between openingDate and closingDate
     *
     * @return float|null
     */
    public function getLedgerEntriesSum(): ?float
    {
        return $this->ledgerEntriesSum;
    }

    /**
     * Sets ledger entries sum.
     *
     * Sum of all ledger entries in the settlement, this means all the debits & credits
     * which happened between openingDate and closingDate
     *
     * @param float $ledgerEntriesSum
     */
    public function setLedgerEntriesSum(float $ledgerEntriesSum): void
    {
        $this->ledgerEntriesSum = $ledgerEntriesSum;
    }

    /**
     * Gets with holdings
     *
     * Array of withholdings. Withholdings are kept on the ledger to be used later and thus withheld
     * from this settlement. Each withholding is a JSON object containing a code, amount and description field.
     *
     * @return WithHoldings[]
     */
    public function getWithHoldings(): array
    {
        return $this->withHoldings;
    }

    /**
     * Sets with holdings
     *
     * Array of withholdings. Withholdings are kept on the ledger to be used later and thus withheld
     * from this settlement. Each withholding is a JSON object containing a code, amount and description field.
     *
     * @param WithHoldings[] $withHoldings
     * @throws SettlementException
     */
    public function setWithHoldings(array $withHoldings): void
    {
        foreach ($withHoldings as $withHolding) {
            if (!$withHolding instanceof WithHoldings) {
                throw new SettlementException('Array should contains only WithHoldings objects');
            }
        }

        $this->withHoldings = $withHoldings;
    }

    /**
     * Gets Sum of all amounts that are withheld from settlement
     *
     * @return float|null
     */
    public function getWithHoldingsSum(): ?float
    {
        return $this->withHoldingsSum;
    }

    /**
     * Sets Sum of all amounts that are withheld from settlement
     *
     * @param float $withHoldingsSum
     */
    public function setWithHoldingsSum(float $withHoldingsSum): void
    {
        $this->withHoldingsSum = $withHoldingsSum;
    }

    /**
     * Gets total amount sent to the merchant; 2 decimals.
     *
     * totalAmount = openingBalance + ledgerEntriesSum - withholdingsSum
     *
     * @return float|null
     */
    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    /**
     * Sets total amount sent to the merchant; 2 decimals.
     *
     * totalAmount = openingBalance + ledgerEntriesSum - withholdingsSum
     *
     * @param float $totalAmount
     */
    public function setTotalAmount(float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * Gets Array of ledger entries listing the various debits and credits which are settled in the report.
     *
     * The total sum of all ledger entries is reported in the field ledgerEntriesSum.
     * A description of all ledger codes can be found
     *
     * @return SettlementLedgerEntry[]
     */
    public function getLedgerEntries(): array
    {
        return $this->ledgerEntries;
    }

    /**
     * Sets Array of ledger entries listing the various debits and credits which are settled in the report.
     *
     * The total sum of all ledger entries is reported in the field ledgerEntriesSum.
     * A description of all ledger codes can be found
     *
     * @param SettlementLedgerEntry[] $ledgerEntries
     * @throws SettlementException
     */
    public function setLedgerEntries(array $ledgerEntries): void
    {
        foreach ($ledgerEntries as $ledgerEntry) {
            if (!$ledgerEntry instanceof SettlementLedgerEntry) {
                throw new SettlementException('Array should contains only SettlementLedgerEntry objects');
            }
        }
        $this->ledgerEntries = $ledgerEntries;
    }

    /**
     * Gets API token for the corresponding settlement resource.
     *
     * This token is actually derived from the merchant facade token used during the query.
     * This token is required to fetch the reconciliation report
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Sets API token for the corresponding settlement resource.
     *
     * This token is actually derived from the merchant facade token used during the query.
     * This token is required to fetch the reconciliation report
     *
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Returns the Settlement object as array
     *
     * @return array
     */
    public function toArray(): array
    {
        $ledgerEntries = [];
        foreach ($this->getLedgerEntries() as $item) {
            $ledgerEntries[] = $item->toArray();
        }

        $withHoldings = [];
        foreach ($this->getWithHoldings() as $withHolding) {
            $withHoldings[] = $withHolding->toArray();
        }

        return [
            'id' => $this->getId(),
            'accountId' => $this->getAccountId(),
            'currency' => $this->getCurrency(),
            'payoutInfo' => $this->getPayoutInfo(),
            'status' => $this->getStatus(),
            'dateCreated' => $this->getDateCreated(),
            'dateExecuted' => $this->getDateExecuted(),
            'dateCompleted' => $this->getDateCompleted(),
            'openingDate' => $this->getOpeningDate(),
            'closingDate' => $this->getClosingDate(),
            'openingBalance' => $this->getOpeningBalance(),
            'ledgerEntriesSum' => $this->getLedgerEntriesSum(),
            'withHoldings' => $withHoldings,
            'withHoldingsSum' => $this->getWithHoldingsSum(),
            'totalAmount' => $this->getTotalAmount(),
            'ledgerEntries' => $ledgerEntries,
            'token' => $this->getToken(),
        ];
    }
}
