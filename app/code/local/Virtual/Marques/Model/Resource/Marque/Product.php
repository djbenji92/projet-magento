<?php
class Virtual_Marques_Model_Resource_Marque_Product
    extends Mage_Core_Model_Resource_Db_Abstract {
    protected function  _construct(){
        $this->_init('virtual_marques/marque_product', 'rel_id');
    }
    public function saveMarqueRelation($marque, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('marque_id=?', $marque->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $productId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'marque_id'      => $marque->getId(),
                'product_id'     => $productId,
                'position'      => @$info['position']
            ));
        }
        return $this;
    }
}