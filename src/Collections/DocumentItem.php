<?php

namespace JsonApiParser\Collections;

use JsonApiParser\Exceptions\ParserException;
use JsonApiParser\Parser;

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
     * @return \stdClass|null
     */
    public function attribute(): ?\stdClass
    {
        if ($this->contain("attributes")) return $this->item['attributes'];
        else throw new Exception("Attributes not included to this document");
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
    public function contain(string $identifier, ?string $name = null): bool
    {
        if (!is_null($identifier)) {
            return isset($this->item[$identifier]);
        }

        return isset($this->item[$identifier]->{$name});
    }

    public function relationships($name)
    {
        if (!$this->contain("relationships", $name)) {
            throw new ParserException("Relationship Not found.");
        }

        $relationship = $this->item['relationships']->{$name};
        return new Parser(json_encode($relationship));
    }
}
