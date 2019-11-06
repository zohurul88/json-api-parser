<?php

namespace JsonApiParser\Tests;

use JsonApiParser\Collections\ErrorItem;
use JsonApiParser\Collections\Errors;
use JsonApiParser\Exceptions\ParserException;
use JsonApiParser\Parser;
use PHPUnit\Framework\TestCase;

class ErrorsTest extends TestCase
{
    /**
     * errors container
     *
     * @var Errors
     */
    private $errors;

    public function __construct()
    {
        parent::__construct();
        $parser = new Parser(\file_get_contents(__DIR__ . '/json/errors.json'));
        $this->errors = $parser->errors();
    }

    /**
     * test Instance
     *
     * @return void
     */
    public function testInstance()
    {
        $this->assertInstanceOf(Errors::class, $this->errors);
        $this->assertInstanceOf(ErrorItem::class, $this->errors->get(0));
        $this->expectException(ParserException::class);
        $this->errors->get(4);
    }

    /**
     * error count
     *
     * @return void
     */
    public function testErrorCount()
    {
        $this->assertEquals(3, $this->errors->count());
    }

    /**
     * iteration test
     *
     * @return void
     */
    public function testIteration()
    {
        $i = 0;
        foreach ($this->errors as $index => $item) {
            $this->assertEquals($i, $index);
            $this->assertInstanceOf(ErrorItem::class, $item);
            $i++;
        }

        $this->assertEquals(3, $i);
    }

    public function testErrorItem()
    {
        $error = $this->errors->get(1);

        $this->assertSame(225, $error->code());
        $this->assertEquals(json_decode('{ "pointer": "/data/attributes/password" }'), $error->source());
        $this->assertSame("/data/attributes/password", $error->source()->pointer);
        $this->assertSame("Passwords must contain a letter, number, and punctuation character.", $error->title());
        $this->assertSame("The password provided is missing a punctuation character.", $error->detail());

        $error = $this->errors->get(0);

        $this->assertSame(null, $error->code());

        $error = $this->errors->get(2);

        $this->assertSame(null, $error->detail());
    }

}
