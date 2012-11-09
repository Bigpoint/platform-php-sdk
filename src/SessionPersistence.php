<?php

namespace Bigpoint;

class SessionPersistence implements PersistenceInterface
{
    /**
     * @var SessionAdapter
     */
    private $sessionAdapter;

    /**
     * @param SessionAdapter $sessionAdapter
     */
    public function __construct(
        SessionAdapter $sessionAdapter
    ) {
        $this->sessionAdapter = $sessionAdapter;

        $this->initSession();
    }

    /**
     * Start new or resume existing session.
     */
    private function initSession()
    {
        $sessionId = $this->sessionAdapter->id();

        if (true === empty($sessionId)) {
            $this->sessionAdapter->start();
        }
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
