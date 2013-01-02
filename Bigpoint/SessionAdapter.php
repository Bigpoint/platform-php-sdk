<?php

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
