<?php

class Virtual_Marques_Model_Resource_MarqueProduct_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Magento class constructor
     */
    protected function _construct()
    {
        $this->_init('virtual_marques/marque_product');
    }

    /**
     * Filter collection by status
     *
     * @return Virtual_Marques_Model_Resource_Marque_Collection
     */
    public function addIsActiveFilter()
    {
        $this->addFieldToFilter('is_active', 1);

        return $this;
    }

    /**
     * Sort order by position
     *
     * @return Virtual_Marques_Model_Resource_Marque_Collection
     */
    public function addOrderByPosition($order = Varien_Data_Collection_Db::SORT_ORDER_ASC)
    {
        $this->setOrder('position', $order);

        return $this;
    }

}
