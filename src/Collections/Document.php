<?php

namespace JsonApiParser\Collections;

use Iterator;
use JsonApiParser\Exceptions\ParserException;

class Document implements Iterator
{
    /**
     * data container
     *
     * @var array
     * @since 1.0.0
     */
    private $data = [];

    /**
     * Document constructor
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->position = 0;
    }

    /**
     * interface rewind method
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * interface current method
     *
     * @return void
     */
    public function current()
    {
        return new DocumentItem($this->data[$this->position], $this->position);
    }

    /**
     * interface key method
     *
     * @return void
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * interface next method
     *
     * @return void
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * interface valid method
     *
     * @return void
     */
    public function valid()
    {
        return isset($this->data[$this->position]);
    }

    /**
     * Get a specific element
     *
     * @param integer $i
     * @return DocumentItem|null
     * @since 1.0.0
     */
    public function get(int $i): ?DocumentItem
    {
        $tmp = $this->position;
        $this->position = $i;
        if ($this->valid()) {
            return $this->current();
        }
        $this->position = $tmp;
        throw new ParserException("{$i} index is undefined");
    }

    /**
     * First document from the list
     *
     * @return DocumentItem
     * @since 1.0.0
     */
    public function first(): DocumentItem
    {
        return $this->get(0);
    }

    /**
     * Last document from the list
     *
     * @return DocumentItem
     * @since 1.0.0
     */
    public function last(): DocumentItem
    {
        return $this->get($this->count() - 1);
    }

    /**
     * count of item
     *
     * @return integer
     * @since 1.0.0
     */
    public function count(): int
    {
        return count($this->data);
    }
}
