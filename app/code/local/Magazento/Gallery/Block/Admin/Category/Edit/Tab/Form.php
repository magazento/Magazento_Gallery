<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {


    protected function _prepareForm() {
        $model = Mage::registry('gallery_category');
        $form = new Varien_Data_Form(array('id' => 'edit_form_category', 'action' => $this->getData('action'), 'method' => 'post'));
        $form->setHtmlIdPrefix('category_');
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('gallery')->__('Category Information'), 'class' => 'fieldset-wide'));
        if ($model->getCategoryId()) {
            $fieldset->addField('category_id', 'hidden', array(
                'name' => 'category_id',
            ));
        }

        $image = '';
        if ($model->getData('item_address')) {
           $path = Mage::helper('gallery')->getBackgroundImageFileHttp(); 
           $image = 'Background: <br/><img width="150" height="100" src="'.$path.DS.$model->getData('item_address').'">';
        }        
        $fieldset->addField('image', 'image', array(
          'label'     => Mage::helper('gallery')->__('Background image'),
          'required'  => true,
          'name'      => 'image',
          'note'      => $image,
        ));             
        
        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => Mage::helper('gallery')->__('Title'),
            'title' => Mage::helper('gallery')->__('Title'),
            'required' => true,
        ));

//        $fieldset->addField('url', 'text', array(
//            'name' => 'url',
//            'label' => Mage::helper('gallery')->__('Url'),
//            'title' => Mage::helper('gallery')->__('Url'),
//            'required' => false,
//            'comment' => 'tadaada',
//        ));
//
//        $fieldset->addField('catalog_id', 'text', array(
//            'name' => 'catalog_id',
//            'label' => Mage::helper('gallery')->__('Catalog ID'),
//            'title' => Mage::helper('gallery')->__('Catalog ID'),
//            'required' => true,
////            'style' => 'width:200px',
//        ));

        $fieldset->addField('position', 'select', array(
            'name' => 'position',
            'label' => Mage::helper('gallery')->__('Position'),
            'title' => Mage::helper('gallery')->__('Position'),
            'required' => true,
            'options' => Mage::helper('gallery')->numberArray(20,Mage::helper('gallery')->__('')),
        ));


//        $fieldset->addField('column', 'select', array(
//            'name' => 'column',
//            'label' => Mage::helper('gallery')->__('Columns'),
//            'title' => Mage::helper('gallery')->__('Columns'),
//            'required' => true,
//            'options' => Mage::helper('gallery')->numberArray(5,Mage::helper('gallery')->__('')),
//        ));


        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => Mage::helper('gallery')->__('Store View'),
                'title' => Mage::helper('gallery')->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            'style' => 'height:150px',
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $fieldset->addField('is_active', 'select', array(
            'label' => Mage::helper('gallery')->__('Status'),
            'title' => Mage::helper('gallery')->__('Status'),
            'name' => 'is_active',
            'required' => true,
            'options' => array(
                '1' => Mage::helper('gallery')->__('Enabled'),
                '0' => Mage::helper('gallery')->__('Disabled'),
            ),
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $fieldset->addField('from_time', 'date', array(
            'name' => 'from_time',
            'time' => true,
            'label' => Mage::helper('gallery')->__('From Time'),
            'title' => Mage::helper('gallery')->__('From Time'),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'format' => $dateFormatIso,
        ));

        $fieldset->addField('to_time', 'date', array(
            'name' => 'to_time',
            'time' => true,
            'label' => Mage::helper('gallery')->__('To Time'),
            'title' => Mage::helper('gallery')->__('To Time'),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'format' => $dateFormatIso,
        ));

//        print_r($model->getData());
//        exit();
//        $form->setUseContainer(true);
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
