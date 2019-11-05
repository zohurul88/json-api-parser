<?php

namespace JsonApiParser\Tests;

use JsonApiParser\Collections\Links;
use JsonApiParser\Exceptions\ParserException;
use PHPUnit\Framework\TestCase;
use JsonApiParser\Parser;

class LinksTest extends TestCase
{

    private $links;

    public function __construct()
    {
        parent::__construct();
        $parser = new Parser(\file_get_contents(__DIR__ . '/json/json-api.json'));
        $this->links = $parser->links();
    }

    public function testInstanceType()
    {
        $this->assertInstanceOf(Links::class, $this->links);
    }

    public function testItem()
    {
        $this->assertEquals("http://example.com/articles", $this->links->self);
        $this->assertEquals(null, $this->links->related);
    }

    public function testAllLinks()
    {
        $all = $this->links->all();
        $test = json_decode('{
            "self": "http://example.com/articles",
            "next": "http://example.com/articles?page[offset]=2",
            "last": "http://example.com/articles?page[offset]=10"
        }');
        $this->assertInstanceOf(\stdClass::class, $all);
        $this->assertEquals($test, $all);
    }

    public function testUndefinedObject()
    {
        $this->expectException(ParserException::class);
        $this->links->related();
    }
}
