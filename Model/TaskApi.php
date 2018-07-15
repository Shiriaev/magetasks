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

class TaskApi implements TaskInterface
{
    private $helper;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \PShir\MageTasks\Helper\Data $helper
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
        return $this->helper->deleteTask($id);
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