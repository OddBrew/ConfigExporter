<?php
/**
 * @category    OddBrew
 * @package     OddBrew_Exporter
 * @author      Alexandre Fayette <alexandre.fayette@gmail.com>
 * @link        https://github.com/OddBrew/ConfigExporter
 * @copyright   Copyright (c) 2016 Alexandre Fayette
 * @license     https://opensource.org/licenses/MIT  MIT License
 */
class OddBrew_OddExporter_Block_Adminhtml_System_Config_Edit_Upload extends Mage_Adminhtml_Block_Template
{
    const FILES_INPUT_NAME  = 'oddfiles';

    public function __construct()
    {
        $this->setTemplate('oddbrew/oddexporter/system/config/edit/upload/standard.phtml');
        parent::__construct();
    }

    public function getFormAction()
    {
        return Mage::helper('adminhtml')->getUrl('*/oddexporter_config_import/files/');
    }

    public function getFilesInputName()
    {
        return self::FILES_INPUT_NAME;
    }
}