<?php

/**
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
    protected $_paid;
    protected $_unpaid;

    /**
     * PayoutInstructionBtcSummary constructor.
     * @param float $paid
     * @param float $unpaid
     */
    public function __construct(float $paid, float $unpaid)
    {
        $this->_paid = $paid;
        $this->_unpaid = $unpaid;
    }

    /**
     * Gets paid.
     *
     * @return float
     */
    public function getPaid()
    {
        return $this->_paid;
    }

    /**
     * Sets paid.
     *
     * @return float
     */
    public function getUnpaid()
    {
        return $this->_unpaid;
    }

    /**
     * Return an array with paid and unpaid value.
     *
     * @return float[]
     */
    public function toArray()
    {
        $elements = [
            'paid'   => $this->getPaid(),
            'unpaid' => $this->getUnpaid(),
        ];

        return $elements;
    }
}
