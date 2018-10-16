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

namespace PShir\MageTasks\Model;

use PShir\MageTasks\Api\TaskInterface;
use Magento\Framework\Model\Context;
use PShir\MageTasks\Helper\Data as Helper;

class TaskApi implements TaskInterface
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * TaskApi constructor.
     * @param Context $context
     * @param Helper $helper
     */
    public function __construct(
        Context $context,
        Helper $helper
    )
    {
        $this->helper = $helper;
    }

    public function create($name)
    {
        return $this->helper->createTask($name);
    }

    public function delete($id)
    {
        try {
            return $this->helper->deleteTask($id);
        }
        catch (\Exception $e) {
            return $e;
        }
    }

    public function getall()
    {
        $taskCollection  = $this->helper->getAllTasks();
        $response = [];
        foreach ($taskCollection as $task) {
            $id = $task->getId();
            $name = $task->getName();
            $desc = $task->getDescription();
            $response[$id] = [
                "id" => $id,
                "name" => $name,
                "description" => $desc
            ];
        }
        return $response;
    }

    public function gettask($id)
    {
        $task = $this->helper->getTask($id);
        return [
            $task->getId() => [
                "id" => $task->getId(),
                "name" => $task->getName(),
                "description" => $task->getDescription()
            ]
        ];
    }

}