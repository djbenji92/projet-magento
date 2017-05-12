<?php

class Virtual_Marques_Model_Marque extends Mage_Core_Model_Abstract
{

    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    protected $_productInstance = null;


    /**
     * Magento class constructor
     */
    protected function _construct()
    {
        $this->_init('virtual_marques/marque');
    }

    public function getProductInstance(){
        if (!$this->_productInstance) {
            $this->_productInstance = Mage::getSingleton('virtual_marques/marque_product');
        }
        return $this->_productInstance;
    }

    protected function _afterSave() {
        $this->getProductInstance()->saveMarqueRelation($this);
        return parent::_afterSave();
    }

    /**
     * Perform actions before object save
     *
     * @param Varien_Object $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _beforeSave()
    {
        $urlKey = Mage::getModel('catalog/product_url')->formatUrlKey($this->getName());
        $this->setUrlKey($urlKey);

        return $this;
    }



    public function getSelectedProducts(){
        if (!$this->hasSelectedProducts()) {
            $products = array();
            foreach ($this->getSelectedProductsCollection() as $product) {
                $products[] = $product;
            }
            $this->setSelectedProducts($products);
        }
        return $this->getData('selected_products');
    }


    public function getSelectedProductsCollection(){
        $collection = $this->getProductInstance()->getProductCollection($this);
        return $collection;
    }

    protected function _prepareUrlKey()
    {
        return $this->setUrlKey(Mage::getModel('catalog/product_url')->formatUrlKey($this->getName()));
    }


}
