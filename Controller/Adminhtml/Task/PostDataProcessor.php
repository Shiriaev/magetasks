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

use Magento\Framework\Stdlib\DateTime\Filter\Date as DateFilter;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Model\Layout\Update\ValidatorFactory;
use PShir\MageTasks\Helper\Data as Helper;

class PostDataProcessor
{
    /**
     * @var DateFilter
     */
    protected $dateFilter;

    /**
     * @var ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * PostDataProcessor constructor.
     * @param DateFilter $dateFilter
     * @param ManagerInterface $messageManager
     * @param ValidatorFactory $validatorFactory
     * @param Helper $helper
     */
    public function __construct(
        DateFilter $dateFilter,
        ManagerInterface $messageManager,
        ValidatorFactory $validatorFactory,
        Helper $helper
    ) {
        $this->dateFilter = $dateFilter;
        $this->messageManager = $messageManager;
        $this->validatorFactory = $validatorFactory;
        $this->helper = $helper;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function filter($data)
    {
        $filterRules = [];

        foreach (['custom_theme_from', 'custom_theme_to'] as $dateField) {
            if (!empty($data[$dateField])) {
                $filterRules[$dateField] = $this->dateFilter;
            }
        }

        return (new \Zend_Filter_Input($filterRules, [], $data))->getUnescaped();
    }

    /**
     * @param $model
     * @return bool
     */
    public function validate($model)
    {
        $errorNo = true;
        if(!$model->getName()){
            $this->messageManager->addError(__("The field 'Title' can't be empty!"));
            $errorNo = false;
        }
        return $errorNo;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('PShir_MageTasks::edit');
    }

}