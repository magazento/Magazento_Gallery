<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Category_Grid_Renderer_Pages extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{

  public function render(Varien_Object $row)
    {
        $html='';
        $pages = explode(',',$row->getData('page_ids'));
        $collection = Mage::getResourceModel('cms/page_collection')
                        ->addFieldToFilter('page_id',array(array('in'=>$pages)))
                        ->load();
//        
        foreach ($collection as $page) {
            $html.=$page->getTitle().'<br/>';
        } 
        return $html;
//        return $row->getData('page_ids');
    }    
}
