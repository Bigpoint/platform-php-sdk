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

/**
 * @codeCoverageIgnore
 */
class SessionAdapter implements PersistenceInterface
{
    /**
     * @return string The session id for the current session or the empty string.
     */
    public function id()
    {
        return session_id();
    }

    /**
     * Start new or resume existing session.
     *
     * @return bool TRUE if a session was successfully started, otherwise FALSE.
     */
    public function start()
    {
        return session_start();
    }

    /**
     * (non-PHPdoc)
     * @see PersistenceInterface::set()
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * (non-PHPdoc)
     * @see PersistenceInterface::get()
     */
    public function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * (non-PHPdoc)
     * @see PersistenceInterface::delete()
     */
    public function delete($key)
    {
        if (true === isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * (non-PHPdoc)
     * @see PersistenceInterface::flush()
     */
    public function flush()
    {
        $_SESSION = array();
    }
}
