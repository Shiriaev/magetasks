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

class PostDataProcessor
{
    protected $dateFilter;

    protected $validatorFactory;

    protected $messageManager;

    protected $helper;

    public function __construct(
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\View\Model\Layout\Update\ValidatorFactory $validatorFactory,
        \PShir\MageTasks\Helper\Data $helper
    ) {
        $this->dateFilter = $dateFilter;
        $this->messageManager = $messageManager;
        $this->validatorFactory = $validatorFactory;
        $this->helper = $helper;
    }

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