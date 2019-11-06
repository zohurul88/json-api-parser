<?php

namespace JsonApiParser\Tests;

use JsonApiParser\Collections\Document;
use JsonApiParser\Collections\Links;
use JsonApiParser\Parser;
use PHPUnit\Framework\TestCase;

class DocumentItemTest extends TestCase
{

    /**
     * the document container
     *
     * @var Document
     */
    private $document;

    public function __construct()
    {
        parent::__construct();
        $parser = new Parser(\file_get_contents(__DIR__ . '/json/json-api.json'));
        $this->document = $parser->data();
    }

    /**
     * Test element id and type
     *
     * @return void
     */
    public function testIdType()
    {
        $item = $this->document->get(0);
        $this->assertEquals(1, $item->id());
        $this->assertEquals("articles", $item->type());
    }

    /**
     * Test attributes and contain
     *
     * @return void
     */
    public function testAttributesContain()
    {
        $item = $this->document->get(0);
        $this->assertTrue($item->contain("attributes"));
        $this->assertFalse($item->contain("attribute"));
        $this->assertTrue($item->contain("attributes", "title"));

        $this->assertInstanceOf(\stdClass::class, $item->attribute());

        $this->assertEquals("JSON:API paints my bikeshed!", $item->attribute()->title);
    }

    /**
     * Test the links
     *
     * @return void
     */
    public function testLinks()
    {
        $item = $this->document->get(0);

        $this->assertInstanceOf(Links::class, $item->links());
        $this->assertEquals("http://example.com/articles/1", $item->links()->self());
        $this->assertEquals("http://example.com/articles/1", $item->links()->self);
    }

    /**
     * Testing the relationships
     *
     * @return void
     */
    public function testRelationship()
    {
        $item = $this->document->get(0);
        $this->assertInstanceOf(Parser::class, $item->relationships("author"));
    }

    /**
     * test get keys
     *
     * @return void
     */
    public function testKeys()
    {
        $item = $this->document->get(0);
        $this->assertTrue($this->arraysAreSimilar(['type', 'id', 'attributes', 'relationships', 'links'], $item->getKeys()));
        $this->assertFalse($this->arraysAreSimilar(['type', 'id', 'attribute', 'relationships', 'links'], $item->getKeys()));
        $this->assertTrue($this->arraysAreSimilar(['author', 'comments'], $item->getKeys('relationships')));
    }

    /**
     * testing if the two array are same
     *
     * @param array $a
     * @param array $b
     * @return void
     */
    public function arraysAreSimilar(array $a, array $b)
    {
        if (count(array_diff_assoc($a, $b))) {
            return false;
        }

        foreach ($a as $k => $v) {
            if ($v !== $b[$k]) {
                return false;
            }
        }

        return true;
    }
}
