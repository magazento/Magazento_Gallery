<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Model_Mysql4_Item_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    protected function _construct() {
        $this->_init('gallery/item');
    }

    public function toOptionArray() {
        return $this->_toOptionArray('item_id', 'name');
    }
    
    public function addStoreFilter($store, $withAdmin = true) {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        $this->getSelect()->join(
                        array('item_store' => $this->getTable('gallery/item_store')),
                        'main_table.item_id = item_store.item_id',
                        array()
                )
                ->where('item_store.store_id in (?)', ($withAdmin ? array(0, $store) : $store));
        
        return $this;
    }
    
    public function addCategoryFilter($category) {

        $this->getSelect()->join(
                        array('item_category' => $this->getTable('gallery/item_category')),
                        'main_table.item_id = item_category.item_id',
                        array()
                )
                ->where('item_category.category_id in (?)', $category);

        return $this;
    }
    
    public function addNowFilter() {
        $now = Mage::getSingleton('core/date')->gmtDate();
        $where = "from_time < '" . $now . "' AND ((to_time > '" . $now . "') OR (to_time IS NULL))";
        $this->getSelect()->where($where);
    }

}