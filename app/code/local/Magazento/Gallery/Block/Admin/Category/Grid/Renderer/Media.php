<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Category_Grid_Renderer_Media extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{

  public function render(Varien_Object $row)
    {
        $image='';
        if ($row->getData('item_address')) {
            $image .= '<br/><img style="width:300px; border:1px solid #aaa;" src="'.Mage::helper('gallery')->getBackgroundImageFileHttp().DS.$row->getData('item_address').'">';
        }
        //PAGES
        $pages = '';
        $collection = Mage::getResourceModel('cms/page_collection')
                        ->addFieldToFilter('page_id',array(array('in'=>explode(',',$row->getData('page_ids')))))
                        ->load();
        foreach ($collection as $page) {
            $pages.=$page->getTitle().'<br/>';
        }         
        
        //CATEGORIES
        $categories = '';
        $collection = Mage::getModel('catalog/category')->getCollection();
        $category_ids = explode(',',$row->getData('category_ids'));
        $collection->addFieldToFilter('entity_id', $category_ids);
        $collection->addAttributeToSelect('name');
        
        foreach ($collection as $category) {
            $categories.=$category->getData('name').'<br/>';
        }      
        
        //PRODUCTS        
        $products = '';
        $collection = Mage::getModel('catalog/product')->getCollection();
        $product_ids = explode(',',$row->getData('products'));
        $collection->addFieldToFilter('entity_id', $product_ids);
        $collection->addAttributeToSelect('name');
        
        foreach ($collection as $product) {
            $products.=$product->getData('name').'<br/>';
        }      
        
        
        
        
        $html = '<div style="float:left;">'.$row->getData('title').$image.'</div> ';        
        $html.= '<div style="float:right; width: 180px;margin-top: 13px;"><b>'.Mage::helper('gallery')->__('Pages').':</b><p>'.$pages.'<p>'.'</div> ';        
        $html.= '<div style="float:right; width: 180px;"><b>'.Mage::helper('gallery')->__('Categories').':</b><p>'.$categories.'<p>'.'</div> ';        
        $html.= '<div style="float:right; width: 180px;"><b>'.Mage::helper('gallery')->__('Products').':</b><p>'.$products.'<p>'.'</div> ';        
        $html = '<div style="float:left; width: 500px;">'.$html.'</div> ';        
        return $html;
    }    
}
