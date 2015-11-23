<?php

class Magazento_Gallery_Block_Admin_Item_Edit_Tab_Ajax_Serializer extends Mage_Core_Block_Template
{
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('catalog/product/edit/serializer.phtml');
        return $this;
    }

    public function getProductsJSON()
    {
        $result = array();
        if ($this->getProducts()) {
            foreach ($this->getProducts() as $iProductId) {
                $result[$iProductId] = array('qty' => null, 'position' => 0);
            }
        }
        return $result ? Zend_Json_Encoder::encode($result) : '{}';
    }
} 