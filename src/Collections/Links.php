<?php
namespace JsonApiParser\Collections;

class Links
{
    private $links;

    public function __construct(array $links)
    {
        $this->links = $links;
    }

    public function __get($name)
    {
        return isset($this->links->{$name}) ?? null;
    }

    public function __call($name, $arguments)
    {
        return $this->get($name);
    }

    public function get($name)
    {
        return $this->{$name};
    }

    public function all()
    {
        return $this->links;
    }

}
