<?php

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

/**
 * Class PayoutInstructionBtcSummary
 * @package BitPaySDK\Model\Payout
 */
class PayoutInstructionBtcSummary
{
    protected float $paid;
    protected float $unpaid;

    /**
     * PayoutInstructionBtcSummary constructor.
     * @param float $paid
     * @param float $unpaid
     */
    public function __construct(float $paid, float $unpaid)
    {
        $this->paid = $paid;
        $this->unpaid = $unpaid;
    }

    /**
     * Gets paid.
     *
     * @return float
     */
    public function getPaid(): float
    {
        return $this->paid;
    }

    /**
     * Sets paid.
     *
     * @return float
     */
    public function getUnpaid(): float
    {
        return $this->unpaid;
    }

    /**
     * Return an array with paid and unpaid value.
     *
     * @return float[]
     */
    public function toArray(): array
    {
        return [
            'paid' => $this->getPaid(),
            'unpaid' => $this->getUnpaid(),
        ];
    }
}
