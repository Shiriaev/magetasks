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

namespace PShir\MageTasks\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $_storeManager;
    protected $categoryRepository;
    protected $_layerResolver;
    protected $eavConfig;
    protected $optionSettingsModel;
    protected $productModel;
    protected $taskModel;
    protected $factory;
    protected $tasksIds = array();

    const TASKS_CONFIGPATH = "tasks/settings/";

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Catalog\Model\Product $productModel,
        \PShir\MageTasks\Model\Task $taskModel,
        \PShir\MageTasks\Model\ResourceModel\TaskFactory $factory
    )
    {
        parent::__construct(
            $context
        );
        $this->_storeManager = $storeManager;
        $this->categoryRepository = $categoryRepository;
        $this->_layerResolver = $layerResolver;
        $this->eavConfig = $eavConfig;
        $this->productModel = $productModel;
        $this->taskModel = $taskModel;
        $this->factory = $factory;
    }

    public function getTaskInfoById($filter,$filterValue,$attributeReturn){
        try{
            return $this->taskModel->getCollection()->addFieldToFilter($filter,$filterValue)->addFieldToSelect($attributeReturn)->getFirstItem()->getData($attributeReturn);
        }
        catch (\Exception $ex){

        }
        return null;
    }

    public function getUrlKey(){
        $path = $this::TASKS_CONFIGPATH."url_key";
        return $this->scopeConfig->getValue($path,\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getStoreName()
    {
        return $this->scopeConfig->getValue(
            'general/store_information/name',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getAllTasks(){
        $ids = $this->taskModel->getCollection()
            ->getAllIds();
        $collection = $this->taskModel->getCollection()
            ->addFieldToFilter('id', array('in' => $ids));
        $this->tasksIds = array_merge($this->tasksIds, $collection->getAllIds());
        return $collection;
    }

    public function createTask($name){

        $data['name'] = $name;
        $data['description'] = '';
        $data['id'] = null;

        $model = $this->factory->create();

        $edit = false;

        //Set Model Data
        if ($data['name'] != "")
            $model->setName($data['name']);
        if ($data['description']!= "")
            $model->setDescription($data['description']);
        $id = $model->getId();
        $model->save();

        return true;
    }

    public function deleteTask($id){

        $object = $this->taskModel->load($id);
        if($object){
            $object->delete();
            return true;
        } else {
            return false;
        }
    }

    public function getTask($id){

        try{
            return $this->taskModel->getCollection()
                ->addFieldToSelect(['*'])
                ->addFieldToFilter('id', $id)
                ->getFirstItem();
        }
        catch (\Exception $ex){
            return $ex;
        }
        return null;

    }
}