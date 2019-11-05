<?php
namespace JsonApiParser\Tests;

use JsonApiParser\JsonApi;
use PHPUnit\Framework\TestCase;

class JsonApiTest extends TestCase
{

    private $jsonapi;

    public function __construct()
    {
        parent::__construct();
        $this->jsonapi = new JsonApi(file_get_contents('/var/www/json-api-parser/json-api.json'));
    }

    public function testInstance()
    {
        $this->assertInstanceOf(JsonApi::class, $this->jsonapi);
    }

    public function testIsValidJson()
    {
        $this->assertTrue($this->jsonapi->isJson());

        $j = new JsonApi(file_get_contents('/var/www/json-api-parser/inavlid-json.json'), false);

        $this->assertFalse($j->isJson());

    }

}
