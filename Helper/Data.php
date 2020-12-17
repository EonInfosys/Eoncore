<?php
/**
 * EaDesgin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eoninfosys.ro so we can send you a copy immediately.
 *
 * @category    eoninfosysdev_pdfgenerator
 * @copyright   Copyright (c) 2008-2016 EonInfosys by Eco Active S.R.L.
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

namespace EonInfosys\Eoncore\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const EONINFOSYS = 'EonInfosys_';
    const EONINFOSYS_URL = 'https://www.eoninfosys.net/';

    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    private $_moduleList;

    /**
     * @var \Magento\Framework\Module\ResourceInterface
     */
    private $moduleResource;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Framework\HTTP\Client\Curl
     * */
    private $curl;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     * @param \Magento\Framework\Module\ResourceInterface $moduleResource
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\HTTP\Client\Curl $curl
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\Module\ResourceInterface $moduleResource,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\HTTP\Client\Curl $curl
    ) {
        $this->_moduleList = $moduleList;
        $this->moduleResource = $moduleResource;
        $this->storeManager = $storeManager;
        $this->curl = $curl;
        parent::__construct($context);
    }

    /**
     * Prepare the data to send to the connector
     */
    public function dataSet()
    {
        $base = $this->storeManager->getStore(0)->getBaseUrl();
        $modules = $this->_moduleList->getNames();

        foreach ($modules as $module) {
            if (strpos($module, self::EONINFOSYS) !== false) {
                $this->connect([
                    'url' => $base,
                    'version' => $this->moduleResource->getDbVersion($module),
                    'extension' => $module,
                    'mversion' => 2
                ]);
            }
        }

    }

    /**
     * @param $params the params to send to EonInfosys
     */
    private function connect($params)
    {
        $this->curl->post(self::EONINFOSYS_URL . 'track/index/update', $params);
    }

}
