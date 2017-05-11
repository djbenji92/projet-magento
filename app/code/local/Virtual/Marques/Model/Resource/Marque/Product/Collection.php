<?php 
class Virtual_Marques_Model_Resource_Marque_Product_Collection
    extends Mage_Catalog_Model_Resource_Product_Collection {
    protected $_joinedFields = false;
    public function joinFields(){
        if (!$this->_joinedFields){
            $this->getSelect()->join(
                array('related' => $this->getTable('virtual_marques/marque_product')),
                'related.product_id = e.entity_id',
                array('position')
            );
            $this->_joinedFields = true;
        }
        return $this;
    }
    public function addMarqueFilter($marque){
        if ($marque instanceof Virtual_Marques_Model_Marque){
            $marque = $marque->getId();
        }
        if (!$this->_joinedFields){
            $this->joinFields();
        }
        $this->getSelect()->where('related.marque_id = ?', $marque);
        return $this;
    }
}