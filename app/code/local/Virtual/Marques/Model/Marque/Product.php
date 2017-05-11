<?php
class Virtual_Marques_Model_Marque_Product
    extends Mage_Core_Model_Abstract {
    
    protected function _construct(){
        $this->_init('virtual_marques/marque_product');
    }

    public function saveMarqueRelation($marque){
        $data = $marque->getProductsData();
        if (!is_null($data)) {
            $this->_getResource()->saveMarqueRelation($marque, $data);
        }
        return $this;
    }

    public function getProductCollection($marque){
        $collection = Mage::getResourceModel('virtual_marques/marque_product_collection')
            ->addMarqueFilter($marque);
        return $collection;
    }
}