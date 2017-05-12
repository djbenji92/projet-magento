<?php

class Virtual_Marques_Block_Adminhtml_Marque extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller     = 'adminhtml_marque';
        $this->_blockGroup     = 'virtual_marques';
        $this->_headerText     = Mage::helper('virtual_marques')->__('Manage Marques');
        $this->_addButtonLabel = Mage::helper('virtual_marques')->__('Add Marque');
        parent::__construct();
    }

}
