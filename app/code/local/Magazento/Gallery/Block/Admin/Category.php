<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'admin_category';
        $this->_blockGroup = 'gallery';
        $this->_headerText = Mage::helper('gallery')->__('G★llery categories');
        $this->_addButtonLabel = Mage::helper('gallery')->__('Add New Category');
        parent::__construct();
    }

}
