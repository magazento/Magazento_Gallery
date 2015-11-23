<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('GalleryGrid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('gallery/category')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $baseUrl = $this->getUrl();
        $this->addColumn('category_id', array(
            'header' => Mage::helper('gallery')->__('ID'),
            'align' => 'left',
            'width' => '30px',
            'index' => 'category_id',
        ));
        $this->addColumn('title', array(
            'header' => Mage::helper('gallery')->__('Title'),
            'align' => 'left',
            'index' => 'title',
            'renderer'  => 'gallery/admin_category_grid_renderer_media',     
            'width' => '500px',            
        ));

        $this->addColumn('position', array(
            'header' => Mage::helper('gallery')->__('Position'),
            'align' => 'left',
            'index' => 'position',
            'width' => '30px',
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
        
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('gallery')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'
                                => array($this, '_filterStoreCondition'),
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
        
        $this->addColumn('action',
                array(
                    'header' => Mage::helper('gallery')->__('Action'),
                    'index' => 'category_id',
                    'sortable' => false,
                    'filter' => false,
                    'no_link' => true,
                    'width' => '100px',
                    'renderer' => 'gallery/admin_category_grid_renderer_action'
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
    protected function _filterPageCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addPageFilter($value);
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('category_id');
        $this->getMassactionBlock()->setFormFieldName('massaction');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('gallery')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('gallery')->__('Are you sure?')
        ));

//        array_unshift($statuses, array('label' => '', 'value' => ''));
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

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }

}
