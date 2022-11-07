<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model;

use Exception;
use ReflectionClass;

/**
 * Object containing currency information
 */
class Currency
{
    // Crypto
    const BCH  = "BCH";
    const BTC  = "BTC";
    const ETH  = "ETH";
    const USDC = "USDC";
    const GUSD = "GUSD";
    const PAX  = "PAX";
    const XRP  = "XRP";
    const BUSD = "BUSD";
    const DOGE = "DOGE";
    const LTC  = "LTC";
    const SHIB  = "SHIB";

    // FIAT
    const AED = "AED";
    const AFN = "AFN";
    const ALL = "ALL";
    const AMD = "AMD";
    const ANG = "ANG";
    const AOA = "AOA";
    const ARS = "ARS";
    const AUD = "AUD";
    const AWG = "AWG";
    const AZN = "AZN";
    const BAM = "BAM";
    const BBD = "BBD";
    const BDT = "BDT";
    const BGN = "BGN";
    const BHD = "BHD";
    const BIF = "BIF";
    const BMD = "BMD";
    const BND = "BND";
    const BOB = "BOB";
    const BOV = "BOV";
    const BRL = "BRL";
    const BSD = "BSD";
    const BTN = "BTN";
    const BWP = "BWP";
    const BYR = "BYR";
    const BZD = "BZD";
    const CAD = "CAD";
    const CDF = "CDF";
    const CHE = "CHE";
    const CHF = "CHF";
    const CHW = "CHW";
    const CLF = "CLF";
    const CLP = "CLP";
    const CNY = "CNY";
    const COP = "COP";
    const COU = "COU";
    const CRC = "CRC";
    const CUC = "CUC";
    const CUP = "CUP";
    const CVE = "CVE";
    const CZK = "CZK";
    const DJF = "DJF";
    const DKK = "DKK";
    const DOP = "DOP";
    const DZD = "DZD";
    const EGP = "EGP";
    const ERN = "ERN";
    const ETB = "ETB";
    const EUR = "EUR";
    const FJD = "FJD";
    const FKP = "FKP";
    const GBP = "GBP";
    const GEL = "GEL";
    const GHS = "GHS";
    const GIP = "GIP";
    const GMD = "GMD";
    const GNF = "GNF";
    const GTQ = "GTQ";
    const GYD = "GYD";
    const HKD = "HKD";
    const HNL = "HNL";
    const HRK = "HRK";
    const HTG = "HTG";
    const HUF = "HUF";
    const IDR = "IDR";
    const ILS = "ILS";
    const INR = "INR";
    const IQD = "IQD";
    const IRR = "IRR";
    const ISK = "ISK";
    const JMD = "JMD";
    const JOD = "JOD";
    const JPY = "JPY";
    const KES = "KES";
    const KGS = "KGS";
    const KHR = "KHR";
    const KMF = "KMF";
    const KPW = "KPW";
    const KRW = "KRW";
    const KWD = "KWD";
    const KYD = "KYD";
    const KZT = "KZT";
    const LAK = "LAK";
    const LBP = "LBP";
    const LKR = "LKR";
    const LRD = "LRD";
    const LSL = "LSL";
    const LYD = "LYD";
    const MAD = "MAD";
    const MDL = "MDL";
    const MGA = "MGA";
    const MKD = "MKD";
    const MMK = "MMK";
    const MNT = "MNT";
    const MOP = "MOP";
    const MRU = "MRU";
    const MUR = "MUR";
    const MVR = "MVR";
    const MWK = "MWK";
    const MXN = "MXN";
    const MXV = "MXV";
    const MYR = "MYR";
    const MZN = "MZN";
    const NAD = "NAD";
    const NGN = "NGN";
    const NIO = "NIO";
    const NOK = "NOK";
    const NPR = "NPR";
    const NZD = "NZD";
    const OMR = "OMR";
    const PAB = "PAB";
    const PEN = "PEN";
    const PGK = "PGK";
    const PHP = "PHP";
    const PKR = "PKR";
    const PLN = "PLN";
    const PYG = "PYG";
    const QAR = "QAR";
    const RON = "RON";
    const RSD = "RSD";
    const RUB = "RUB";
    const RWF = "RWF";
    const SAR = "SAR";
    const SBD = "SBD";
    const SCR = "SCR";
    const SDG = "SDG";
    const SEK = "SEK";
    const SGD = "SGD";
    const SHP = "SHP";
    const SLL = "SLL";
    const SOS = "SOS";
    const SRD = "SRD";
    const SSP = "SSP";
    const STN = "STN";
    const SVC = "SVC";
    const SYP = "SYP";
    const SZL = "SZL";
    const THB = "THB";
    const TJS = "TJS";
    const TMT = "TMT";
    const TND = "TND";
    const TOP = "TOP";
    const TRY = "TRY";
    const TTD = "TTD";
    const TWD = "TWD";
    const TZS = "TZS";
    const UAH = "UAH";
    const UGX = "UGX";
    const USD = "USD";
    const USN = "USN";
    const UYI = "UYI";
    const UYU = "UYU";
    const UZS = "UZS";
    const VEF = "VEF";
    const VND = "VND";
    const VUV = "VUV";
    const WST = "WST";
    const XAF = "XAF";
    const XCD = "XCD";
    const XDR = "XDR";
    const XOF = "XOF";
    const XPF = "XPF";
    const XSU = "XSU";
    const XUA = "XUA";
    const YER = "YER";
    const ZAR = "ZAR";
    const ZMW = "ZMW";
    const ZWL = "ZWL";

    protected $_code;
    protected $_symbol;
    protected $_precision;
    protected $_currentlySettled;
    protected $_name;
    protected $_plural;
    protected $_alts;
    protected $_minimum;
    protected $_sanctioned;
    protected $_decimals;
    protected $_payoutFields;
    protected $_settlementMinimum;

    /**
     * Currency validation
     *
     * @param string $value the currency value
     * @return bool
     */
    public static function isValid($value)
    {
        try {
            $reflect = new ReflectionClass(Currency::class);

            return array_key_exists($value, $reflect->getConstants());
        } catch (Exception $e) {
            return false;
        }
    }

    public function __construct()
    {
    }

    /**
     * Get ISO 4217 3-character currency code
     *
     * @return string the code
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Sets ISO 4217 3-character currency code
     *
     * @param string $code the code
     */
    public function setCode(string $code)
    {
        $this->_code = $code;
    }

    /**
     * Display symbol
     *
     * @return string the symbol
     */
    public function getSymbol()
    {
        return $this->_symbol;
    }

    /**
     * Sets symbol
     *
     * @param string|null $symbol
     */
    public function setSymbol(string $symbol = null)
    {
        $this->_symbol = $symbol;
    }

    /**
     * Number of decimal places
     *
     * @return int the precision
     */
    public function getPrecision()
    {
        return $this->_precision;
    }

    /**
     * Sets number of decimal places
     *
     * @param int $precision the precision
     */
    public function setPrecision(int $precision)
    {
        $this->_precision = $precision;
    }

    /**
     * Gets currently settled value
     *
     * @return bool
     */
    public function getCurrentlySettled()
    {
        return $this->_currentlySettled;
    }

    /**
     * Sets currently settled value
     *
     * @param bool $currentlySettled
     */
    public function setCurrentlySettled(bool $currentlySettled)
    {
        $this->_currentlySettled = $currentlySettled;
    }

    /**
     * Gets currency name
     *
     * @return string the name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets currency name
     *
     * @param string $name the name
     */
    public function setName(string $name)
    {
        $this->_name = $name;
    }

    /**
     * Gets English plural form
     *
     * @return string the plural form
     */
    public function getPlural()
    {
        return $this->_plural;
    }

    /**
     * Sets English plural form
     *
     * @param string $plural the plural form
     */
    public function setPlural(string $plural)
    {
        $this->_plural = $plural;
    }

    /**
     * Gets alternative currency name(s)
     *
     * @return string the alts
     */
    public function getAlts()
    {
        return $this->_alts;
    }

    /**
     * Sets alternative currency name(s)
     *
     * @param string $alts the alts
     */
    public function setAlts(string $alts)
    {
        $this->_alts = $alts;
    }

    /**
     * Gets minimum supported value when creating an invoice, bill or payout for instance
     *
     * @return string the minimum
     */
    public function getMinimum()
    {
        return $this->_minimum;
    }

    /**
     * Sets minimum supported value when creating an invoice, bill or payout for instance
     *
     * @param string $minimum the minimum
     */
    public function setMinimum(string $minimum)
    {
        $this->_minimum = $minimum;
    }

    /**
     * Gets if the currency is linked to a sanctionned country
     *
     * @return bool the sanctioned
     */
    public function getSanctioned()
    {
        return $this->_sanctioned;
    }

    /**
     * Sets if the currency is linked to a sanctionned country
     *
     * @param bool $sanctioned the sanctioned
     */
    public function setSanctioned(bool $sanctioned)
    {
        $this->_sanctioned = $sanctioned;
    }

    /**
     * Gets decimal precision
     *
     * @return string decimals
     */
    public function getDecimals()
    {
        return $this->_decimals;
    }

    /**
     * Sets decimal precision
     *
     * @param string $decimals decimals
     */
    public function setDecimals(string $decimals)
    {
        $this->_decimals = $decimals;
    }

    /**
     * Gets payout fields
     *
     * @return array the payout fields
     */
    public function getPayoutFields()
    {
        return $this->_payoutFields;
    }

    /**
     * Sets payout fields
     *
     * @param array $payoutFields the payout fields
     */
    public function setPayoutFields(array $payoutFields)
    {
        $this->_payoutFields = $payoutFields;
    }

    /**
     * Gets settlement minimum
     *
     * @return array the settlement minimum
     */
    public function getSettlementMinimum()
    {
        return $this->_settlementMinimum;
    }

    /**
     * Sets settlement minimum
     *
     * @param array $settlementMinimum the settlement minimum
     */
    public function setSettlementMinimum(array $settlementMinimum)
    {
        $this->_settlementMinimum = $settlementMinimum;
    }

    /**
     * Gets currency data as array
     *
     * @return array currency data as array
     */
    public function toArray()
    {
        $elements = [
            'code'              => $this->getCode(),
            'symbol'            => $this->getSymbol(),
            'precision'         => $this->getPrecision(),
            'currentlySettled'  => $this->getCurrentlySettled(),
            'name'              => $this->getName(),
            'plural'            => $this->getPlural(),
            'alts'              => $this->getAlts(),
            'minimum'           => $this->getMinimum(),
            'sanctioned'        => $this->getSanctioned(),
            'decimals'          => $this->getDecimals(),
            'payoutFields'      => $this->getPayoutFields(),
            'settlementMinimum' => $this->getSettlementMinimum(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
