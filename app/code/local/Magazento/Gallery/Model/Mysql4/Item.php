<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Model_Mysql4_Item extends Mage_Core_Model_Mysql4_Abstract {

    protected function _construct() {
        $this->_init('gallery/item', 'item_id');
    }

   protected function _beforeSave(Mage_Core_Model_Abstract $object) {
        $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        if (!$object->getFromTime()) {
            $object->setFromTime(Mage::getSingleton('core/date')->gmtDate());
        } else {
            $object->setFromTime(Mage::app()->getLocale()->date($object->getFromTime(), $dateFormatIso));
            $object->setFromTime($object->getFromTime()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
            $object->setFromTime(Mage::getSingleton('core/date')->gmtDate(null, $object->getFromTime()));
        }
        $object->setData('from_time', Mage::getSingleton('core/date')->gmtDate());

        return $this;
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object) {
        $condition = $this->_getWriteAdapter()->quoteInto('item_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('gallery/item_store'), $condition);
        $this->_getWriteAdapter()->delete($this->getTable('gallery/item_category'), $condition);
        
        if (!$object->getData('stores')) {
            $object->setData('stores', $object->getData('store_id'));
        }
        if (in_array(0, $object->getData('stores'))) {
            $object->setData('stores', array(0));
        }
        foreach ((array) $object->getData('stores') as $store) {
            $storeArray = array();
            $storeArray['item_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert($this->getTable('gallery/item_store'), $storeArray);
        }
        
//        var_dump($object->getData('categories'));
//        exit();
        if (!$object->getData('categories')) {
            $object->setData('categories', $object->getData('category_id'));
        }
        if (in_array(0, $object->getData('categories'))) {
            $object->setData('categories', array(0));
        }
        foreach ((array) $object->getData('categories') as $category) {
            $categoryArray = array();
            $categoryArray['item_id'] = $object->getId();
            $categoryArray['category_id'] = $category;
            $this->_getWriteAdapter()->insert($this->getTable('gallery/item_category'), $categoryArray);
        }
//        var_dump($categoryArray);
//        exit();
        
        return parent::_afterSave($object);
    }
    
    protected function _afterLoad(Mage_Core_Model_Abstract $object) {
        $select = $this->_getReadAdapter()->select()
                        ->from($this->getTable('gallery/item_store'))
                        ->where('item_id = ?', $object->getId());
        
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }
        
        
        $select = $this->_getReadAdapter()->select()
                        ->from($this->getTable('gallery/item_category'))
                        ->where('item_id = ?', $object->getId());
//        var_dump($select->__toString());
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $categoryArray = array();
            foreach ($data as $row) {
                $categoryArray[] = $row['category_id'];
            }
            $object->setData('category_id', $categoryArray);
        }        
        
//        var_dump($object);
//        exit();
        return parent::_afterLoad($object);
    }

    protected function _beforeDelete(Mage_Core_Model_Abstract $object) {
        $adapter = $this->_getReadAdapter();
        $adapter->delete($this->getTable('gallery/item_store'), 'item_id=' . $object->getId());
        $adapter->delete($this->getTable('gallery/item_category'), 'item_id=' . $object->getId());
    }

}