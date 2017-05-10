<?php

class Virtual_Marques_Block_Adminhtml_Marque_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('marque_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('virtual_marques')->__('Marque Information'));
    }
}