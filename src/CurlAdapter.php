<?php

namespace Bigpoint;

class CurlAdapter
{
    /**
     * Initialize a cURL session.
     *
     * @param string $url
     *
     * @return resource|bool Returns a cURL handle on success, FALSE on errors.
     */
    public function init($url = null)
    {
        return curl_init($url);
    }

    /**
     * Returns the value of a CURLOPT_XXX.
     *
     * @param string $name The name of the constant without prefix CURLOPT_.
     *
     * @return int
     */
    public function getConstant($name)
    {
        return constant('CURLOPT_' . $name);
    }

    /**
     * Set an option for a cURL transfer.
     *
     * @param resource $ch A cURL handle.
     * @param int $option The CURLOPT_XXX option to set.
     * @param mixed $value The value to be set on option.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function setOption($ch, $option, $value)
    {
        return curl_setopt($ch, $option, $value);
    }

    /**
     * Perform a cURL session.
     *
     * @param resource $ch A cURL handle.
     *
     * @return mixed
     */
    public function exec($ch)
    {
        return curl_exec($ch);
    }

    /**
     * Close a cURL session.
     *
     * @param resource $ch A cURL handle.
     *
     * @return void
     */
    public function close($ch)
    {
        return curl_close($ch);
    }
}
