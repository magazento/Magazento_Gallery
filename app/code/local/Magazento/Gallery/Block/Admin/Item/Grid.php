<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Item_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('GalleryGrid');
        $this->setDefaultSort('item_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('gallery/item')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $baseUrl = $this->getUrl();
        $this->addColumn('item_id', array(
            'header' => Mage::helper('gallery')->__('ID'),
            'align' => 'left',
            'width' => '30px',
            'index' => 'item_id',
        ));
        
        $this->addColumn('media', array(
            'header' => Mage::helper('gallery')->__('Media'),
            'align' => 'left',
            'index' => 'media',
            'width' => '200px',            
            'renderer'  => 'gallery/admin_item_grid_renderer_media'            
        ));
        
        $this->addColumn('item_type', array(
            'header' => Mage::helper('gallery')->__('Type'),
            'align' => 'left',
            'index' => 'item_type',
            'type' => 'options',
            'options' => array(
                'image'  => Mage::helper('gallery')->__('Image file'),
                'video'   => Mage::helper('gallery')->__('Video file'),
                'youtube'=> Mage::helper('gallery')->__('Youtube'),
                'vimeo'  => Mage::helper('gallery')->__('Vimeo'),
            ),            
        ));
        
        $this->addColumn('title', array(
            'header' => Mage::helper('gallery')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));

        $this->addColumn('position', array(
            'header' => Mage::helper('gallery')->__('Position'),
            'align' => 'left',
            'index' => 'position',
            'width' => '30px',
        ));
        $this->addColumn('url', array(
            'header' => Mage::helper('gallery')->__('Url'),
            'align' => 'left',
            'index' => 'url',
//            'width' => '100px',
        ));

        
        if ($categories = Mage::getModel('gallery/category')->getCategories4Grid()) {
            $this->addColumn('category_id', array(
                'header' => Mage::helper('gallery')->__('Category'),
                'align' => 'left',
                'index' => 'category_id',
                'type' => 'options',
                'options' => $categories,    
                'filter_condition_callback'  => array($this, '_filterCategoryCondition'),
            ));
        }
        
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('gallery')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'  => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('is_active', array(
            'header' => Mage::helper('gallery')->__('Status'),
            'index' => 'is_active',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('gallery')->__('Disabled'),
                1 => Mage::helper('gallery')->__('Enabled'),
            ),
        ));

        $this->addColumn('from_time', array(
            'header' => Mage::helper('gallery')->__('From Time'),
            'index' => 'from_time',
            'type' => 'datetime',
        ));

        $this->addColumn('to_time', array(
            'header' => Mage::helper('gallery')->__('To Time'),
            'index' => 'to_time',
            'type' => 'datetime',
        ));

        $this->addColumn('action',
                array(
                    'header' => Mage::helper('gallery')->__('Action'),
                    'index' => 'item_id',
                    'sortable' => false,
                    'filter' => false,
                    'no_link' => true,
                    'width' => '100px',
                    'renderer' => 'gallery/admin_item_grid_renderer_action'
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('gallery')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('gallery')->__('XML'));
        return parent::_prepareColumns();
    }

    protected function _afterLoadCollection() {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    protected function _filterStoreCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }

    protected function _filterCategoryCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addCategoryFilter($value);
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('item_id');
        $this->getMassactionBlock()->setFormFieldName('massaction');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('gallery')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('gallery')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('gallery')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('gallery')->__('Status'),
                    'values' => array(
                        0 => Mage::helper('gallery')->__('Disabled'),
                        1 => Mage::helper('gallery')->__('Enabled'),
                    ),
                )
            )
        ));
        return $this;
    }

//    public function getRowUrl($row) {
//        return $this->getUrl('*/*/edit',  array('item_id' => $row->getId(), 'type' => $row->getData('item_type')));
//    }

}
