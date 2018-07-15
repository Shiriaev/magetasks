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

namespace PShir\MageTasks\Model\ResourceModel\Task;

use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \PShir\MageTasks\Model\Task $task,
        DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $task->getCollection();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->storeManager = $storeManager;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $task) {

            $taskData = $task->getData();

            $this->loadedData[$task->getId()] = $taskData;
        }

        $data = $this->dataPersistor->get('pshir_tasks');
        if (!empty($data)) {
            $task = $this->collection->getNewEmptyItem();
            $taskData =$task->setData($data);
            $this->loadedData[$task->getId()] = $taskData;
            $this->dataPersistor->clear('pshir_tasks');
        }

        return $this->loadedData;
    }
}
