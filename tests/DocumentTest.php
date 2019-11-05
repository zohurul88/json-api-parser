<?php

namespace JsonApiParser\Tests;

use JsonApiParser\Collections\DocumentItem;
use JsonApiParser\Exceptions\ParserException;
use PHPUnit\Framework\TestCase;
use JsonApiParser\Parser;

class DocumentTest extends TestCase
{
    /**
     * document store
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
     * Document item test
     *
     * @return void
     */
    public function testInstanceOf()
    {
        $docItem = $this->document->get(0);
        $this->assertInstanceOf(DocumentItem::class, $docItem);
    }

    /**
     * test the first and last and count
     *
     * @return void
     */
    public function testFirstLastCount()
    {
        $docItem = $this->document->first();
        $this->assertEquals(0, $docItem->index());

        $docItem = $this->document->last();
        $this->assertEquals(1, $docItem->index());

        $this->assertEquals(2, $this->document->count());
    }

    /**
     * Test undefined index 
     *
     * @return void
     */
    public function testUndefinedException()
    {
        $this->expectException(ParserException::class);
        $this->document->get(2);
    }


    /**
     * iteration test
     *
     * @return void
     */
    public function testIteration()
    {
        $i = 0;
        foreach ($this->document as $index => $item) {
            $this->assertEquals($i, $index);
            $this->assertInstanceOf(DocumentItem::class, $item);
            $i++;
        }
        $this->assertEquals(2, $i);
    }
}
