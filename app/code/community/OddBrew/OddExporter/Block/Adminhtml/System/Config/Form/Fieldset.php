<?php
/**
 * @category    OddBrew
 * @package     OddBrew_Exporter
 * @author      Alexandre Fayette <alexandre.fayette@gmail.com>
 * @link        https://github.com/OddBrew/ConfigExporter
 * @copyright   Copyright (c) 2016 Alexandre Fayette
 * @license     https://opensource.org/licenses/MIT  MIT License
 */
class OddBrew_OddExporter_Block_Adminhtml_System_Config_Form_Fieldset extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{

    protected $_controllerName = 'system_config';
    /**
     * Return header title part of html for fieldset
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getHeaderTitleHtml($element)
    {
        if (Mage::app()->getRequest()->getControllerName() != $this->_controllerName) {
            return parent::_getHeaderTitleHtml($element);
        }

        $html = '<div class="entry-edit-head collapseable" >'
            . $this->_getExportButtonHtml($element)
            . '<a id="' . $element->getHtmlId() . '-head" href="#" onclick="Fieldset.toggleCollapse(\'' . $element->getHtmlId() . '\', \'' . $this->getUrl('*/*/state') . '\'); return false;">' .
                $element->getLegend() . '</a>
        </div>';

        return $html;
    }

    /**
     * Create export button for current group and retrieve its html
     *
     * @param Varien_Data_Form_Element_Abstract $element
     *
     * @return string
     */
    protected function _getExportButtonHtml($element)
    {
        $section = Mage::app()->getRequest()->getParam('section');
        $group = $element->getGroup()->getName();
        $url = Mage::helper('adminhtml')->getUrl('*/oddexporter_config_export/group', array(
            'section' => $section,
            'group' => $group,
            'store' => Mage::app()->getRequest()->getParam('store'),
            'website' => Mage::app()->getRequest()->getParam('website')
        ));

        /** @var Mage_Adminhtml_Block_Widget_Button $button */
        $button = Mage::app()->getLayout()->createBlock('adminhtml/widget_button');
        $button->setClass('oddbrew-system-config-export-button');
        $button->setLabel($this->__('Export'));
        $button->setStyle('margin-right : 10px; float : left;');
        $button->setOnclick("setLocation('{$url}');return false;");

        return $button->toHtml();
    }
}