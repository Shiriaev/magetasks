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

namespace PShir\MageTasks\Block\Adminhtml\Task\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use PShir\MageTasks\Model\Task as TaskModel;

class DeleteButton implements ButtonProviderInterface
{

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var \PShir\MageTasks\Model\Task
     */
    protected $taskModel;

    /**
     * DeleteButton constructor.
     * @param Context $context
     * @param \PShir\MageTasks\Model\Task $taskModel
     */
    public function __construct(
        Context $context,
        TaskModel $taskModel
    ) {
        $this->context = $context;
        $this->taskModel = $taskModel;
    }

    /**
     * @return mixed|null
     */
    public function getPageId()
    {
        try {
            return $this->taskModel->load(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Delete'),
            'on_click' => sprintf("if (confirm(\"Are you sure to delete this task info?\") == true) { location.href = '%s'; }", $this->getUrl('magetasks/task/delete', ['id' => $this->context->getRequest()->getParam('id')])),
            'class' => 'delete',
            'sort_order' => 11
        ];
    }

}