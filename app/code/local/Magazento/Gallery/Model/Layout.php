<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php
Class Magazento_Gallery_Model_Layout extends Mage_Core_Model_Abstract {
   
    public function fetchCMSLayoutUpdates() {
        $update = '';
        $page_ids = '';
        $page_id = Mage::getSingleton('cms/page')->getId();
        
        //categories
        $categories = Mage::getModel('gallery/category')->getGalleryCategopriesFrontend(Mage::app()->getStore()->getStoreId());
        foreach($categories as $category) {
            $page_ids.=$category->getData('page_ids').',';
        };
        
        //items
        $items = Mage::getModel('gallery/item')->getAllItems(Mage::app()->getStore()->getStoreId());
        foreach($items as $item) {
            $page_ids.=$item->getData('page_ids').',';
        };     
        
        if (strpos($page_ids ,$page_id) > -1) {
            $update.= '<reference name="content">
                         <block type="core/template" after="-" name="magazento_gallery_cms" template="magazento_gallery/gallery/cms.phtml">
                            <block type="core/template" name="magazento_gallery_item_category" alias="magazento_gallery_item_category" template="magazento_gallery/items/item_category.phtml"/>
                            <block type="core/template" name="magazento_gallery_item_single" alias="magazento_gallery_item_single" template="magazento_gallery/items/item_single.phtml"/>
                         </block>
                       </reference>';            
        }
        
        
        return $update;
    }
    
    public function fetchCategoryLayoutUpdates() {
        $update = '';
        $category_ids = '';
        $category_id = Mage::getModel('catalog/layer')->getCurrentCategory()->getId();
        $categories = Mage::getModel('gallery/category')->getGalleryCategopriesFrontend(Mage::app()->getStore()->getStoreId());
        foreach($categories as $category) {
            $category_ids.=$category->getData('category_ids').',';
        };
        
        //items
        $items = Mage::getModel('gallery/item')->getAllItems(Mage::app()->getStore()->getStoreId());
        foreach($items as $item) {
            $category_ids.=$item->getData('category_ids').',';
        };             
        
        
        if (strpos($category_ids ,$category_id) > -1) {
            $update = '<reference name="content">
                         <block type="core/template" after="-" name="magazento_gallery_category" template="magazento_gallery/gallery/category.phtml" >
                            <block type="core/template" name="magazento_gallery_item_category" alias="magazento_gallery_item_category" template="magazento_gallery/items/item_category.phtml"/>
                            <block type="core/template" name="magazento_gallery_item_single" alias="magazento_gallery_item_single" template="magazento_gallery/items/item_single.phtml"/>
                         </block>
                       </reference>';       
        }
        return $update;
    }
    
    public function fetchProductLayoutUpdates() {
        $update = '';
        $product_ids = '';
        $product_id = Mage::registry('current_product')->getId();
        $categories = Mage::getModel('gallery/category')->getGalleryCategopriesFrontend(Mage::app()->getStore()->getStoreId());
        
        foreach($categories as $category) {
            $product_ids.=$category->getData('products').',';
        };
        
        //items
        $items = Mage::getModel('gallery/item')->getAllItems(Mage::app()->getStore()->getStoreId());
        foreach($items as $item) {
            $product_ids.=$item->getData('products').',';
        };         
        
        if (strpos($product_ids ,$product_id) > -1) {
            $update = '<reference name="content">
                         <block type="core/template" after="-" name="magazento_gallery_product" template="magazento_gallery/gallery/product.phtml">
                            <block type="core/template" name="magazento_gallery_item_category" alias="magazento_gallery_item_category" template="magazento_gallery/items/item_category.phtml"/>
                            <block type="core/template" name="magazento_gallery_item_single" alias="magazento_gallery_item_single" template="magazento_gallery/items/item_single.phtml"/>
                         </block>
                       </reference>';             
        }
        return $update;
    }
    
    public function fetchDbLayoutUpdates(Varien_Event_Observer $observer)
    {
        $layout = $observer->getEvent()->getLayout();
        if (Mage::app()->getRequest()->getControllerName() == 'page') {
            $layout->getUpdate()->addUpdate($this->fetchCMSLayoutUpdates());
        }
        if (Mage::app()->getRequest()->getControllerName() == 'category') {
            $layout->getUpdate()->addUpdate($this->fetchCategoryLayoutUpdates());
        }
        if (Mage::app()->getRequest()->getControllerName() == 'product') {
            $layout->getUpdate()->addUpdate($this->fetchProductLayoutUpdates());
        }

        $layout->generateXml();
    }
    
}