<?php
/**
 * Copyright 2013 Bernd Hoffmann <info@gebeat.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Bigpoint;

interface PersistenceInterface
{
    /**
     * Store data in the storage.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * Retrieve an entry from the storage.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Delete a storage entry.
     *
     * @param string $key
     */
    public function delete($key);

    /**
     * Flush all storage entries.
     */
    public function flush();
}
