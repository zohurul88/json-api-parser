<?php
namespace JsonApiParser;

use JsonApiParser;
use JsonApiParser\Exceptions\ParserException;

/**
 * Parser abstract class
 * @abstract
 * @author Zohurul ISlam <mail@zohurul.com>
 * @version 1.0.0
 * @since 1.0.0
 */
abstract class ParserAbstract
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
     * @since 1.0.0
     */
    protected $rawObject = null;

    /**
     * JsonApi parser constructor
     *
     * @param string $apiString
     * @since 1.0.0
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
     * @since 1.0.0
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (method_exists($this, $name)) {
            return \call_user_func_array([$this, $name], $arguments);
        } else {
            throw new ParserException("Call an undefined method.");
        }
    }

    /**
     * abstract function for Json:api data object
     *
     * @return JsonApiParser\Collections\Document
     * @since 1.0.0
     */
    abstract public function data(): JsonApiParser\Collections\Document;

    /**
     * abstract json:api errors functions
     *
     * @return JsonApiParser\Collections\Errors
     * @since 1.0.0
     */
    abstract public function errors(): JsonApiParser\Collections\Errors;

    /**
     * abstract json api links function
     *
     * @return JsonApiParser\Collections\Links
     * @since 1.0.0
     */
    abstract public function links(): JsonApiParser\Collections\Links;

    /**
     * abstract json api functions for include
     *
     * @return JsonApiParser\Collections\Relations
     * @since 1.0.0
     */
    abstract public function included(): ?JsonApiParser\Collections\Relations;

    /**
     * is it a valid json string 
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
     * @return Parser
     */
    public function convertJson($parse): Parser
    {
        if (!$this->isJson() && $parse) {
            throw new ParserException("Invalid json string!");
        }

        $this->rawObject = json_decode($this->apiString);

        if (isset($this->rawObject->data) && isset($this->rawObject->errors)) {
            throw new ParserException("The members data and errors MUST NOT coexist in the same document.");
        }
        
        return $this;
    }
}
