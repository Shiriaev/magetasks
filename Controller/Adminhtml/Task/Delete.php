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

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use PShir\MageTasks\Controller\Adminhtml\Task\PostDataProcessor;

class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'PShir_MageTasks::delete';
    protected $model;

    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        \PShir\MageTasks\Model\Task $model
    ) {
        parent::__construct($context);
        $this->model = $model;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if($id = $this->getRequest()->getParam("id")){
            $object = $this->model->load($id);
            if($object){
                $object->delete();
                $this->messageManager->addSuccess(__('Task deleted.'));
            }
            else{
                $this->messageManager->addError(__('Invalid task info ID.'));
            }
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('PShir_MageTasks::edit');
    }

}
