<?php
/**
 * @category    OddBrew
 * @package     OddBrew_Exporter
 * @author      Alexandre Fayette <alexandre.fayette@gmail.com>
 * @link        https://github.com/OddBrew/ConfigExporter
 * @copyright   Copyright (c) 2016 Alexandre Fayette
 * @license     https://opensource.org/licenses/MIT  MIT License
 */
class OddBrew_OddExporter_Adminhtml_OddExporter_ConfigExporterController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('System'))->_title($this->__('Tools'))->_title($this->__('Configurations Exporter'));

        $this->_initAction()
            ->_setActiveMenu('system/tools/config_export')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Export Configurations'), Mage::helper('adminhtml')->__('Export Configurations'))
            ->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('System'), Mage::helper('adminhtml')->__('System'))
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Tools'), Mage::helper('adminhtml')->__('Tools'));

        return $this;
    }
}