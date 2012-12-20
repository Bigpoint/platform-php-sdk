<?php

namespace Bigpoint;

class Header implements \Countable
{
    /**
     * @var array
     */
    private $fields;

    /**
     * Split a header field into field-name and field-value.
     *
     * @param string $field
     *
     * @return array|false
     */
    public function splitField($field)
    {
        $pattern = '/(?P<name>[\x21\x22-\x27\x2A\x2B\x2D\x2E\x30-\x39\x41-\x5A\x5D-\x7A\x7C\x7E]+)(?:\x3A{1}\x20?)(?P<value>.*)/';
        if (1 !== preg_match($pattern, $field, $matches)) {
            return false;
        }
        return array(
                'name' => $matches['name'],
                'value' => $matches['value'],
        );
    }

    /**
     * Set a header field.
     *
     * @param string $name
     * @param string $value
     */
    public function set($name, $value)
    {
        $this->fields[$name] = $value;
    }

    /**
     * Get all header fields.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->fields;
    }

    /**
     * Get a header field.
     *
     * @param string $name
     * @param mixed $default
     *
     * @return string
     */
    public function get($name, $default = null)
    {
        return isset($this->fields[$name]) ? $this->fields[$name] : $default;
    }

    /**
     * Return the number of headers.
     *
     * @return int The number of fields.
     */
    public function count()
    {
        return count($this->fields);
    }
}
