<?php

namespace JsonApiParser\Collections;

use JsonApiParser\JsonApi;
use JsonApiParser\ParserException;

class DocumentItem
{
    private $item;

    private $index = null;

    public function __construct(\stdClass $item, int $index)
    {
        $this->item = (array) $item;
        $this->index = $index;
    }

    /**
     * current index
     *
     * @return integer|null
     * @since 1.0.0
     */
    public function index(): ?int
    {
        return $this->index;
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
    public function links()
    {
        if (isset($this->item['links'])) {
            return new Links($this->item['links']);
        }
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

    /**
     * get item keys
     *
     * @param string|null $identifier
     * @return array
     */
    public function getKeys(?string $identifier = null): array
    {
        if (is_null($identifier)) {
            return array_keys($this->item);
        }
        if (!isset($this->item[$identifier])) {
            throw new ParserException("{$identifier} is an invalid index");
        }
        $item = (array) $this->item[$identifier];

        return array_keys($item);
    }

    /**
     * if any key exists
     *
     * @param string $name
     * @param string|null $identifier
     * @return boolean
     */
    public function contain(string $name, ?string $identifier = null): bool
    {
        if (!is_null($identifier)) {
            return isset($this->item[$identifier]->{$name});
        }

        return isset($this->item['attribute']->{$name});
    }

    public function relationships($name)
    {
        if (!$this->contain($name, "relationships")) {
            throw new ParserException("Relationship Not found.");
        }

        $relationship = $this->item['relationships']->{$name};
        return new JsonApi(json_encode($relationship));
    }
}
