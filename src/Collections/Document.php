<?php
namespace JsonApiParser\Collections;

use JsonApiParser\JsonApiParserException;

class Document implements \Iterator
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->position = 0;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return new DocumentItem($this->data[$this->position]);
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->data[$this->position]);
    }

    public function get(int $i)
    {
        $tmp = $this->position;
        $this->position = $i;
        if ($this->valid()) {
            return $this->current();
        }
        $this->position = $tmp;
        throw new JsonApiParserException("{$i} index is undefined");
    }

    public function first()
    {
        return $this->get(0);
    }
    public function last()
    {
        return $this->get(count($this->data) - 1);
    }
}
