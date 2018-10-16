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
use PShir\MageTasks\Helper\Data as Helper;
use PShir\MageTasks\Model\ResourceModel\TaskFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File as IoFile;

class Save extends Action
{

    const ADMIN_RESOURCE = 'PShir_MageTasks::edit';

    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var TaskFactory
     */
    protected $factory;

    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @var IoFile
     */
    protected $ioFile;

    /**
     * @var
     */
    protected $_attributeHelper;

    /**
     * @var
     */
    protected $uploadHelper;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param Helper $data
     * @param TaskFactory $factory
     * @param DirectoryList $directory_list
     * @param IoFile $ioFile
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        Helper $data,
        TaskFactory $factory,
        DirectoryList $directory_list,
        IoFile $ioFile
    )
    {
        parent::__construct($context);
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->helper = $data;
        $this->factory = $factory;
        $this->directoryList = $directory_list;
        $this->ioFile = $ioFile;
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $data = $this->dataProcessor->filter($data);
            if (empty($data['id'])) {
                $data['id'] = null;
            }
            $model = $this->factory->create();
            $id = $this->getRequest()->getParam('id');
            $edit = false;
            if ($id) {
                $edit = true;
                $model->load($id);
            }

            //Set Model Data
            if ($data['name'] != "")
                $model->setName($data['name']);
            if ($data['description']!= "")
                $model->setDescription($data['description']);

            if (!$this->dataProcessor->validate($model, $edit)) {
                if ($id)
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                else
                    return $resultRedirect->setPath('*/*/add', ['_current' => true]);
            }
            try {

                if ($model->save()) {
                    $this->messageManager->addSuccess(__('You saved the "' . $model->getName() . '" task.'));
                    $this->dataPersistor->clear('magetasks_task');
                    if ($this->getRequest()->getParam('back')) {
                        return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                    }
                } else {
                    $this->messageManager->addError(__('Was not possible to save the task info.'));
                    $this->dataPersistor->clear('magetasks_task');
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('An error occurred saving this task info.'));
            }
            $this->dataPersistor->set('magetasks_task', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('PShir_MageTasks::edit');
    }

}
