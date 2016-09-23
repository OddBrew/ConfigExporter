<?php
/**
 * @category    OddBrew
 * @package     OddBrew_Exporter
 * @author      Alexandre Fayette <alexandre.fayette@gmail.com>
 * @link        https://github.com/OddBrew/ConfigExporter
 * @copyright   Copyright (c) 2016 Alexandre Fayette
 * @license     https://opensource.org/licenses/MIT  MIT License
 */
class OddBrew_OddExporter_Adminhtml_OddExporter_Config_ExportController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Export an admin config group
     */
    public function groupAction()
    {
        $section = Mage::app()->getRequest()->getParam('section');
        $group = Mage::app()->getRequest()->getParam('group');
    }
}