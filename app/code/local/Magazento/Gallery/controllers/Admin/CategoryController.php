<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Admin_CategoryController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('magazento/gallery')
                ->_addBreadcrumb(Mage::helper('gallery')->__('Gallery'), Mage::helper('gallery')->__('Gallery'))
                ->_addBreadcrumb(Mage::helper('gallery')->__('Gallery Items'), Mage::helper('gallery')->__('Gallery Items'))
        ;
        return $this;
    }
    
    
    /**
     * Get categories fieldset block
     *
     */
    public function categoriesAction() {
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('gallery/admin_category_edit_tab_categories')->toHtml()
        );
    }

    public function categoriesJsonAction() {
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('gallery/admin_category_edit_tab_categories')
                        ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }
    
    public function updatecategoriesAction() {
        if ($id = $this->getRequest()->getParam('category_id')) {
            Mage::getModel('gallery/category')->refreshCategories($id);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gallery')->__('Categories was successfully updated'));            
        }
        $this->_redirect('*/*/');
        return;
    }    
    
    /**
     * Get connected with template products grid and serializer block
     */
    public function relatedAction()
    {
        $gridBlock = $this->getLayout()->createBlock('gallery/admin_category_edit_tab_related')
            ->setGridUrl($this->getUrl('*/*/gridOnly', array('_current' => true, 'gridOnlyBlock' => 'related')))
        ;
        $serializerBlock = $this->_createSerializerBlock('links[related]', $gridBlock, $productsArray);
        $this->_outputBlocks($gridBlock, $serializerBlock);
    }    

    /**
     * Get specified tab grid
     */
    public function gridOnlyAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('gallery/admin_category_edit_tab_related')
            ->toHtml()
        );
    }    
    
    /**
     * Create serializer block for a grid
     *
     * @param string $inputName
     * @param Mage_Adminhtml_Block_Widget_Grid $gridBlock
     * @param array $productsArray
     * @return Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Ajax_Serializer
     */
    protected function _createSerializerBlock($inputName, Mage_Adminhtml_Block_Widget_Grid $gridBlock, $productsArray)
    {
        return $this->getLayout()->createBlock('gallery/admin_category_edit_tab_ajax_serializer')
            ->setGridBlock($gridBlock)
            ->setProducts($productsArray)
            ->setInputElementName($inputName)
        ;
    }    
    
    /**
     * Output specified blocks as a text list
     */
    protected function _outputBlocks()
    {
        $blocks = func_get_args();
        $output = $this->getLayout()->createBlock('adminhtml/text_list');
        foreach ($blocks as $block) {
            $output->insert($block, '', true);
        }
        $this->getResponse()->setBody($output->toHtml());
    }      
    
    

    public function indexAction() {
        $this->_initAction()
                ->_addContent($this->getLayout()->createBlock('gallery/admin_category'))
                ->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {
        if (Mage::helper('gallery')->versionUseAdminTitle()) {
            $this->_title($this->__('gallery'));
        }
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('category_id');
        $model = Mage::getModel('gallery/category');
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gallery')->__('This category no longer exists'));
                $this->_redirect('*/*/');
                return;
            }
        }
        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        // 4. Register model to use later in blocks
        Mage::register('gallery_category', $model);
        // 5. Build edit form
        $this->_initAction()
                ->_addBreadcrumb($id ? Mage::helper('gallery')->__('Edit Item') : Mage::helper('gallery')->__('New Category'), $id ? Mage::helper('gallery')->__('Edit Category') : Mage::helper('gallery')->__('New Category'))
                ->_addContent($this->getLayout()->createBlock('gallery/admin_category_edit')->setData('action', $this->getUrl('*/admin_category/save')))
                ->_addLeft($this->getLayout()->createBlock('gallery/admin_category_edit_tabs'))
                ->renderLayout();
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('gallery/category');
            
            
            $catIds = explode(",", $data['category_ids']);
            $result = array_unique($catIds);
            $comma_separated = implode(",", $result);
            $data['category_ids'] = $comma_separated;
            
            
            $result = array_unique($data['pages']);
            $comma_separated = implode(",", $result);
            $data['page_ids'] = $comma_separated;
//            var_dump($data['page_ids']);
//            exit();
            
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                    try {
                        $uploader = new Varien_File_Uploader('image');
                        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png','bmp'));
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);
                        $path = Mage::helper('gallery')->getBackgroundImageFilePath(); 

                        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        $image_md5_name = md5($_FILES['image']['name']).'.'.$ext;
                        
                        $uploader -> save($path, $image_md5_name);
                        
                        $data['item_address'] = $image_md5_name;
                        
                    } catch (Exception $e) {
                        var_dump($e);
                    }
            } else {       
                if (isset($data['image']['delete']) && $data['image']['delete'] == 1) {
                        $data['item_address'] = '';
                }
            }                
            
            $aProductSaveHash = array();
            $aProductOldHash  = array();
            $aRelatedData     = array();
            if (isset($data['links']['related']))
            {
                if ($data['links']['related'])
                {
                    $aRelatedData = explode('&', $data['links']['related']);
                    
                    foreach ($aRelatedData as &$sItem)
                    {
                        $iProductId = substr($sItem, 0, strpos($sItem, '='));
                        $sItem = $iProductId;
                    }
                    $aProductOldHash = array_diff($aProductHash, $aRelatedData);
                    $aProductSaveHash = array_diff($aRelatedData, $aProductHash);
                }
                else {
                    $aProductOldHash = $aProductHash;
                }
            }

            if ($aRelatedData) {
                $comma_separated= implode(",", $aRelatedData);
                $data['products'] = $comma_separated; 
            }
//            var_dump($data['products']);
//            exit();            
            
            
//            print_r($data);exit();
            $model->setData($data);
            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gallery')->__('Category was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('category_id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('category_id' => $this->getRequest()->getParam('category_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('category_id')) {
            $name = "";
            try {
                // init model and delete
                $model = Mage::getModel('gallery/category');
                $model->load($id);
                $name = $model->getName();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gallery')->__('Item was successfully deleted'));
                // go to grid
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('category_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gallery')->__('Unable to find a category to delete'));
        // go to grid
        $this->_redirect('*/*/');
    }


    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('gallery/category');
    }

    public function wysiwygAction() {
        $elementId = $this->getRequest()->getParam('element_id', md5(microtime()));
        $content = $this->getLayout()->createBlock('adminhtml/catalog_helper_form_wysiwyg_content', '', array(
                    'editor_element_id' => $elementId
                ));
        $this->getResponse()->setBody($content->toHtml());
    }



    public function massStatusAction()
    {
        $categoryIds = $this->getRequest()->getParam('massaction');
        if(!is_array($categoryIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select category(s)'));
        } else {
            try {
                foreach ($categoryIds as $categoryId) {
                    $model = Mage::getSingleton('gallery/category')
                        ->load($categoryId)
                        ->setIs_active($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($categoryIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
   public function massDeleteAction() {
        $categoryIds = $this->getRequest()->getParam('massaction');
        if(!is_array($categoryIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gallery')->__('Please select category(s)'));
        } else {
            try {
                foreach ($categoryIds as $categoryId) {
                    $mass = Mage::getModel('gallery/category')->load($categoryId);
                    $mass->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('gallery')->__(
                        'Total of %d record(s) were successfully deleted', count($categoryIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    
    public function exportCsvAction()
    {
        $fileName   = 'category.csv';
        $content    = $this->getLayout()->createBlock('gallery/admin_category_grid')
            ->getCsv();
        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'category.xml';
        $content    = $this->getLayout()->createBlock('gallery/admin_category_grid')
            ->getXml();
        $this->_sendUploadResponse($fileName, $content);
    }
    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}