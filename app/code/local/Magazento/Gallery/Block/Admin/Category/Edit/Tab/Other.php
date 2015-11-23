<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Category_Edit_Tab_Other extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $model = Mage::registry('gallery_category');
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('additional_form', array('legend' => Mage::helper('gallery')->__('Content Information')));



        if (Mage::helper('gallery')->versionUseWysiwig()) {
            $wysiwygConfig = Mage::getSingleton('gallery/wysiwyg_config')->getConfig();
        } else {
            $wysiwygConfig = '';
        }

        $fieldset->addField('content_top', 'editor', array(
            'name' => 'content_top',
            'label' => Mage::helper('gallery')->__('Content Top'),
            'title' => Mage::helper('gallery')->__('Content Top'),
            'style' => 'height:16em',
            'config' => $wysiwygConfig,
            'required' => false,
        ));
        $fieldset->addField('content_bottom', 'editor', array(
            'name' => 'content_bottom',
            'label' => Mage::helper('gallery')->__('Content Bottom'),
            'title' => Mage::helper('gallery')->__('Content Bottom'),
            'style' => 'height:16em',
            'config' => $wysiwygConfig,
            'required' => false,
        ));


        $fieldset->addField('script_java', 'note', array(
            'text' => '<script type="text/javascript">
				            var inputDateFrom = document.getElementById(\'category_from_time\');
				            var inputDateTo = document.getElementById(\'category_to_time\');
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


//        $form->setUseContainer(true);
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

}