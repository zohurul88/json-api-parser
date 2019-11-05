<?php

namespace JsonApiParser\Tests;

use JsonApiParser\Collections\Links;
use PHPUnit\Framework\TestCase;
use JsonApiParser\Parser;

class DocumentItemTest extends TestCase
{

    private $document;

    public function __construct()
    {
        parent::__construct();
        $parser = new Parser(\file_get_contents(__DIR__ . '/json/json-api.json'));
        $this->document = $parser->data();
    }

    public function testIdType()
    {
        $item = $this->document->get(0);
        $this->assertEquals(1, $item->id());
        $this->assertEquals("articles", $item->type());
    }

    public function testAttributesContain()
    {
        $item = $this->document->get(0);
        $this->assertTrue($item->contain("attributes"));
        $this->assertFalse($item->contain("attribute"));
        $this->assertTrue($item->contain("attributes", "title"));

        $this->assertInstanceOf(\stdClass::class, $item->attribute());

        $this->assertEquals("JSON:API paints my bikeshed!", $item->attribute()->title);
    }

    public function testLinks()
    {
        $item = $this->document->get(0);

        $this->assertInstanceOf(Links::class, $item->links());
        $this->assertEquals("http://example.com/articles/1", $item->links()->self());
        $this->assertEquals("http://example.com/articles/1", $item->links()->self);
    }

    public function testRelationship()
    {
        $item = $this->document->get(0);
        $this->assertInstanceOf(Parser::class, $item->relationships("author"));
    }

    public function testKeys()
    {
        $item = $this->document->get(0);
        $this->assertTrue($this->arraysAreSimilar(['type', 'id', 'attributes', 'relationships', 'links'], $item->getKeys()));
        $this->assertFalse($this->arraysAreSimilar(['type', 'id', 'attribute', 'relationships', 'links'], $item->getKeys()));
        $this->assertTrue($this->arraysAreSimilar(['author', 'comments'], $item->getKeys('relationships')));
    }


    public function arraysAreSimilar($a, $b)
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
