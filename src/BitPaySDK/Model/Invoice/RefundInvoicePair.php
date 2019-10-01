<?php


namespace BitPaySDK\Model\Invoice;


class RefundInvoicePair
{
    private $_refund;
    private $_invoice;

    public function __construct(Refund $refund, Invoice $invoice)
    {
        $this->_refund = $refund;
        $this->_invoice = $invoice;
    }

    /**
     * Retrieve the refund.
     *
     * @return Refund object.
     */
    public function getRefund(): Refund
    {
        return $this->_refund;
    }

    /**
     * Retrieve the invoice.
     *
     * @return Invoice object.
     */
    public function getInvoice(): Invoice
    {
        return $this->_invoice;
    }
}