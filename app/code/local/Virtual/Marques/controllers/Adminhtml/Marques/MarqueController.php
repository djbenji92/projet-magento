<?php

class Virtual_Marques_Adminhtml_Marques_MarqueController extends Mage_Adminhtml_Controller_Action
{

    /**
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        return $this->loadLayout()->_setActiveMenu('virtual_marques');
    }

    /**
     * @return Mage_Core_Controller_Varien_Action
     */
    public function indexAction()
    {
        return $this->_initAction()->renderLayout();
    }

    /**
     * @return $this
     */
    public function newAction()
    {
        $this->_forward('edit');

        return $this;
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var Virtual_Marques_Model_Marque $marque */
        $marque = Mage::getModel('virtual_marques/marque')->load($id);

        if ($marque->getId() || $id == 0) {

            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $marque->setData($data);
            }
            Mage::register('marque_data', $marque);

            return $this->_initAction()->renderLayout();
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('virtual_marques')->__('Marque does not exist'));

        return $this->_redirect('*/*/');
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            $delete = (!isset($data['image_url']['delete']) || $data['image_url']['delete'] != '1') ? false : true;
            $data['image_url'] = $this->_saveImage('image_url', $delete);

            /** @var Virtual_Marques_Model_Marque $marque */
            $marque = Mage::getModel('virtual_marques/marque');

            if ($id = $this->getRequest()->getParam('id')) {
                $marque->load($id);
            }

            try {
                $marque->addData($data);
                
                $products = $this->getRequest()->getPost('products', -1);
                if ($products != -1) {
                    $marque->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
                }
                $marque->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtual_marques')->__('The marque has been saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array(
                        'id'       => $marque->getId(),
                        '_current' => true
                    ));

                    return;
                }

                $this->_redirect('*/*/');

                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_getSession()->addException($e, Mage::helper('virtual_marques')->__('An error occurred while saving the marque.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array(
                'id' => $this->getRequest()->getParam('id')
            ));

            return;
        }
        $this->_redirect('*/*/');
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                /** @var Virtual_Marques_Model_Marque $marque */
                $marque = Mage::getModel('virtual_marques/marque');
                $marque->load($id)->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtual_marques')->__('Marque was successfully deleted'));
                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

                return;
            }
        }

        return $this->_redirect('*/*/');
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function massDeleteAction()
    {
        $marqueIds = $this->getRequest()->getParam('marque');
        if (!is_array($marqueIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('virtual_marques')->__('Please select marque(s)'));
        } else {
            try {
                foreach ($marqueIds as $marque) {
                    Mage::getModel('virtual_marques/marque')->load($marque)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtual_marques')->__('Total of %d marque(s) were successfully deleted', count($marqueIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        return $this->_redirect('*/*/index');
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function massStatusAction()
    {
        $marqueIds = $this->getRequest()->getParam('marque');
        if (!is_array($marqueIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select marque(s)'));
        } else {
            try {
                foreach ($marqueIds as $marque) {
                    Mage::getSingleton('virtual_marques/marque')->load($marque)->setIsActive($this->getRequest()->getParam('is_active'))->setIsMassupdate(true)->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtual_marques')->__('Total of %d marque(s) were successfully updated', count($marqueIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        return $this->_redirect('*/*/index');
    }

    /**
     *
     */
    protected function _saveImage($imageAttr, $delete)
    {
        if ($delete) {
            $image = '';
        } elseif (isset($_FILES[$imageAttr]['name']) && $_FILES[$imageAttr]['name'] != '') {
            try {
                $uploader = new Varien_File_Uploader($imageAttr);
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'png'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $path = Mage::getBaseDir('media') . DS . 'marque' . DS;
                $uploader->save($path, $_FILES[$imageAttr]['name']);
                $image = $_FILES[$imageAttr]['name'];
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                return $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        } else {
            $model = Mage::getModel('virtual_marques/marque')->load($this->getRequest()->getParam('id'));
            $image = $model->getData($imageAttr);
        }
        return $image;
    }

    public function _initMarque()
    {
        $id = $this->getRequest()->getParam('id');
        $marque = Mage::getModel('virtual_marques/marque')->load($id);
        Mage::register('marque_data', $marque);
    }

    public function productsAction(){
        $this->_initMarque(); //if you don't have such a method then replace it with something that will get you the entity you are editing.
        $this->loadLayout();
        $this->getLayout()->getBlock('marque.edit.tab.product')
            ->setMarqueProducts($this->getRequest()->getPost('marque_products', null));
        $this->renderLayout();
    }
    public function productsgridAction(){
        $this->_initMarque();
        $this->loadLayout();
        $this->getLayout()->getBlock('marque.edit.tab.product')
            ->setMarqueProducts($this->getRequest()->getPost('marque_products', null));
        $this->renderLayout();
    }
}
