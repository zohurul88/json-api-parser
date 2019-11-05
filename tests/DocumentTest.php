<?php
namespace JsonApiParser\Tests;

use JsonApiParser\Collections\Document;
use JsonApiParser\Collections\DocumentItem;
use JsonApiParser\JsonApi;
use JsonApiParser\JsonApiParserException;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{

    private $jsonapi;

    public function __construct()
    {
        parent::__construct();
        $this->jsonapi = new JsonApi(file_get_contents('/var/www/json-api-parser/json-api.json'));
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Document::class, $this->jsonapi->data());
    }

    public function testGetItem()
    {
        $item = $this->jsonapi->data()->get(0);
        $this->assertInstanceOf(DocumentItem::class, $item);

        $this->assertEquals(1, $item->id());

        $this->assertEquals("JSON:API paints my bikeshed!", $item->attribute('title'));

        $this->assertEquals("JSON:API paints my bikeshed!", $item->attribute()->title);

        $this->assertEquals("articles", $item->type());

        $this->assertTrue($this->arrays_are_similar(['type', 'id', 'attributes', 'relationships', 'links'], $item->getKeys()));
        $this->assertTrue($this->arrays_are_similar(['title'], $item->getKeys('attributes')));

        $this->assertEquals("http://example.com/articles/1", $item->links('self'));
        $this->assertEquals("http://example.com/articles/1", $item->links()->self);

    }

    public function testGetWrongException()
    {
        $this->expectException(JsonApiParserException::class);

        $this->jsonapi->data()->get(2);
    }
    public function testGetWrongItemKeysException()
    {

        $item = $this->jsonapi->data()->get(1);
        $this->expectException(JsonApiParserException::class);
        $item->getKeys("unknown");

    }

    public function testRelationShip()
    {
        $item = $this->jsonapi->data()->get(0);
        $this->assertInstanceOf(DocumentItem::class, $item);
        $rel = $item->relationships('author');
        $this->assertInstanceOf(JsonApi::class, $rel);

        $docItem = $rel->data();
        $this->assertInstanceOf(Document::class, $docItem);

        $docItem = $docItem->get(0);
        $this->assertInstanceOf(DocumentItem::class, $docItem);

        $this->assertEquals(9,$docItem->id());
        $this->assertEquals("people",$docItem->type());

    }

    public function arrays_are_similar($a, $b)
    {
        // if the indexes don't match, return immediately
        if (count(array_diff_assoc($a, $b))) {
            return false;
        }
        // we know that the indexes, but maybe not values, match.
        // compare the values between the two arrays
        foreach ($a as $k => $v) {
            if ($v !== $b[$k]) {
                return false;
            }
        }
        // we have identical indexes, and no unequal values
        return true;
    }

}
