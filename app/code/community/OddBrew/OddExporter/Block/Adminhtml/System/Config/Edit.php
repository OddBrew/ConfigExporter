<?php
/**
 * @category    OddBrew
 * @package     OddBrew_Exporter
 * @author      Alexandre Fayette <alexandre.fayette@gmail.com>
 * @link        https://github.com/OddBrew/ConfigExporter
 * @copyright   Copyright (c) 2016 Alexandre Fayette
 * @license     https://opensource.org/licenses/MIT  MIT License
 */
class OddBrew_OddExporter_Block_Adminhtml_System_Config_Edit extends Mage_Adminhtml_Block_System_Config_Edit
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('oddbrew/oddexporter/system/config/edit.phtml');
    }

    protected function _prepareLayout()
    {
        $section = Mage::app()->getRequest()->getParam('section');
        $url = Mage::helper('adminhtml')->getUrl('*/oddexporter_config_export/section', array(
            'section' => $section,
            'store' => Mage::app()->getRequest()->getParam('store'),
            'website' => Mage::app()->getRequest()->getParam('website')
        ));

        $this->setChild('export_config_section',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => $this->__('Export Section'),
                    'onclick'   => "setLocation('{$url}'); return false;",
                    'class' => 'action',
                ))
        );

        return parent::_prepareLayout();
    }

    public function getSaveButtonHtml()
    {
        $html = $this->getChildHtml('save_button');
        $html .= $this->getExportSectionButtonHtml();

        return $html;
    }

    public function getExportSectionButtonHtml()
    {
        return $this->getChildHtml('export_config_section');
    }
}