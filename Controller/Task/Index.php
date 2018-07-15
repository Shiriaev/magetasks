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

namespace PShir\MageTasks\Controller\Task;

use Magento\Framework\App\ResponseInterface;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    )
    {
        parent::__construct($context);
        $this->_pageFactory = $pageFactory;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {

        $result = $this->_pageFactory->create();
        $result->getConfig()->getTitle()->set(__('Tasks'));
        return $result;

    }
}