<?php

/**
 * Created by PhpStorm.
 * User: Roberto
 */
class Gbinside_Geoip_Model_Cache extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('gbgeoip/cache');
    }

    protected function _beforeSave()
    {
        if ($this->isObjectNew() && null === $this->getCreatedAt()) {
            $this->setCreatedAt(Mage::getSingleton('core/date')->gmtDate());
        }
        return parent::_beforeSave();
    }
}