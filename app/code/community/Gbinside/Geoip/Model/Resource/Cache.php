<?php
/**
 * Created by PhpStorm.
 * User: Roberto
 */ 
class Gbinside_Geoip_Model_Resource_Cache extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('gbgeoip/cache', 'id');
    }

}