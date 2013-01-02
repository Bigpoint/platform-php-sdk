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
        $this->sessionAdapter->set($key, $value);
    }

    /**
     * (non-PHPdoc)
     * @see PersistenceInterface::get()
     */
    public function get($key, $default = null)
    {
        return $this->sessionAdapter->get($key, $default);
    }

    /**
     * (non-PHPdoc)
     * @see PersistenceInterface::delete()
     */
    public function delete($key)
    {
        $this->sessionAdapter->delete($key);
    }

    /**
     * (non-PHPdoc)
     * @see PersistenceInterface::flush()
     */
    public function flush()
    {
        $this->sessionAdapter->flush();
    }
}
