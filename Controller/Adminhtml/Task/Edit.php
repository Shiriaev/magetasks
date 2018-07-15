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

namespace PShir\MageTasks\Controller\Adminhtml\Task;

class Edit extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;
    protected $_helper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \PShir\MageTasks\Helper\Data $helper
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_helper = $helper;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('PShir_MageTasks::magetasks_index');

        $id = (int)$this->getRequest()->getParam('id');
        $taskName = $this->_helper->getTaskInfoById('id', $id,'name');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit task "'.$taskName.'"'));

        return $resultPage;
    }

    /*
     * Check permission via ACL resource
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('PShir_MageTasks::edit');
    }
}