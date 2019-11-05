<?php
namespace JsonApiParser;

use JsonApiParser;

abstract class JsonApiAbstract
{
    /**
     * Hold the json api response json
     *
     * @var string
     * @since 1.0.0
     */
    protected $apiString = null;

    /**
     * raw json object
     *
     * @var \stdClass
     */
    protected $rawObject = null;

    /**
     * JsonApi parser constructor
     *
     * @param string $apiString
     */
    public function __construct(string $apiString, $parse = true)
    {
        $this->apiString = $apiString;
        $this->convertJson($parse);
    }

    /**
     * Magic method to call function
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (method_exists($this, $name)) {
            return \call_user_func_array([$this, $name], $arguments);
        } else {
            throw new JsonApiParserException("Call an undefined method.");
        }
    }

    abstract public function data(): JsonApiParser\Collections\Document;
    abstract public function errors(): JsonApiParser\Collections\Errors;
    abstract public function links(): JsonApiParser\Collections\Links;
    abstract public function included(): JsonApiParser\Collections\Relations;

    /**
     * is the string is a valid json
     *
     * @return boolean
     */
    public function isJson(): bool
    {
        json_decode($this->apiString);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * string to json conversion
     *
     * @return JsonApi
     */
    public function convertJson($parse): JsonApi
    {
        if (!$this->isJson() && $parse) {
            throw new JsonApiParserException("Invalid json string!");
        }

        $this->rawObject = json_decode($this->apiString);

        if (isset($this->rawObject->data) && isset($this->rawObject->errors)) {
            throw new JsonApiParserException("The members data and errors MUST NOT coexist in the same document.");
        }
        
        return $this;
    }
}
