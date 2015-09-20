<?php

/**
 * Created by PhpStorm.
 * User: Roberto
 */
class Gbinside_Geoip_Helper_Data extends Mage_Core_Helper_Data
{

    protected $_memoize = array();

    protected function _getHttpsPage($host, $parameter = array())
    {
        $client = new Varien_Http_Client();
        $client->setUri($host)
            ->setConfig(array('timeout' => 30))
            ->setHeaders('accept-encoding', '')
            ->setParameterGet($parameter)
            ->setMethod(Zend_Http_Client::GET);
        $request = $client->request();
        return $request->getRawBody();
    }

    public function getInfo($ip)
    {
        if (!array_key_exists($ip, $this->_memoize)) {
            $model = Mage::getModel('gbgeoip/cache')->load($ip, 'ip');
            if (!$model->getId()) {
                $info = $this->jsonDecode($this->_getHttpsPage('https://freegeoip.net/json/' . $ip));
                $model->setData($info)->save();
            }
            $this->_memoize[$ip] = $model;
        }
        return $this->_memoize[$ip];
    }
}