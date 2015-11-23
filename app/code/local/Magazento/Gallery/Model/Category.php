<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php
class Magazento_Gallery_Model_Category extends Mage_Core_Model_Abstract
{
    const CACHE_TAG     = 'gallery_admin_category';
    protected $_cacheTag= 'gallery_admin_category';

    protected function _construct()
    {
        $this->_init('gallery/category');
    }

    
    public function getCategories4Form() {
        $collection = $this->getCollection();
        $collection ->addFilter('is_active', 1);
        $collection ->addOrder('position', 'ASC');
		
		$items = array();
		foreach ($collection as $item) {
                    $v = array( 'label' => $item->getTitle(),
                                'value' => $item->getCategoryId()
                                ); 
                    array_push($items,$v);
		}
                
        return $items;
    }    
    public function getCategories4Grid() {
        $collection = $this->getCollection();
        $collection ->addFilter('is_active', 1);
        $collection ->addOrder('position', 'ASC');
		
		$items = array();
		foreach ($collection as $item) {
                    $items[$item->getCategoryId()] = $item->getTitle();
		}
                
        return $items;
    }    
    public function getPages4Grid() {
        $collection = Mage::getResourceModel('cms/page_collection')
                    ->addFieldToFilter('identifier',array(array('nin'=>array('no-route','enable-cookies'))))
                    ->load();
	
        $items = array();
        foreach ($collection as $item) {
            $items[$item->getId()] = $item->getTitle();
        }
                
        return $items;
    }    
    
    public function getPages4Form() {
        $collection = Mage::getResourceModel('cms/page_collection')
                    ->addFieldToFilter('identifier',array(array('nin'=>array('no-route','enable-cookies'))))
                    ->load();
		
        $items = array();
        foreach ($collection as $item) {
            $v = array( 'label' => $item->getTitle(),
                        'value' => $item->getId()
                        ); 
            array_push($items,$v);
        }
                
        return $items;
    } 
    
    public function getGalleryCategopriesFrontend($store,$pageId=null,$categoryId=null,$productId=null) {    
        $collection = $this->getCollection();
        $collection ->addFilter('is_active', 1);
        $collection ->addStoreFilter($store);
        $collection ->addOrder('position', 'ASC');
        
        $categoryCollection = $collection;
        
        if ($pageId) {
            $categoryCollection = array();
            foreach ($collection as $item) {
                if (strpos($item->getData('page_ids') ,$pageId) > -1) {
                    $categoryCollection[] = $this->load($item->getId());
                }
            }      
        }
        if ($categoryId) {
            $categoryCollection = array();
            foreach ($collection as $item) {
                if (strpos($item->getData('category_ids') ,$categoryId) > -1) {
                    $categoryCollection[] = $this->load($item->getId());
                }
            }      
        }
        if ($productId) {
            $categoryCollection = array();
            foreach ($collection as $item) {
                if (strpos($item->getData('products') ,$productId) > -1) {
                    $categoryCollection[] = $this->load($item->getId());
                }
            }      
        }
        
        
        return $categoryCollection;
    }
}
