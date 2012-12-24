<?php

namespace Bigpoint;

/**
 * @codeCoverageIgnore
 */
class SessionAdapter
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
}
