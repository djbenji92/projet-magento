<?php

class Virtual_Marques_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction()
    {
        $marque = Mage::getModel('virtual_marques/marque');

        $urlKey = $this->getRequest()->getParam('url', '');
        if (strlen($urlKey) > 0) {
            $marque->load($urlKey, 'url_key');
        } else {
            $id = (int)$this->getRequest()->getParam('id', 0);
            $marque->load($id);
        }

        if ($marque->getId() < 1) {
            $this->_redirect('*/*/index');
        }

        Mage::register('marque_data', $marque);

        $this->loadLayout()->renderLayout();
    }

}
