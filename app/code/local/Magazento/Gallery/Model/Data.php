<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php
Class Magazento_Gallery_Model_Data {

    protected function getItemModel() {
        return Mage::getModel('gallery/item');
    }
    
    protected function getItemCollection() {
        $storeId = Mage::app()->getStore()->getId();
        $collection = $this->getItemModel()->getCollection();
        $collection->addFilter('is_active', 1);
        $collection->addStoreFilter($storeId);
        $collection->addOrder('position', 'ASC');
        return $collection;
    }
    
    public function getItems() {
        return $this->getItemCollection();
    }
}
?>