<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
    	$this->_objectId = 'category_id';
        $this->_controller = 'admin_category';
        $this->_blockGroup = 'gallery';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('gallery')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('gallery')->__('Delete Item'));
        
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        

        $this->_formScripts[] = "
           function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'block_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                }
            }
            
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
            
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('gallery_category')->getId()) {
            return Mage::helper('gallery')->__("Edit category: %s", $this->htmlEscape(Mage::registry('gallery_category')->getTitle()));
        }
        else {
            return Mage::helper('gallery')->__('New Category');
        }
    }

}
