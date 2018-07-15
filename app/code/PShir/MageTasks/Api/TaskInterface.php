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

namespace PShir\MageTasks\Api;

interface TaskInterface
{
    /**
 * Create new example Task
 *
 * @api
 * @param string $name Task name.
 * @param string $desc Task description.
 * @return bool.
 */
    public function create($name);

    /**
     * Delete Task
     *
     * @api
     * @param int $id Task ID.
     * @return bool.
     */
    public function delete($id);

    /**
     * Get Task by ID
     *
     * @api
     * @param int $id Task ID.
     * @return Task or false.
     */
    public function gettask($id);

    /**
     * Get all Tasks
     *
     * @api
     * @return Tasks collection.
     */
    public function getall();
}