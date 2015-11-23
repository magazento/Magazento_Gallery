<?php

class Magazento_Gallery_Block_Help extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {

    public function render(Varien_Data_Form_Element_Abstract $element) {
        $content = '<p></p>';
        $content.= '<style>';
        $content.= '.magazento-help {
                        background:#FAFAFA;
                        border: 1px solid #CCCCCC;
                        margin-bottom: 10px;
                        padding: 10px;
                        height:auto;

                    }
                    .magazento-help h3 {
                        color: #EA7601;
                    }
                    .contact-type {
                        color: #EA7601;
                        font-weight:bold;
                    }
                    .magazento-help .info {
                        border: 1px solid #CCCCCC;
                        background:#E7EFEF;
                        padding: 5px 10px 0 5px;
                        height:190px;
                    }
                    ';
        $content.= '</style>';


        $content.= '<div class="magazento-help">';
            $content.= '<div class="info">';
            $content.= '<h3> Additional Help</h3>';
            $content.= 'We recommend to add additional block near your product price - it will increase percent of customers feedbacks.<br/>';
            $content.= 'In demo I added it to this file <i> /app/design/frontend/default/default/template/catalog/product/view.phtml</i><br/>';
            $content.= '<b> &lt;?php echo $this-&gt;getLayout()-&gt;createBlock(\'core/template\')-&gt;setTemplate(\'magazento/gallery/data.phtml\')-&gt;toHtml(); ?&gt; </b>';
            $content.= '<br/>';
            $content.= '<br/>';
            $content.= '<span class="contact-type">Also if you have problems with displaying this extension try do following:</span><br/>';
            $content.= 'Try fix this problem with editing this extension <strong>style.css</strong> at <i>skin/frontend/base_default/magazento_pricefeedback</i> <br/>';
            $content.= 'jQuery conflict - for solving this problem try to disable other custom magento extension and look how extensions works without them.';

            $content.= '</div>';
        $content.= '</div>';

        return $content;


    }


}
