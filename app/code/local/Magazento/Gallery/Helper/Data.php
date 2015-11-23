<?php
/*
*  Created on Nov 16, 2012
*  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
*  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
*  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
*/
?>
<?php class Magazento_Gallery_Helper_Data extends Mage_Core_Helper_Abstract {
    
    public function versionUseAdminTitle() {
        $info = explode('.', Mage::getVersion());
        if ($info[0] > 1) {
            return true;
        }
        if ($info[1] > 3) {
            return true;
        }
        return false;
    }

    public function versionUseWysiwig() {
        $info = explode('.', Mage::getVersion());
        if ($info[0] > 1) {
            return true;
        }
        if ($info[1] > 3) {
            return true;
        }
        return false;
    }
    
    public function numberArray($max,$text) {

        $items = array();
        for ($index = 1; $index <= $max; $index++) {
            $items[$index]=$text.' '.$index;
        }
        return $items;
    }
    

    public function loadCategories($item) {
        $categories = $item->getData("category_id");
        $categoriesString = 'catall ';

        if ($categories) {
            foreach ($categories as $cat) {
                $categoriesString.=' cat'.$cat;
            }
        }
        return $categoriesString;
    }
    public function getItemYoutube($item,$height = 408,$width = 720) {
        $http = '<iframe height="'.$height.'" width="'.$width.'" src="http://www.youtube.com/embed/'.$item->getData('item_address').'" frameborder="0" allowfullscreen></iframe>';
        return $http;
    }
    public function getItemVimeo($item,$height = 408,$width = 720) {
        $http = '<iframe src="http://player.vimeo.com/video/'.$item->getData('item_address').'?badge=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
        return $http;
    }
    public function getItemVideo($item) {
        $http = Mage::getBaseUrl('media') . DS. 'magazento_gallery/video'.DS.$item->getData('item_address');
        $http = '<a href="'.$http.'" style="display:block;width:100%;height:100%" id="individuellid-1"></a>';        
        return $http;
    }
    public function getItemImageHttp($item) {
        $http = Mage::getBaseUrl('media') .'magazento_gallery/image'.DS.$item->getData('item_address');
        return $http;
    }    
    public function getItemVideoHttp($item) {
        $http = Mage::getBaseUrl('media') . 'magazento_gallery/video'.DS.$item->getData('item_address');
        return $http;
    }    
    
    public function getImageFilePath() {
        return Mage::getBaseDir('media') . DS. 'magazento_gallery'.DS.'image';
    }
    public function getVideoFilePath() {
        return Mage::getBaseDir('media') . DS. 'magazento_gallery'.DS.'video';
    }
    public function getBackgroundImageFilePath() {
        return Mage::getBaseDir('media') . DS. 'magazento_gallery'.DS.'background_image';
    }    
    
    public function getImageFileHttp() {
        return Mage::getBaseUrl('media') . 'magazento_gallery'.DS.'image';
    }
    public function getVideoFileHttp() {
        return Mage::getBaseUrl('media') . 'magazento_gallery'.DS.'video';
    }
    public function getBackgroundImageFileHttp() {
        return Mage::getBaseUrl('media') . DS. 'magazento_gallery'.DS.'background_image';
    }        
    
    
}
