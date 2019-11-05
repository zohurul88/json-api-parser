<?php

namespace JsonApiParser\Collections;

use JsonApiParser\Exceptions\ParserException;

class Links
{
    /**
     * The links object
     *
     * @var \stdClass
     * @since 1.0.0
     */
    private $links;

    /**
     * The links constructor 
     *
     * @param \stdClass $links
     */
    public function __construct(\stdClass $links)
    {
        $this->links = $links;
    }

    /**
     * php get magic method 
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->links->{$name} ?? null;
    }

    /**
     * php call magic method
     *
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call($name, $arguments)
    {
        return $this->get($name);
    }

    /**
     * get by any known name
     *
     * @param string $name
     * @return string
     * @since 1.0.0
     */
    public function get(string $name): string
    {
        if (isset($this->links->{$name}))
            return $this->links->{$name};
        else throw new ParserException("Undefined index {$name}");
    }

    /**
     * Get all links
     *
     * @return \stdClass|null
     * @since 1.0.0
     */
    public function all(): ?\stdClass
    {
        return $this->links;
    }
}
