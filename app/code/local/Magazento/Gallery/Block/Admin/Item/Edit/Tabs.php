<?php
/*
 *  Created on Nov 16, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Gallery_Block_Admin_Item_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('gallery_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('gallery')->__('Gallery edit'));
    }

    protected function _beforeToHtml() {
        $_type = $this->getRequest()->getParam('type');
        $this->addTab('form_section_item', array(
            'label' => Mage::helper('gallery')->__('General information'),
            'title' => Mage::helper('gallery')->__('General information'),
            'content' => $this->getLayout()->createBlock('gallery/admin_item_edit_tab_form'.$_type)->toHtml(),
        ));
        $this->addTab('related', array(
            'label'     => Mage::helper('gallery')->__('Assigned Products'),
            'title'     => Mage::helper('gallery')->__('Assigned Products'),
            'url'       => $this->getUrl('*/*/related', array('_current' => true)),
            'class'     => 'ajax',
        ));     
        
        $this->addTab('form_section_categories', array(
            'label'     => Mage::helper('gallery')->__('Assigned Categories'),
            'title'     => Mage::helper('gallery')->__('Assigned Categories'),
            'content'   => $this->getLayout()->createBlock('gallery/admin_item_edit_tab_categories')->toHtml(),
        ));               
        
        $this->addTab('form_section_page', array(
            'label'     => Mage::helper('gallery')->__('Assigned Pages'),
            'title'     => Mage::helper('gallery')->__('Assigned Pages'),
            'content'   => $this->getLayout()->createBlock('gallery/admin_item_edit_tab_page')->toHtml(),
        ));            
//        $this->addTab('form_section_other', array(
//            'label' => Mage::helper('gallery')->__('Content Information'),
//            'title' => Mage::helper('gallery')->__('Content Information'),
//            'content' => $this->getLayout()->createBlock('gallery/admin_category_edit_tab_other')->toHtml(),
//        ));

        return parent::_beforeToHtml();
    }
    
    
    protected function _toHtml()
    {
        $sContent = parent::_toHtml();
        
        $sContent .= '
        
        <script type="text/javascript">
        //<![CDATA[        

            var productLinksController = Class.create();

            productLinksController.prototype = {
                initialize : function(fieldId, products, grid) {
                    this.saveField = $(fieldId);
                    this.saveFieldId = fieldId;
                    this.products    = $H(products);
                    this.grid        = grid;
                    this.tabIndex    = 1000;
                    this.grid.rowClickCallback = this.rowClick.bind(this);
                    this.grid.initRowCallback = this.rowInit.bind(this);
                    this.grid.checkboxCheckCallback = this.registerProduct.bind(this);
                    this.grid.rows.each(this.eachRow.bind(this));
                    this.saveField.value = this.serializeObject(this.products);
                    this.grid.reloadParams = {"products[]":this.products.keys()};
                },
                eachRow : function(row) {
                    this.rowInit(this.grid, row);
                },
                registerProduct : function(grid, element, checked) {
                    if(checked){
                        if(element.inputElements) {
                            this.products.set(element.value, {});
                            for(var i = 0; i < element.inputElements.length; i++) {
                                element.inputElements[i].disabled = false;
                                this.products.get(element.value)[element.inputElements[i].name] = element.inputElements[i].value;
                            }
                        }
                    }
                    else{
                        if(element.inputElements){
                            for(var i = 0; i < element.inputElements.length; i++) {
                                element.inputElements[i].disabled = true;
                            }
                        }

                        this.products.unset(element.value);
                    }
                    this.saveField.value = this.serializeObject(this.products);
                    this.grid.reloadParams = {"products[]":this.products.keys()};
                },
                serializeObject : function(hash) {
                    var clone = hash.clone();
                    clone.each(function(pair) {
                        clone.set(pair.key, encode_base64(Object.toQueryString(pair.value)));
                    });
                    return clone.toQueryString();
                },
                rowClick : function(grid, event) {
                    var trElement = Event.findElement(event, "tr");
                    var isInput   = Event.element(event).tagName == "INPUT";
                    if(trElement){
                        var checkbox = Element.select(trElement, "input");
                        if(checkbox[0]){
                            var checked = isInput ? checkbox[0].checked : !checkbox[0].checked;
                            this.grid.setCheckboxChecked(checkbox[0], checked);
                        }
                    }
                },
                inputChange : function(event) {
                    var element = Event.element(event);
                    if(element && element.checkboxElement && element.checkboxElement.checked){
                        this.products.get(element.checkboxElement.value)[element.name] = element.value;
                        this.saveField.value = this.serializeObject(this.products);
                    }
                },
                rowInit : function(grid, row) {
                    var checkbox = $(row).select(".checkbox")[0];
                    var inputs = $(row).select(".input-text");
                    if(checkbox && inputs.length > 0) {
                        checkbox.inputElements = inputs;
                        for(var i = 0; i < inputs.length; i++) {
                            inputs[i].checkboxElement = checkbox;
                            if(this.products.get(checkbox.value) && this.products.get(checkbox.value)[inputs[i].name]) {
                                inputs[i].value = this.products.get(checkbox.value)[inputs[i].name];
                            }
                            inputs[i].disabled = !checkbox.checked;
                            inputs[i].tabIndex = this.tabIndex++;
                            Event.observe(inputs[i],"keyup", this.inputChange.bind(this));
                            Event.observe(inputs[i],"change", this.inputChange.bind(this));
                        }
                    }
                }
            };        
        //]]>
        </script>        
        ';
        
        return $sContent;
    }    

}