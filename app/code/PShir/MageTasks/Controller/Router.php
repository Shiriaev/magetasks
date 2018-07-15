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

class Router implements \Magento\Framework\App\RouterInterface
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

    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\UrlInterface $url
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\ResponseInterface $response
     */
    public function __construct(
    \Magento\Framework\App\ActionFactory $actionFactory,
    \Magento\Framework\Event\ManagerInterface $eventManager,
    \Magento\Framework\UrlInterface $url,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \Magento\Framework\App\ResponseInterface $response,
    \PShir\MageTasks\Helper\Data $helper
) {
    $this->actionFactory = $actionFactory;
    $this->_eventManager = $eventManager;
    $this->_url = $url;
    $this->_storeManager = $storeManager;
    $this->_response = $response;
    $this->_helper = $helper;
}
    /**
     * Validate and Match Task Page and modify request
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        if(strtolower($identifier) === $this->_helper->getUrlKey() || strtolower($identifier) === $this->_helper->getUrlKey()."/"){
            $request->setModuleName('magetasks')->setControllerName('task')->setActionName('index');
            $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $identifier . "/");
            return $this->actionFactory->create(
                'Magento\Framework\App\Action\Forward',
                ['request' => $request]
            );
        }
    }
}