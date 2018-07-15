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

use Magento\Framework\Model\AbstractModel;

class Task extends AbstractModel
{

    public function __construct( \Magento\Framework\Model\Context $context,
                                 \Magento\Framework\Registry $registry,
                                 array $data = [])
    {
        parent::__construct($context, $registry, null, null, $data);
    }

    protected function _construct()
    {
        $this->_init('PShir\MageTasks\Model\ResourceModel\Task');
    }

}