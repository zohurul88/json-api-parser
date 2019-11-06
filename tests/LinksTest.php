<?php

namespace JsonApiParser\Tests;

use JsonApiParser\Collections\Links;
use JsonApiParser\Exceptions\ParserException;
use PHPUnit\Framework\TestCase;
use JsonApiParser\Parser;

class LinksTest extends TestCase
{
    /**
     * links container
     *
     * @var Links
     */
    private $links;

    public function __construct()
    {
        parent::__construct();
        $parser = new Parser(\file_get_contents(__DIR__ . '/json/json-api.json'));
        $this->links = $parser->links();
    }

    /**
     * instance of
     *
     * @return void
     */
    public function testInstanceType()
    {
        $this->assertInstanceOf(Links::class, $this->links);
    }

    /**
     * test single item
     *
     * @return void
     */
    public function testItem()
    {
        $this->assertEquals("http://example.com/articles", $this->links->self);
        $this->assertEquals(null, $this->links->related);
    }  

    /**
     * all items
     *
     * @return void
     */
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

    /**
     * test undefined by method
     *
     * @return void
     */
    public function testUndefinedObject()
    {
        $this->expectException(ParserException::class);
        $this->links->related();
    }
}
