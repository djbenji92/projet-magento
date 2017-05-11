<?php

class Virtual_Marques_Model_Resource_Marque extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Magento class constructor
     */
    protected function _construct()
    {
        $this->_init('virtual_marques/marque', 'entity_id');
    }

}
