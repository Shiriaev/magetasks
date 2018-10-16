<?php

namespace PShir\MageTasks\Api;

interface TaskInterface
{
    /**
 * Create new example Task
 *
 * @api
 * @param string $name Task name.
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