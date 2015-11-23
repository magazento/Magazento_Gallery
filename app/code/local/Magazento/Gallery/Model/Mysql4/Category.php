<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Model_Mysql4_Category extends Mage_Core_Model_Mysql4_Abstract {

    protected function _construct() {
        $this->_init('gallery/category', 'category_id');
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
        if (!$object->getToTime()) {
            $object->setToTime();
        } else {
            $object->setToTime(Mage::app()->getLocale()->date($object->getToTime(), $dateFormatIso));
            $object->setToTime($object->getToTime()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
            $object->setToTime(Mage::getSingleton('core/date')->gmtDate(null, $object->getToTime()));
        }
        return $this;
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object) {
        $condition = $this->_getWriteAdapter()->quoteInto('category_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('gallery/category_store'), $condition);
        if (!$object->getData('stores')) {
            $object->setData('stores', $object->getData('store_id'));
        }
        if (in_array(0, $object->getData('stores'))) {
            $object->setData('stores', array(0));
        }
        foreach ((array) $object->getData('stores') as $store) {
            $storeArray = array();
            $storeArray['category_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert($this->getTable('gallery/category_store'), $storeArray);
        }
        return parent::_afterSave($object);
    }
    protected function _afterLoad(Mage_Core_Model_Abstract $object) {
        $select = $this->_getReadAdapter()->select()
                        ->from($this->getTable('gallery/category_store'))
                        ->where('category_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }
        return parent::_afterLoad($object);
    }

    protected function _beforeDelete(Mage_Core_Model_Abstract $object) {
        $adapter = $this->_getReadAdapter();
        $adapter->delete($this->getTable('gallery/category_store'), 'category_id=' . $object->getId());
    }

}