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
        // TODO Auto-generated method stub
    }

    /**
     * (non-PHPdoc)
     * @see PersistenceInterface::get()
     */
    public function get($key)
    {
        // TODO Auto-generated method stub
    }

    /**
     * (non-PHPdoc)
     * @see PersistenceInterface::delete()
     */
    public function delete($key)
    {
        // TODO Auto-generated method stub
    }

    /**
     * (non-PHPdoc)
     * @see PersistenceInterface::flush()
     */
    public function flush()
    {
        // TODO Auto-generated method stub
    }
}
