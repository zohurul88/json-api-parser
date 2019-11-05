<?php

namespace JsonApiParser\Tests;

use JsonApiParser\Collections\Document;
use JsonApiParser\Collections\Errors;
use JsonApiParser\Collections\Links;
use JsonApiParser\Collections\Relations;
use JsonApiParser\Exceptions\ParserException;
use PHPUnit\Framework\TestCase;
use JsonApiParser\Parser;

class ParserTest extends TestCase
{

    private $parser;

    public function __construct()
    {
        parent::__construct();
        $this->parser = new Parser(\file_get_contents(__DIR__ . '/json/json-api.json'));
    }

    /**
     * test data method
     *
     * @return void
     */
    public function  testData()
    {
        $this->assertInstanceOf(Document::class, $this->parser->data());
    }

    /**
     * Parser errors 
     *
     * @return void
     */
    public function testErrors()
    {
        $parser = new Parser(\file_get_contents(__DIR__ . '/json/errors.json'));
        $this->assertInstanceOf(Errors::class, $parser->errors());
    }

    /**
     * parser links
     *
     * @return void
     */
    public function testLinks()
    {
        $this->assertInstanceOf(Links::class, $this->parser->links());
    }

    /**
     * json api included test
     *
     * @return void
     */
    public function testIncluded()
    {
        $this->assertInstanceOf(Relations::class, $this->parser->included());
    }

    /**
     * Invalid json exceptions
     *
     * @return void
     */
    public function testInvalidJsonException()
    {
        $this->expectException(ParserException::class);
        new Parser(\file_get_contents(__DIR__ . '/json/invalid-json.json'));
    }
    
    /**
     * json:api rules violation 
     *
     * @return void
     */
    public function testInvalidJsonApiException()
    {
        $this->expectException(ParserException::class);
        new Parser(\file_get_contents(__DIR__.'/json/json-api-error.json'));
    }
}
