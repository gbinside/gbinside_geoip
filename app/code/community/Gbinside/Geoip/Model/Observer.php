<?php

/**
 * Created by PhpStorm.
 * User: Roberto
 */
class Gbinside_Geoip_Model_Observer
{
    const GEOIP_COOKIE = 'gbgeoipdone';

    public function controllerActionPredispatch($o)
    {
        Mage::log('gbgeoip: config => ' . print_r(Mage::getStoreConfig('system/gbgeoip'), true) . PHP_EOL);
        if (!Mage::getStoreConfigFlag('system/gbgeoip/enabled')) {
            return;
        }

        if ($this->_skip()) {
            Mage::log('gbgeoip: skip' . PHP_EOL);
            return;
        }

        $ip = Mage::app()->getRequest()->getClientIp();
        Mage::log('gbgeoip: ' . $ip . PHP_EOL);


        $info = Mage::helper('gbgeoip')->getInfo($ip);
        Mage::log('gbgeoip: ' . print_r($info->debug(), true) . PHP_EOL);

        $c_store = Mage::app()->getStore();
        Mage::log('$c_store: ' . print_r($c_store->debug(), true) . PHP_EOL);

        $store_code = $info->getCountryCode();
        $d_store = Mage::getModel('core/store')->load($store_code, 'code');
        if (!$d_store->getId()) {
            $d_store = Mage::getModel('core/store')->load(strtolower($store_code), 'code');
        }
        Mage::log('$d_store: ' . print_r($d_store->debug(), true) . PHP_EOL);

        if ($d_store->getId() && ($c_store->getId() != $d_store->getId())) {
            Mage::log('gbgeoip: redirect ' . PHP_EOL);
            $url = $d_store->getBaseUrl();
            if ($url === $c_store->getBaseUrl()) { #se non è abilitato il prefisso dello store nella url
                $url = $d_store->getBaseUrl() . '?___store=' . $d_store->getCode(
                    ) . '&___from_store=' . $c_store->getCode();
            }
            $action = $o->getControllerAction();
            $action->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
            $action->getResponse()->setRedirect($url);

            Mage::app()->getCookie()->set(
                self::GEOIP_COOKIE,
                true,
                Mage::getStoreConfig('system/gbgeoip/cookie_lifetime')
            );
        }
    }

    protected function _skip()
    {
        return $this->_userAgent() || $this->_cookie();
    }

    protected function _userAgent()
    {
        $cua = Mage::helper('core/http')->getHttpUserAgent();

        $user_agents = preg_split('/\r\n|\r|\n/', Mage::getStoreConfig('system/gbgeoip/user_agents'));
        Mage::log('gbgeoip: $user_agents => ' . print_r($user_agents, true) . PHP_EOL);
        Mage::log('gbgeoip: $cua => ' . $cua . PHP_EOL);

        $ret = false;
        foreach ($user_agents as $u) {
            if (stripos($cua, $u) !== false) {
                Mage::log("gbgeoip: _userAgent => true [$u]" . PHP_EOL);
                $ret = true;
            }
        }

        return $ret;
    }

    protected function _cookie()
    {
        $cookie = Mage::app()->getCookie()->get(self::GEOIP_COOKIE);
        Mage::log('gbgeoip: _cookie => ' . print_r($cookie, true));
        return $cookie ? : false;
    }
} 