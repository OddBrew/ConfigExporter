<?php
/**
 * @category    Oddbrew
 * @package     Oddbrew_Oddexporter
 * @author      Alexandre Fayette <alexandre.fayette@gmail.com>
 * @link        https://github.com/OddBrew/ConfigExporter
 * @copyright   Copyright (c) 2016 Alexandre Fayette
 * @license     https://opensource.org/licenses/MIT  MIT License
 */
class Oddbrew_Oddexporter_Helper_Data extends Mage_Core_Helper_Abstract
{
    const SCOPE_REGISTRY_KEY = 'oddbrew_admin_config_scope';

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
        Mage::register(self::SCOPE_REGISTRY_KEY, $currentConfigScope);
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
     * Retrieves an array containing the config of the specified section.
     * Key is the config path, value is the config value.
     *
     * @param $section
     *
     * @return array
     * @throws Mage_Core_Exception
     */
    public function getConfigBySection($section)
    {
        $config = Mage::getConfig()->loadModulesConfiguration('system.xml');
        $groupsNode = $config->getNode('sections/' . $section . '/groups');
        if (!$groupsNode) {
            Mage::throwException($this->__('Bad section config name'));
        }
        if (!$groupsNode->hasChildren()) {
            Mage::throwException($this->__('No field to export under this section'));
        }

        $currentConfigScope = $this->getCurrentConfigScope();
        Mage::register(self::SCOPE_REGISTRY_KEY, $currentConfigScope);
        if ($currentConfigScope['scope'] == 'wesbites') {
            /** @var Mage_Core_Model_Website $configModel */
            $configModel = Mage::getModel('core/website')->load($currentConfigScope['scope_id']);
        } else {
            /** @var Mage_Core_Model_Store $configModel */
            $configModel = Mage::getModel('core/store')->load($currentConfigScope['scope_id']);
        }

        $result = array();
        /** @var SimpleXMLElement $group */
        foreach ($groupsNode->children() as $group) {
            $groupName = $group->getName();
            $fieldsNode = $config->getNode('sections/' . $section . '/groups/' . $groupName . '/fields');
            /** @var SimpleXMLElement $field */
            if ($fieldsNode->hasChildren()) {
                foreach ($fieldsNode->children() as $field) {
                    $path          = $section . '/' . $groupName . '/' . $field->getName();
                    $result[$path] = $configModel->getConfig($path);
                }
            }
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
        $scopeId = 0;
        $scope = 'default';
        if($scopeCode = Mage::app()->getRequest()->getParam('store')){
            $scopeId = Mage::getModel('core/store')->load($scopeCode)->getId();
            $scope = 'stores';
        }
        elseif($scopeCode = Mage::app()->getRequest()->getParam('website')){
            $scopeId = Mage::getModel('core/website')->load($scopeCode)->getId();
            $scope = 'websites';
        }

        return array(
            'scope_id'   => $scopeId,
            'scope'     => $scope
        );
    }
}