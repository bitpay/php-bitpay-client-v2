<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Invoice;

/**
 * Class SupportedTransactionCurrencies. The currencies that may be used to pay this invoice.
 *
 * @package BitPaySDK\Model\Invoice
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see https://bitpay.readme.io/reference/invoices REST API Invoices
 */
class SupportedTransactionCurrencies
{
    protected SupportedTransactionCurrency $btc;
    protected SupportedTransactionCurrency $bch;
    protected SupportedTransactionCurrency $eth;
    protected SupportedTransactionCurrency $usdc;
    protected SupportedTransactionCurrency $gusd;
    protected SupportedTransactionCurrency $pax;
    protected SupportedTransactionCurrency $xrp;
    protected SupportedTransactionCurrency $busd;
    protected SupportedTransactionCurrency $doge;
    protected SupportedTransactionCurrency $ltc;
    protected SupportedTransactionCurrency $wbtc;
    protected SupportedTransactionCurrency $dai;
    protected SupportedTransactionCurrency $euroc;
    protected SupportedTransactionCurrency $matic;
    protected SupportedTransactionCurrency $maticE;
    protected SupportedTransactionCurrency $ethM;
    protected SupportedTransactionCurrency $usdcM;
    protected SupportedTransactionCurrency $busdM;
    protected SupportedTransactionCurrency $daiM;
    protected SupportedTransactionCurrency $wbtcM;
    protected SupportedTransactionCurrency $shibM;

    /**
     * SupportedTransactionCurrencies constructor.
     */
    public function __construct()
    {
        $this->btc = new SupportedTransactionCurrency();
        $this->bch = new SupportedTransactionCurrency();
        $this->eth = new SupportedTransactionCurrency();
        $this->usdc = new SupportedTransactionCurrency();
        $this->gusd = new SupportedTransactionCurrency();
        $this->pax = new SupportedTransactionCurrency();
        $this->xrp = new SupportedTransactionCurrency();
        $this->busd = new SupportedTransactionCurrency();
        $this->doge = new SupportedTransactionCurrency();
        $this->ltc = new SupportedTransactionCurrency();
        $this->wbtc = new SupportedTransactionCurrency();
        $this->dai = new SupportedTransactionCurrency();
        $this->euroc = new SupportedTransactionCurrency();
        $this->matic = new SupportedTransactionCurrency();
        $this->maticE = new SupportedTransactionCurrency();
        $this->ethM = new SupportedTransactionCurrency();
        $this->usdcM = new SupportedTransactionCurrency();
        $this->busdM = new SupportedTransactionCurrency();
        $this->daiM = new SupportedTransactionCurrency();
        $this->wbtcM = new SupportedTransactionCurrency();
        $this->shibM = new SupportedTransactionCurrency();
    }

    /**
     * Gets BTC.
     *
     * @return SupportedTransactionCurrency
     */
    public function getBTC(): SupportedTransactionCurrency
    {
        return $this->btc;
    }

    /**
     * Sets BTC.
     *
     * @param SupportedTransactionCurrency $btc the BTC
     */
    public function setBTC(SupportedTransactionCurrency $btc): void
    {
        $this->btc = $btc;
    }

    /**
     * Gets BCH.
     *
     * @return SupportedTransactionCurrency
     */
    public function getBCH(): SupportedTransactionCurrency
    {
        return $this->bch;
    }

    /**
     * Sets BCH.
     *
     * @param SupportedTransactionCurrency $bch the BCH
     */
    public function setBCH(SupportedTransactionCurrency $bch): void
    {
        $this->bch = $bch;
    }

    /**
     * Gets ETH.
     *
     * @return SupportedTransactionCurrency
     */
    public function getETH(): SupportedTransactionCurrency
    {
        return $this->eth;
    }

    /**
     * Sets ETH.
     *
     * @param SupportedTransactionCurrency $eth the ETH
     */
    public function setETH(SupportedTransactionCurrency $eth): void
    {
        $this->eth = $eth;
    }

    /**
     * Gets USDC.
     *
     * @return SupportedTransactionCurrency
     */
    public function getUSDC(): SupportedTransactionCurrency
    {
        return $this->usdc;
    }

    /**
     * Sets USDC.
     *
     * @param SupportedTransactionCurrency $usdc the USDC
     */
    public function setUSDC(SupportedTransactionCurrency $usdc): void
    {
        $this->usdc = $usdc;
    }

    /**
     * Gets GUSD.
     *
     * @return SupportedTransactionCurrency
     */
    public function getGUSD(): SupportedTransactionCurrency
    {
        return $this->gusd;
    }

    /**
     * Sets GUSD.
     *
     * @param SupportedTransactionCurrency $gusd the GUSD
     */
    public function setGUSD(SupportedTransactionCurrency $gusd): void
    {
        $this->gusd = $gusd;
    }

    /**
     * Gets PAX.
     *
     * @return SupportedTransactionCurrency
     */
    public function getPAX(): SupportedTransactionCurrency
    {
        return $this->pax;
    }

    /**
     * Sets PAX.
     *
     * @param SupportedTransactionCurrency $pax the PAX
     */
    public function setPAX(SupportedTransactionCurrency $pax): void
    {
        $this->pax = $pax;
    }

    /**
     * Gets XRP.
     *
     * @return SupportedTransactionCurrency
     */
    public function getXRP(): SupportedTransactionCurrency
    {
        return $this->xrp;
    }

    /**
     * Sets XRP.
     *
     * @param SupportedTransactionCurrency $xrp the XRP
     */
    public function setXRP(SupportedTransactionCurrency $xrp): void
    {
        $this->xrp = $xrp;
    }

    /**
     * Gets BUSD.
     *
     * @return SupportedTransactionCurrency
     */
    public function getBUSD(): SupportedTransactionCurrency
    {
        return $this->busd;
    }

    /**
     * Sets BUSD.
     *
     * @param SupportedTransactionCurrency $busd
     */
    public function setBUSD(SupportedTransactionCurrency $busd): void
    {
        $this->busd = $busd;
    }

    /**
     * Gets DOGE.
     *
     * @return SupportedTransactionCurrency
     */
    public function getDOGE(): SupportedTransactionCurrency
    {
        return $this->doge;
    }

    /**
     * Sets DOGE.
     *
     * @param SupportedTransactionCurrency $doge
     */
    public function setDOGE(SupportedTransactionCurrency $doge): void
    {
        $this->doge = $doge;
    }

    /**
     * Gets LTC.
     *
     * @return SupportedTransactionCurrency
     */
    public function getLTC(): SupportedTransactionCurrency
    {
        return $this->ltc;
    }

    /**
     * Sets LTC.
     *
     * @param SupportedTransactionCurrency $ltc
     */
    public function setLTC(SupportedTransactionCurrency $ltc): void
    {
        $this->ltc = $ltc;
    }

    /**
     * Gets WBTC.
     *
     * @return SupportedTransactionCurrency
     */
    public function getWBTC(): SupportedTransactionCurrency
    {
        return $this->wbtc;
    }

    /**
     * Sets WBTC.
     *
     * @param SupportedTransactionCurrency $wbtc
     */
    public function setWBTC(SupportedTransactionCurrency $wbtc): void
    {
        $this->wbtc = $wbtc;
    }

    /**
     * Gets DAI.
     *
     * @return SupportedTransactionCurrency
     */
    public function getDAI(): SupportedTransactionCurrency
    {
        return $this->dai;
    }

    /**
     * Sets DAI.
     *
     * @param SupportedTransactionCurrency $dai
     * @return void
     */
    public function setDAI(SupportedTransactionCurrency $dai): void
    {
        $this->dai = $dai;
    }

    /**
     * Gets EUROC.
     *
     * @return SupportedTransactionCurrency
     */
    public function getEUROC(): SupportedTransactionCurrency
    {
        return $this->euroc;
    }

    /**
     * Sets EUROC.
     *
     * @param SupportedTransactionCurrency $euroc
     * @return void
     */
    public function setEUROC(SupportedTransactionCurrency $euroc): void
    {
        $this->euroc = $euroc;
    }

    /**
     * Gets MATIC.
     *
     * @return SupportedTransactionCurrency
     */
    public function getMATIC(): SupportedTransactionCurrency
    {
        return $this->matic;
    }

    /**
     * Sets MATIC.
     *
     * @param SupportedTransactionCurrency $matic
     * @return void
     */
    public function setMATIC(SupportedTransactionCurrency $matic): void
    {
        $this->matic = $matic;
    }

    /**
     * Gets MATIC_e
     *
     * @return SupportedTransactionCurrency
     */
    public function getMaticE(): SupportedTransactionCurrency
    {
        return $this->maticE;
    }

    /**
     * Sets MATIC_e.
     *
     * @param SupportedTransactionCurrency $maticE
     * @return void
     */
    public function setMaticE(SupportedTransactionCurrency $maticE): void
    {
        $this->maticE = $maticE;
    }

    /**
     * Gets ETC_m.
     *
     * @return SupportedTransactionCurrency
     */
    public function getEthM(): SupportedTransactionCurrency
    {
        return $this->ethM;
    }

    /**
     * Sets ETC_m.
     *
     * @param SupportedTransactionCurrency $ethM
     * @return void
     */
    public function setEthM(SupportedTransactionCurrency $ethM): void
    {
        $this->ethM = $ethM;
    }

    /**
     * Gets USDC_m.
     *
     * @return SupportedTransactionCurrency
     */
    public function getUsdcM(): SupportedTransactionCurrency
    {
        return $this->usdcM;
    }

    /**
     * Sets USDC_m.
     *
     * @param SupportedTransactionCurrency $usdcM
     * @return void
     */
    public function setUsdcM(SupportedTransactionCurrency $usdcM): void
    {
        $this->usdcM = $usdcM;
    }

    /**
     * Gets BUSD_m.
     *
     * @return SupportedTransactionCurrency
     */
    public function getBusdM(): SupportedTransactionCurrency
    {
        return $this->busdM;
    }

    /**
     * Sets BUSD_m.
     *
     * @param SupportedTransactionCurrency $busdM
     * @return void
     */
    public function setBusdM(SupportedTransactionCurrency $busdM): void
    {
        $this->busdM = $busdM;
    }

    /**
     * Gets DAI_m.
     *
     * @return SupportedTransactionCurrency
     */
    public function getDaiM(): SupportedTransactionCurrency
    {
        return $this->daiM;
    }

    /**
     * Sets DAI_m.
     *
     * @param SupportedTransactionCurrency $daiM
     * @return void
     */
    public function setDaiM(SupportedTransactionCurrency $daiM): void
    {
        $this->daiM = $daiM;
    }

    /**
     * Gets WBTC_m.
     *
     * @return SupportedTransactionCurrency
     */
    public function getWbtcM(): SupportedTransactionCurrency
    {
        return $this->wbtcM;
    }

    /**
     * Sets WBTC_m.
     *
     * @param SupportedTransactionCurrency $wbtcM
     * @return void
     */
    public function setWbtcM(SupportedTransactionCurrency $wbtcM): void
    {
        $this->wbtcM = $wbtcM;
    }

    /**
     * Gets SHIB_m.
     *
     * @return SupportedTransactionCurrency
     */
    public function getShibM(): SupportedTransactionCurrency
    {
        return $this->shibM;
    }

    /**
     * Sets SHIB_m.
     *
     * @param SupportedTransactionCurrency $shibM
     * @return void
     */
    public function setShibM(SupportedTransactionCurrency $shibM): void
    {
        $this->shibM = $shibM;
    }

    /**
     * Return array with details for currencies.
     *
     * @return array
     */
    public function toArray(): array
    {
        $elements = [
            'btc'  => $this->getBTC()->toArray(),
            'bch'  => $this->getBCH()->toArray(),
            'eth'  => $this->getETH()->toArray(),
            'usdc' => $this->getUSDC()->toArray(),
            'gusd' => $this->getGUSD()->toArray(),
            'pax'  => $this->getPAX()->toArray(),
            'xrp'  => $this->getXRP()->toArray(),
            'busd' => $this->getBUSD()->toArray(),
            'doge' => $this->getDOGE()->toArray(),
            'ltc' => $this->getLTC()->toArray(),
            'wbtc' => $this->getWBTC()->toArray(),
            'dai' => $this->getDAI()->toArray(),
            'euroc' => $this->getEUROC()->toArray(),
            'matic' => $this->getMATIC()->toArray(),
            'maticE' => $this->getMaticE()->toArray(),
            'ethM' => $this->getEthM()->toArray(),
            'usdcM' => $this->getUsdcM()->toArray(),
            'busdM' => $this->getBusdM()->toArray(),
            'daiM' => $this->getDaiM()->toArray(),
            'wbtcM' => $this->getWbtcM()->toArray(),
            'shibM' => $this->getShibM()->toArray(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
