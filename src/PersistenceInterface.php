<?php

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
