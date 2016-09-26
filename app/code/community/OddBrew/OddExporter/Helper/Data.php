<?php
/**
 * @category    OddBrew
 * @package     OddBrew_Exporter
 * @author      Alexandre Fayette <alexandre.fayette@gmail.com>
 * @link        https://github.com/OddBrew/ConfigExporter
 * @copyright   Copyright (c) 2016 Alexandre Fayette
 * @license     https://opensource.org/licenses/MIT  MIT License
 */
class OddBrew_OddExporter_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Retrieves all modules name
     *
     * @return array
     */
    public function getAllModulesNames()
    {
        $modules = array_keys((array)Mage::getConfig()->getNode('modules')->children());
        sort($modules);

        return $modules;
    }

    /**
     * Retrieves an array containing the config of the specified section/group couple.
     * Key is the config path, value is the config value.
     *
     * @param string $section
     * @param string $group
     *
     * @return array
     * @throws Mage_Core_Exception
     */
    public function getConfigByGroup($section, $group)
    {
        $config     = Mage::getConfig()->loadModulesConfiguration('system.xml');
        $fieldsNode = $config->getNode('sections/' . $section . '/groups/' . $group . '/fields');
        if (!$fieldsNode) {
            Mage::throwException($this->__('Bad section and/or group config name'));
        }
        if (!$fieldsNode->hasChildren()) {
            Mage::throwException($this->__('No field to export under this group'));
        }

        $currentConfigScope = $this->getCurrentConfigScope();
        if ($currentConfigScope['scope'] == 'wesbites') {
            /** @var Mage_Core_Model_Website $configModel */
            $configModel = Mage::getModel('core/website')->load($currentConfigScope['scope_id']);
        } else {
            /** @var Mage_Core_Model_Store $configModel */
            $configModel = Mage::getModel('core/store')->load($currentConfigScope['scope_id']);
        }

        $result = array();
        /** @var SimpleXMLElement $field */
        foreach ($fieldsNode->children() as $field) {
            $path          = $section . '/' . $group . '/' . $field->getName();
            $result[$path] = $configModel->getConfig($path);
        }

        return $result;
    }

    /**
     * Return current config scope in admin
     *
     * @return array
     */
    public function getCurrentConfigScope()
    {
        /** @var Mage_Adminhtml_Model_Config_Data $adminConfig */
        $adminConfig = Mage::getSingleton('adminhtml/config_data');
        $scopeId = 0;
        $scope = 'default';
        if($scopeCode = $adminConfig->getStore()){
            $scopeId = Mage::getModel('core/store')->load($scopeCode)->getId();
            $scope = 'stores';
        }
        elseif($scopeCode = $adminConfig->getWebsite()){
            $scopeId = Mage::getModel('core/website')->load($scopeCode)->getId();
            $scope = 'websites';
        }

        return array(
            'scope_id'   => $scopeId,
            'scope'     => $scope
        );
    }
}