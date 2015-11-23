<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Category_Edit_Tab_Page extends Mage_Adminhtml_Block_Widget_Form {


    protected function _prepareForm() {
        $model = Mage::registry('gallery_category');
        $data = $model->getData('page_ids');
//        var_dump($data);
        $model->setData('pages',  explode(',', $data));
        
        
        $form = new Varien_Data_Form(array('id' => 'edit_form_category', 'action' => $this->getData('action'), 'method' => 'post'));
        $form->setHtmlIdPrefix('category_');
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('gallery')->__('Assignet Pages'), 'class' => 'fieldset-wide'));
        if ($model->getCategoryId()) {
            $fieldset->addField('category_id', 'hidden', array(
                'name' => 'category_id',
            ));
        }
        $pages = Mage::getModel('gallery/category')->getPages4Form();
        $fieldset->addField('pages', 'multiselect', array(
            'name' => 'pages[]',
            'label' => Mage::helper('gallery')->__('Store View'),
            'title' => Mage::helper('gallery')->__('Store View'),
            'required' => false,
            'values' => $pages,
        'style' => 'height:450px',
        ));


//        print_r($model->getData());
//        exit();
//        $form->setUseContainer(true);
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
