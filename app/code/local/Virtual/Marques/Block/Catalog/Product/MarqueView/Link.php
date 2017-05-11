<?php
class Virtual_Marques_Block_Catalog_Product_MarqueView_Link extends Mage_Core_Block_Template
{
    public function getMarque()
    {
        $product = Mage::registry('current_product');
        if (!$product instanceof Mage_Catalog_Model_Product) {
            return false;
        }
        
        $marqueId = (int)$product->getMarqueId();
        $marque = Mage::getModel('virtual_marques/marque')->load($marqueId);
        if ($marque->getId() < 1) {
            return false;
        }
        
        return $marque;
    }
}