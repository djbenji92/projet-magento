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

    protected function _beforeToHtml()
    {
    	$this->addTab('products', array(
		    'label' => Mage::helper('virtual_marques')->__('Associated products'),
		    'url'   => $this->getUrl('*/*/products', array('_current' => true)),
		    'class'    => 'ajax'
		));

		return parent::_beforeToHtml();
    }
}
