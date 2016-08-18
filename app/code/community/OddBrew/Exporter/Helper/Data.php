<?php
/**
 * @category    OddBrew
 * @package     OddBrew_Exporter
 * @author      Alexandre Fayette <alexandre.fayette@gmail.com>
 * @link        https://github.com/OddBrew/ConfigExporter
 * @copyright   Copyright (c) 2016 Alexandre Fayette
 * @license     https://opensource.org/licenses/MIT  MIT License
 */
class OddBrew_Exporter_Helper_Data extends Mage_Core_Helper_Abstract
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
}