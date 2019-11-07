<?php
namespace JsonApiParser\Collections;

class Relations
{
    /**
     * relationships included items
     *
     * @var array
     */
    private $items = [];

    /**
     * shorted items
     *
     * @var array
     */
    private $sortItems = [];

    public function __construct(array $included)
    {
        $this->items = $included;
        $this->sortItems();
    }

    /**
     * sort item prepare
     *
     * @return void
     */
    private function sortItems()
    {
        foreach ($this->items as $i => $item) {
            $this->sortItems[$item->type][$item->id] = $i;
        }
    }

    /**
     * get included relation
     *
     * @param string $type
     * @param integer $id
     * @return DocumentItem|null
     */
    public function get(string $type, int $id): ?DocumentItem
    {
        return new DocumentItem($this->items[$this->sortItems[$type][$id]]) ?? null;
    }

    public function getSortedItem()
    {
        return $this->sortItems;
    }
}
