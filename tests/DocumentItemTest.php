<?php

namespace JsonApiParser\Tests;

use JsonApiParser\Collections\DocumentItem;
use JsonApiParser\Exceptions\ParserException;
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

    public function testAttributes()
    { 
        
    }
}
