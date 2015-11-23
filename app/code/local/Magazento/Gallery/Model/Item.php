<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php
class Magazento_Gallery_Model_Item extends Mage_Core_Model_Abstract
{
    const CACHE_TAG     = 'gallery_admin_item';
    protected $_cacheTag= 'gallery_admin_item';

    protected function _construct()
    {
        $this->_init('gallery/item');
    }
    
    public function getAllGalleryItems($store) {
        $collection = $this->getCollection();
        $collection ->addFilter('is_active', 1);
        $collection ->addStoreFilter($store);
        $collection ->addOrder('position', 'ASC');
        
        $helper = Mage::helper('cms');
        $processor = $helper->getPageTemplateProcessor();
                
        foreach ($collection as $item) {
            $i = $this->load($item->getId());
            $i->setContent($processor->filter($item->getContent()));
            $item->setData($i->getData());
        }
        
        return $collection;
    }        
    
    public function getAllItems($store) {
        $collection = $this->getCollection();
        $collection ->addFilter('is_active', 1);
        $collection ->addStoreFilter($store);
        $collection ->addOrder('position', 'ASC');
        return $collection;
    }        
    
    public function getGalleryItemsFilterCategory($store,$categories = null) {
        $collection = $this->getCollection();
        $collection ->addFilter('is_active', 1);
        $collection ->addStoreFilter($store);
        $collection ->addOrder('position', 'ASC');
        if ($categories) {
            $category_ids = '' ;
            foreach ($categories as $category) {
                $category_ids.= $category->getId().',';
            }  
            $collection ->addCategoryFilter($category_ids);                 
        }
//        var_dump(count($collection));
//        exit();
        
        $helper = Mage::helper('cms');
        $processor = $helper->getPageTemplateProcessor();
                
        foreach ($collection as $item) {
            $i = $this->load($item->getId());
            $i->setContent($processor->filter($item->getContent()));
            $item->setData($i->getData());
        }
        
        return $collection;
    }     
    
    
public function getGalleryItemsFrontend($store,$pageId=null,$categoryId=null,$productId=null) {    
        $collection = $this->getCollection();
        $collection ->addFilter('is_active', 1);
        $collection ->addStoreFilter($store);
        $collection ->addOrder('position', 'ASC');
        
        $itemCollection = $collection;
        
        if ($pageId) {
            $itemCollection = array();
            foreach ($collection as $item) {
                if (strpos($item->getData('page_ids') ,$pageId) > -1) {
                    $itemCollection[] = $this->load($item->getId());
                }
            }      
        }
        if ($categoryId) {
            $itemCollection = array();
            foreach ($collection as $item) {
                if (strpos($item->getData('category_ids') ,$categoryId) > -1) {
                    $itemCollection[] = $this->load($item->getId());
                }
            }      
        }
        if ($productId) {
            $itemCollection = array();
            foreach ($collection as $item) {
                if (strpos($item->getData('products') ,$productId) > -1) {
                    $itemCollection[] = $this->load($item->getId());
                }
            }      
        }
        
        $helper = Mage::helper('cms');
        $processor = $helper->getPageTemplateProcessor();
                
        foreach ($itemCollection as $item) {
            $i = $this->load($item->getId());
            $i->setContent($processor->filter($item->getContent()));
            $item->setData($i->getData());
        }        
        
        
        return $itemCollection;
    }    

}
