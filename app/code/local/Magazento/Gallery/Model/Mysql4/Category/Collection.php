<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Model_Mysql4_Category_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    protected function _construct() {
        $this->_init('gallery/category');
    }

    public function toOptionArray() {
        return $this->_toOptionArray('category_id', 'name');
    }
    
    public function addStoreFilter($store, $withAdmin = true) {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        $this->getSelect()->join(
                        array('category_store' => $this->getTable('gallery/category_store')),
                        'main_table.category_id = category_store.category_id',
                        array()
                )
                ->where('category_store.store_id in (?)', ($withAdmin ? array(0, $store) : $store));

        return $this;
    }
    
    
    public function addPageFilter($page, $withAdmin = true) {
        var_dump($page);
        $this->getSelect()->where('main_table.page_ids like (?)', $page);

        return $this;
    }    
    
    public function addNowFilter() {
        $now = Mage::getSingleton('core/date')->gmtDate();
        $where = "from_time < '" . $now . "' AND ((to_time > '" . $now . "') OR (to_time IS NULL))";
        $this->getSelect()->where($where);
    }

}