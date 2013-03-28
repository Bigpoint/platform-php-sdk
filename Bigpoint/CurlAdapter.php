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

class CurlAdapter
{
    /**
     * Initialize a cURL session.
     *
     * @codeCoverageIgnore
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
    public function getOptConstant($name)
    {
        return constant('CURLOPT_' . $name);
    }

    /**
     * Returns the value of a CURLINFO_XXX.
     *
     * @param string $name The name of the constant without prefix CURLINFO_.
     *
     * @return int
     */
    public function getInfoConstant($name)
    {
        return constant('CURLINFO_' . $name);
    }

    /**
     * Set an option for a cURL transfer.
     *
     * @codeCoverageIgnore
     *
     * @param resource $ch A cURL handle.
     * @param int $option The CURLOPT_XXX option to set.
     * @param mixed $value The value to be set on option.
     *
     * @return bool Return TRUE on success or FALSE on failure.
     */
    public function setOption($ch, $option, $value)
    {
        return curl_setopt($ch, $option, $value);
    }

    /**
     * Perform a cURL session.
     *
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
     *
     * @param resource $ch A cURL handle.
     *
     * @return void
     */
    public function close($ch)
    {
        return curl_close($ch);
    }

    /**
     * Get information regarding a specific transfer.
     *
     * @codeCoverageIgnore
     *
     * @param resource $ch A cURL handle.
     * @param int One of the CURLINFO_XXX constant.
     */
    public function getInfo($ch, $opt = 0)
    {
        return curl_getinfo($ch, $opt);
    }

    /**
     * Return a string containing the last error.
     *
     * @codeCoverageIgnore
     *
     * @param resource $ch A cURL handle.
     *
     * @return string Return the error message or ''.
     */
    public function getError($ch)
    {
        return curl_error($ch);
    }

    /**
     * Return the last error number.
     *
     * @codeCoverageIgnore
     *
     * @param resource $ch A cURL handle.
     *
     * @return int Return the error number or 0.
     */
    public function getErrno($ch)
    {
        return curl_errno($ch);
    }
}
