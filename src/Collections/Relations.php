<?php
namespace JsonApiParser\Collections;

class Relations
{
    private $items = [];

    private $sortItems = [];

    public function __construct(array $included)
    {
        $this->items = $included;
        $this->shortItems();
    }

    public function shortItems()
    {
        foreach ($this->items as $i => $item) {
            $this->sortItems[$item->type][$item->id] = $i;
        }
    }

    public function get($type, $id)
    {
        return $this->items[$this->sortItems[$type][$id]] ?? null;
    }
}
