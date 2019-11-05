<?php
namespace JsonApiParser\Collections;

use Iterator;

class Errors implements Iterator
{
    private $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        $this->position = 0;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return new ErrorItem($this->errors[$this->position]);
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
        throw new ParserException("{$i} index is undefined");
    }

    public function first()
    {
        return $this->get(0);
    }

    public function last()
    {
        return $this->get(count($this->errors) - 1);
    }

}
