<?php

class Magazento_Gallery_Model_Source_Design {

    public function toOptionArray() {
        return array(
            array('value' => 'white', 'label' => Mage::helper('gallery')->__('White')),
            array('value' => 'black', 'label' => Mage::helper('gallery')->__('Black')),
        );
    }

}