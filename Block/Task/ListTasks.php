<?php

/**
 * @package     PShir_MageTasks
 * @author      Pavel Shiriaev - pavel@shiriaev.com
 * @copyright   Pavel Shiriaev - https://shiriaev.com
 * @license     https://opensource.org/licenses/AFL-3.0  Academic Free License 3.0 | Open Source Initiative
 */

namespace PShir\MageTasks\Block\Task;

use Magento\Framework\View\Element\Template;
use PShir\MageTasks\Helper\Data as Helper;

class ListTasks extends Template
{
    /**
     * @var \PShir\MageTasks\Helper\Data
     */

    protected $_helper;

    /**
     * ListTasks constructor.
     * @param Template\Context $context
     * @param \PShir\MageTasks\Helper\Data $helper
     * @param array $data
     */

    public function __construct(
        Template\Context $context,
        Helper $helper, array $data = [])
    {
        parent::__construct($context, $data);
        $this->_helper = $helper;
    }

    public function getAllTasks(){
        return $this->_helper->getAllTasks();
    }

    public function getStoreName(){
        return $this->_helper->getStoreName();
    }

}