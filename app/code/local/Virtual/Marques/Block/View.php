<?php
class Virtual_Marques_Block_View extends Mage_Core_Block_Template
{
    public function getCurrentMarque()
    {
        return Mage::registry('marque_data');
    }

    public function getProductCollection()
    {
        $marque = $this->getCurrentMarque();
        if (!$marque) {
            return array();
        }

        return Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToFilter('marque_id', $marque->getId())
            ->setOrder('name', 'ASC');
    }
}
