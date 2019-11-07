<?php
namespace JsonApiParser\Collections;

use JsonApiParser\Exceptions\ParserException;

class Included
{
    /**
     * relationships included items
     *
     * @var array
     */
    private static $items = [];

    /**
     * shorted items
     *
     * @var array
     */
    private static $sortItems = [];

    /**
     * shorted flag
     *
     * @var boolean
     */
    private static $isSorted = false;

    public static function set(array $items, bool $sortHere = true)
    {
        self::$items = $items;
        $sortHere ? self::sortItems() : null;
    }

    public static function setSorted(array $sortItems)
    {
        if (self::$isSorted) {
            return;
        }
        self::$sortItems = $sortItems;
        self::$isSorted = true;
    }

    /**
     * sort item prepare
     *
     * @return void
     */
    private static function sortItems()
    {
        foreach (self::$items as $i => $item) {
            self::$sortItems[$item->type][$item->id] = $i;
        }
    }

    /**
     * check if already sorted
     *
     * @return boolean
     */
    public static function isSorted(): bool
    {
        return self::$isSorted;
    }

    /**
     * get included relation
     *
     * @param string $type
     * @param integer $id
     * @return DocumentItem|null
     */
    public static function get(string $type, $id = []): ?Document
    {
        if (isset(self::$sortItems[$type])) {
            if (empty($id)) {
                $sliceItems = array_intersect_key(self::$items, array_flip(self::$sortItems[$type]));
                return new Document($sliceItems);
            } else if (is_array($id)) {
                $sliceItems = array_intersect_key(self::$items, array_flip((array) $id));
                return new Document($sliceItems);
            } else if (isset(self::$items[self::$sortItems[$type][$id]])) {
                return new Document([self::$items[self::$sortItems[$type][$id]]]);
            }
        }
        throw new ParserException("undefined index {$type} in included item." . print_r(self::$items, true));

    }

    public static function getShortedItem()
    {
        return self::$sortItems;
    }

}
