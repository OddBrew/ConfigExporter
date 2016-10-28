<?php
/**
 * @category    Oddbrew
 * @package     Oddbrew_Oddexporter
 * @author      Alexandre Fayette <alexandre.fayette@gmail.com>
 * @link        https://github.com/OddBrew/ConfigExporter
 * @copyright   Copyright (c) 2016 Alexandre Fayette
 * @license     https://opensource.org/licenses/MIT  MIT License
 */
class Oddbrew_Oddexporter_Adminhtml_Oddexporter_Config_ExportController extends Mage_Adminhtml_Controller_Action
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
            return $this->_redirect('admin/system_config/edit', array('section' => $section));
        }
        $config = Zend_Json::encode($config);
        $fileName = $this->_getFileName($section, $group);

        return $this->_prepareDownloadResponse($fileName.'.json', $config, 'application/json');
    }

    /**
     * Export an admin config section
     *
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function sectionAction()
    {
        $section = Mage::app()->getRequest()->getParam('section');
        try{
            $config = Mage::helper('oddbrew_oddexporter')->getConfigBySection($section);
        }
        catch(Mage_Core_Exception $e){
            Mage::getSingleton('admin/session')->addError($e->getMessage());
            return $this->_redirect('admin/system_config/edit', array('section' => $section));
        }

        $config = Zend_Json::encode($config);
        $fileName = $this->_getFileName($section);

        return $this->_prepareDownloadResponse($fileName.'.json', $config, 'application/json');
    }

    protected function _getFileName($section, $group = '')
    {
        $group = $group ? $group.'_' : '';
        $currentScope = Mage::registry(Oddbrew_Oddexporter_Helper_Data::SCOPE_REGISTRY_KEY);
        $fileName = 'oddexporter_config_'.$section.'_'.$group.$currentScope['scope'].'_'.$currentScope['scope_id'];

        return $fileName;
    }
}