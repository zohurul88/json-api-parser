<?php
namespace JsonApiParser\Collections;

use JsonApiParser\JsonApiParserException;

class DocumentItem
{
    private $item;

    public function __construct(\stdClass $item)
    {
        $this->item = (array) $item;
    }

    /**
     * get the item id
     *
     * @return integer|null
     */
    public function id(): ?int
    {
        return $this->item['id'] ?? null;
    }

    /**
     * Get the item type
     *
     * @return string
     */
    public function type(): string
    {
        return $this->item['type'];
    }

    /**
     * get the item links
     *
     * @param string|null $name
     * @return \stdClass|string|null
     */
    public function links(?string $name = null)
    {
        if (is_null($name)) {
            return $this->item['links'] ?? null;
        }

        return $this->item['links']->{$name} ?? null;
    }

    /**
     * get the attributes
     *
     * @param string|null $name
     * @return string|null
     */
    public function attribute(?string $name = null)
    {
        if (is_null($name)) {
            return $this->item['attributes'];
        }
        return $this->item['attributes']->{$name} ?? null;
    }

    public function getKeys(?string $identifier = null): array
    {
        if (is_null($identifier)) {
            return array_keys($this->item);
        }
        if (!isset($this->item[$identifier])) {
            throw new JsonApiParserException("{$identifier} is an invalid index");
        }
        $item = (array) $this->item[$identifier];

        return array_keys($item);

    }

    public function contain(string $name, ?string $identifier = null): bool
    {
        if (!is_null($identifier)) {
            return isset($this->item[$identifier]->{$name});
        }

        return isset($this->item['attribute']->{$name});
    }

    public function getRelation($name)
    {
        if ($this->contain($name, "relationships")) {
            return null;
        }
    }

}
