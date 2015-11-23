<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Item_Edit_Tab_Formvideo extends Mage_Adminhtml_Block_Widget_Form {


    protected function _prepareForm() {
        $model = Mage::registry('gallery_item');
        $model->setData('item_type','video');
      
        $video = '';
        if ($model->getData('item_address')) {
           $path = Mage::helper('gallery')->getVideoFileHttp(); 
           $video = 'Attached video: <a target="blank" href="'.$path.DS.$model->getData('item_address').'">'.$path.DS.$model->getData('item_address').'</a>';
           $model->setData('video',$path.$model->getData('item_address'));
        }

        
        $form = new Varien_Data_Form(array('id' => 'edit_form_item', 'action' => $this->getData('action'), 'method' => 'post'));
        $form->setHtmlIdPrefix('item_');
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('gallery')->__('Video Information'), 'class' => 'fieldset-wide'));
        if ($model->getItemId()) {
            $fieldset->addField('item_id', 'hidden', array(
                'name' => 'item_id',
            ));
        }
        $fieldset->addField('item_type', 'hidden', array(
            'name'  => 'item_type',
        ));        
        
        $fieldset->addField('video', 'image', array(
          'label'     => Mage::helper('gallery')->__('Video'),
          'required'  => true,
          'name'      => 'video',
          'note'      => $video,
        ));
        
        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => Mage::helper('gallery')->__('Title'),
            'title' => Mage::helper('gallery')->__('Title'),
            'required' => true,
            'value' => 'image',
        ));
        
        $fieldset->addField('url', 'text', array(
            'name' => 'url',
            'label' => Mage::helper('gallery')->__('Url'),
            'title' => Mage::helper('gallery')->__('Url'),
            'required' => false,
        ));
        //---=---=
        $fieldset->addField('category_id', 'multiselect', array(
            'name' => 'categories[]',
            'label' => Mage::helper('gallery')->__('Categories'),
            'title' => Mage::helper('gallery')->__('Categories'),
            'required' => true,
            'values' => Mage::getModel('gallery/category')->getCategories4Form(),
            'style' => 'height:250px',
        ));

        $fieldset->addField('position', 'select', array(
            'name' => 'position',
            'label' => Mage::helper('gallery')->__('Position'),
            'title' => Mage::helper('gallery')->__('Position'),
            'required' => true,
            'options' => Mage::helper('gallery')->numberArray(20,Mage::helper('gallery')->__('')),
        ));
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


        if (Mage::helper('gallery')->versionUseWysiwig()) {
            $wysiwygConfig = Mage::getSingleton('gallery/wysiwyg_config')->getConfig();
        } else {
            $wysiwygConfig = '';
        }

        $fieldset->addField('content', 'editor', array(
            'name' => 'content',
            'label' => Mage::helper('gallery')->__('Content'),
            'title' => Mage::helper('gallery')->__('Content'),
            'style' => 'height:16em',
            'config' => $wysiwygConfig,
            'required' => false,
        ));

        $fieldset->addField('script_java', 'note', array(
            'text' => '<script type="text/javascript">
				            var inputDateFrom = document.getElementById(\'item_from_time\');
				            var inputDateTo = document.getElementById(\'item_to_time\');
            				inputDateTo.onchange=function(){dateTestAnterior(this)};
				            inputDateFrom.onchange=function(){dateTestAnterior(this)};


				            function dateTestAnterior(inputChanged){
				            	dateFromStr=inputDateFrom.value;
				            	dateToStr=inputDateTo.value;

				            	if(dateFromStr.indexOf(\'.\')==-1)
				            		dateFromStr=dateFromStr.replace(/(\d{1,2} [a-zA-Zâêûîôùàçèé]{3})[^ \.]+/,"$1.");
				            	if(dateToStr.indexOf(\'.\')==-1)
				            		dateToStr=dateToStr.replace(/(\d{1,2} [a-zA-Zâêûîôùàçèé]{3})[^ \.]+/,"$1.");

				            	fromDate= Date.parseDate(dateFromStr,"%e %b %Y %H:%M:%S");
				            	toDate= Date.parseDate(dateToStr,"%e %b %Y %H:%M:%S");

				            	if(dateToStr!=\'\'){
					            	if(fromDate>toDate){
	            						inputChanged.value=\'\';
	            						alert(\'' . Mage::helper('gallery')->__('You must set a date to value greater than the date from value') . '\');
					            	}
				            	}
            				}
            			</script>',
            'disabled' => true
        ));
        

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
