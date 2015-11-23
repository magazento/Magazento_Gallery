<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Item extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    
    public function __construct()
    {
//        if (is_null($this->_addButtonLabel)) {
//            $this->_addButtonLabel = $this->__('Add New');
//        }
//        if(is_null($this->_backButtonLabel)) {
//            $this->_backButtonLabel = $this->__('Back');
//        }
        
        $this->_controller = 'admin_item';
        $this->_blockGroup = 'gallery';
        $this->_headerText = Mage::helper('gallery')->__('MAGAZENTO G★LLERY');
        $this->_addButtonLabel = Mage::helper('gallery')->__('Add Image');
        parent::__construct();

        $this->setTemplate('widget/grid/container.phtml');

        $this->_addButton('add', array(
            'label'     => $this->getAddButtonLabel(),
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/newimage') .'\')',
            'class'     => 'add',
        ));
        $this->_addButton('addvideo', array(
            'label'     => 'Add Video',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/newvideo') .'\')',
            'class'     => 'add',
        ));
        $this->_addButton('addyoutube', array(
            'label'     => 'Add Youtube',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/newyoutube') .'\')',
            'class'     => 'add',
        ));
        $this->_addButton('addvimeo', array(
            'label'     => 'Add Vimeo',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/newvimeo') .'\')',
            'class'     => 'add',
        ));
        $this->_addButton('addcatagory', array(
            'label'     => 'Add Category',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/admin_category/new') .'\')',
            'class'     => 'add',
        ));
        $this->_addButton('viewgallery', array(
            'label'     => 'View Gallery',
            'onclick'   => 'setLocation(\'' . Mage::getBaseUrl().'gallery' .'\')',
            'class'     => 'add',
        ));
    }
    
}
