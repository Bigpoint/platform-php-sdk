<?php

namespace Bigpoint;

class CookiePersistence implements PersistenceInterface
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @param Environment $environment
     */
    public function __construct(
        Environment $environment
    ) {
        $this->environment = $environment;
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
