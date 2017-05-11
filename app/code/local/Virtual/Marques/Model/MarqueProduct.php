<?php

class Virtual_Marques_Model_MarqueProduct extends Mage_Core_Model_Abstract
{

    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = 'product_id';

    /**
     * Magento class constructor
     */
    protected function _construct()
    {
        $this->_init('virtual_marques/marque_product');
    }

}
