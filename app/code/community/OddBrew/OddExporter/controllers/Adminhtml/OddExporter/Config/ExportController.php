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
        try{
            $config = Mage::helper('oddbrew_oddexporter')->getConfigByGroup($section, $group);
        }
        catch(Mage_Core_Exception $e){
            Mage::getSingleton('admin/session')->addError($e->getMessage());
            return $this->_redirect('admin/system_config/edit', array('section' => $section, 'group' => $group));
        }
        $config = Zend_Json::encode($config);
        $fileName = $this->_getFileName($section, $group);

        return $this->_prepareDownloadResponse($fileName.'.json', $config, 'application/json');
    }

    protected function _getFileName($section, $group = '')
    {
        $group = $group ? $group.'_' : '';
        $currentScope = Mage::registry(OddBrew_OddExporter_Helper_Data::SCOPE_REGISTRY_KEY);
        $fileName = 'oddexporter_config_'.$section.'_'.$group.$currentScope['scope'].'_'.$currentScope['scope_id'];

        return $fileName;
    }
}