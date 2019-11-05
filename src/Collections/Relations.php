<?php
namespace JsonApiParser\Collections;

class Relations
{
    private $items = [];

    private $shortedItems = [];

    public function __construct(array $included)
    {
        $this->items = $included;
        $this->shortedItems();
    }

    public function shortItems()
    {
        foreach ($this->items as $i => $item) {
            $this->shortedItems[$item->type][$item->id] = $i;
        }
    }

    public function get($type, $id)
    {
        return $this->items[$this->shortedItems[$type][$id]] ?? null;
    }

}
