<?php
namespace JsonApiParser\Tests;

use JsonApiParser\JsonApi;
use JsonApiParser\JsonApiParserException;
use PHPUnit\Framework\TestCase;

class JsonApiExceptionTest extends TestCase
{
    public function testException()
    {
        $this->expectException(JsonApiParserException::class);

        $J = new JsonApi(file_get_contents("/var/www/json-api-parser/json-api-error.json"),false);
        $J->convertJson(true);

    }
}
