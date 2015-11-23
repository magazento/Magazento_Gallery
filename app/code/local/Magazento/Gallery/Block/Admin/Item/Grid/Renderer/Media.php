<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Item_Grid_Renderer_Media extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{

  public function render(Varien_Object $row)
    {
        $html = '';
        switch ($row->getData('item_type')) {
            case 'image':
                    $html = '<img style="width:200px; border:1px solid #aaa;" src="'.Mage::helper('gallery')->getImageFileHttp().DS.$row->getData('item_address').'">';
                break;
            case 'video':
                    $ext = pathinfo($row->getData('item_address'), PATHINFO_EXTENSION);
                    if ($ext == 'flv') {
                        $html = '<a target="_blank" href="'.Mage::helper('gallery')->getVideoFileHttp().DS.$row->getData('item_address').'">'.$row->getData('item_address').'</a>';
                    }
                    if ($ext == 'mp4') {
                        $html = '<video width="200" controls>';
                        $html.= '<source src="data-src="'.Mage::helper('gallery')->getVideoFileHttp().DS.$row->getData('item_address').'" type="video/mp4">';
                        $html.= '</video>';
                    }
                break;
            case 'youtube':
                    $html = '<iframe width="200" height="200" src="http://www.youtube.com/embed/'.$row->getData('item_address').'" frameborder="0" allowfullscreen></iframe>';
                break;
            case 'vimeo':
                    $html = '<iframe src="http://player.vimeo.com/video/'.$row->getData('item_address').'?badge=0" width="200" height="200" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                break;

            default:
                break;
        }
        return $html;
    }    
}
