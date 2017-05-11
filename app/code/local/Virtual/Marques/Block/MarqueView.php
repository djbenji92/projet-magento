<?php
class Virtual_Marques_Block_MarqueView extends Mage_Core_Block_Template
{
    public function getCurrentMarque()
    {
        return Mage::registry('current_marque');
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