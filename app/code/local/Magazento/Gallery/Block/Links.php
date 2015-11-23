<?php

class Magazento_Gallery_Block_Links extends Mage_Customer_Block_Account_Navigation
{

    public function addTopLink()
    {
        if (Mage::getStoreConfig('gallery/toplinks/link')) {
            $storeId = Mage::app()->getStore()->getId();
            $storeUrl = Mage::getModel('core/store')->load($storeId)->getUrl();
            $route = Mage::getBaseUrl().'gallery' ;
            $title = Mage::getStoreConfig('gallery/toplinks/link_title');
            $this->getParentBlock()->addLink($title, $route, $title, false, array(), 15, null, 'class="magazento-gallery"');
        }
   }

}
