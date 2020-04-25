<?php
/*
 * Copyright (c) 2015, 2020 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\v0\Controller;

interface CrudApiController {
    
    /**
     * Creates a new record into the Database.
     *
     * @param object $object object to be created
     * @param array  $params associative array with other required options, null
     *                       by default
     *
     * @return mixed
     */
    public function create($object, $params = null);
    
    /**
     * Returns the object fetch from the Database with the specified id. If the
     * "id" param is not set, then returns an array of all of the records.
     *
     * @param int $id id for item to read
     *
     * @return mixed
     */
    public function read($id = -1);
    
    /**
     * @param int    $id     id for the item to be updated
     * @param object $object object containing the updated values
     * @param array  $params associative array with other required options, null
     *                       by default
     *
     * @return mixed
     */
    public function update($id, $object, $params = null);
    
    /**
     * @param int $id Deletes the record from the Database with the specified id.
     *
     * @return mixed
     */
    public function delete($id);
    
}
