<?php
namespace JsonApiParser\Collections;

use Iterator;
use JsonApiParser\Exceptions\ParserException;

class Errors implements Iterator
{
    /**
     * errors container
     *
     * @var array
     * @since 1.0.0
     */
    private $data;

    /**
     * Errors Constructor
     *
     * @param array $errors
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
     * @return ErrorItem
     */
    public function current(): ErrorItem
    {
        return new ErrorItem($this->data[$this->position]);
    }

    /**
     * interface key method
     *
     * @return integer
     */
    public function key(): int
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
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->data[$this->position]);
    }

    /**
     * Get a specific error item
     *
     * @param integer $i
     * @return ErrorItem
     * @since 1.0.0
     */
    public function get(int $i): ErrorItem
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
     * Get the first error item
     *
     * @return ErrorItem
     * @since 1.0.0
     */
    public function first(): ErrorItem
    {
        return $this->get(0);
    }

    /**
     * get the last error item
     *
     * @return ErrorItem
     * @since 1.0.0
     */
    public function last(): ErrorItem
    {
        return $this->get(count($this->data) - 1);
    }

    /**
     * get count of errors
     *
     * @return integer
     * @since 1.0.0
     */
    public function count(): int
    {
        return count($this->data);
    }

}
