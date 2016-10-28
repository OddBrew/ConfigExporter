<?php
/**
 * @category    OddBrew
 * @package     OddBrew_Exporter
 * @author      Alexandre Fayette <alexandre.fayette@gmail.com>
 * @link        https://github.com/OddBrew/ConfigExporter
 * @copyright   Copyright (c) 2016 Alexandre Fayette
 * @license     https://opensource.org/licenses/MIT  MIT License
 */
class OddBrew_OddExporter_Adminhtml_OddExporter_Config_ImportController extends Mage_Adminhtml_Controller_Action
{

    public function filesAction()
    {
        $files = $_FILES[OddBrew_OddExporter_Block_Adminhtml_System_Config_Edit_Upload::FILES_INPUT_NAME];

        $this->_redirect('*/system_config/');
    }
}