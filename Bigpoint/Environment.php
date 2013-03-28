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

class Environment
{
    /**
     * @var array
     */
    private $get;

    /**
     * @var array
     */
    private $server;

    /**
     * @param array $get
     * @param array $server
     */
    public function __construct(
        array $get,
        array $server
    ) {
        $this->get = $get;
        $this->server = $server;
    }

    /**
     * Get a GET parameter value.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return string
     */
    public function getGetParam($key, $default = null)
    {
        return isset($this->get[$key]) ? $this->get[$key] : $default;
    }

    /**
     * Get a SERVER parameter value.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return string
     */
    public function getServerParam($key, $default = null)
    {
        return isset($this->server[$key]) ? $this->server[$key] : $default;
    }

    /**
     * Get the request URI without the parameters.
     *
     * @return string
     */
    public function getDocumentURI()
    {
        $path = $this->getServerParam('REQUEST_URI');
        $path = parse_url($path, PHP_URL_PATH);
        return (true === empty($path)) ? '' : $path;
    }

    /**
     * Get the current URI.
     *
     * @return string
     */
    public function getCurrentURI()
    {
        // TODO will not work with IIS using ISAPI
        $protocol = $this->getServerParam('HTTPS', null);
        $protocol = (true === empty($protocol)) ? 'http://' : 'https://';

        $host = $this->getServerParam('HTTP_HOST');

        return $protocol . $host . $this->getDocumentURI();
    }
}
