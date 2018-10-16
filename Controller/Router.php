<?php

/**
 * MageTasks
 *
 * An example extension to create tasks.
 *
 * @category PShir
 * @package PShir_MageTasks
 * @author Pavel Shiriaev <pavel@shiriaev.com>
 * @copyright Copyright © 2018 Pavel Shiriaev <pavel@shiriaev.com>
 * @license https://opensource.org/licenses/OSL-3.0.php Open Software License 3.0
 */

namespace PShir\MageTasks\Controller;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\ResponseInterface;
use PShir\MageTasks\Helper\Data as Helper;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Url;

class Router implements RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;
    /**
     * Event manager
     *
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $_eventManager;
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * Config primary
     *
     * @var \Magento\Framework\App\State
     */
    protected $_appState;
    /**
     * Url
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_url;
    /**
     * Response
     *
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;

    /**
     * @var \PShir\MageTasks\Helper\Data
     */
    protected $_helper;

    public function __construct(
    ActionFactory $actionFactory,
    ManagerInterface $eventManager,
    UrlInterface $url,
    StoreManagerInterface $storeManager,
    ResponseInterface $response,
    Helper $helper
) {
    $this->actionFactory = $actionFactory;
    $this->_eventManager = $eventManager;
    $this->_url = $url;
    $this->_storeManager = $storeManager;
    $this->_response = $response;
    $this->_helper = $helper;
}

    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        if(strtolower($identifier) === $this->_helper->getUrlKey() || strtolower($identifier) === $this->_helper->getUrlKey()."/"){
            $request->setModuleName('magetasks')->setControllerName('task')->setActionName('index');
            $request->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, $identifier . "/");
            return $this->actionFactory->create(
                'Magento\Framework\App\Action\Forward',
                ['request' => $request]
            );
        }
    }
}