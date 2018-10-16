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

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Eav\Model\Config;
use Magento\Catalog\Model\Product as ProductModel;
use Magento\Store\Model\ScopeInterface;
use PShir\MageTasks\Model\Task as TaskModel;
use PShir\MageTasks\Model\ResourceModel\TaskFactory;

class Data extends AbstractHelper
{
    const TASKS_CONFIGPATH = "tasks/settings/";

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var Resolver
     */
    protected $_layerResolver;

    /**
     * @var Config
     */
    protected $eavConfig;

    /**
     * @var ProductModel
     */
    protected $productModel;

    /**
     * @var TaskModel
     */
    protected $taskModel;

    /**
     * @var TaskFactory
     */
    protected $factory;

    /**
     * @var array
     */
    protected $tasksIds = array();

    /**
     * Data constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param CategoryRepositoryInterface $categoryRepository
     * @param Resolver $layerResolver
     * @param Config $eavConfig
     * @param ProductModel $productModel
     * @param TaskModel $taskModel
     * @param TaskFactory $factory
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        CategoryRepositoryInterface $categoryRepository,
        Resolver $layerResolver,
        Config $eavConfig,
        ProductModel $productModel,
        TaskModel $taskModel,
        TaskFactory $factory
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

    /**
     * @param $filter
     * @param $filterValue
     * @param $attributeReturn
     * @return mixed|null
     */
    public function getTaskInfoById($filter, $filterValue, $attributeReturn){
        try{
            return $this->taskModel->getCollection()
                ->addFieldToFilter($filter,$filterValue)
                ->addFieldToSelect($attributeReturn)
                ->getFirstItem()
                ->getData($attributeReturn);
        }
        catch (\Exception $ex){
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function getUrlKey(){
        $path = $this::TASKS_CONFIGPATH."url_key";
        return $this->scopeConfig->getValue($path,ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getStoreName()
    {
        return $this->scopeConfig->getValue(
            'general/store_information/name',
            ScopeInterface::SCOPE_STORE
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

    /**
     * @param $name
     * @return bool
     */
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

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function deleteTask($id){

        $object = $this->taskModel->load($id);
        if($object){
            $object->delete();
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return \Exception|\Magento\Framework\DataObject
     */
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
    }
}