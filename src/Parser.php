<?php

namespace JsonApiParser;

use JsonApiParser\Collections\Document;
use JsonApiParser\Collections\Errors;
use JsonApiParser\Collections\Links;
use JsonApiParser\Collections\Relations;

class Parser extends ParserAbstract
{
    /**
     * json:api included block
     *
     * @var Relations
     * @since 1.0.0
     */
    private $included = null;

    /**
     * For test purpose
     *
     * @var integer
     * @ignore 
     */
    public $includedInitCount = 0;

    /**
     * Parser data object block
     *
     * @return Document
     * @since 1.0.0
     */
    public function data(): Document
    {
        if (!isset($this->rawObject->data)) {
            throw new ParserException("Data field missing in the json.");
        }

        if (empty($this->rawObject->data)) {
            throw new ParserException("There is no data in data field.");
        }

        return new Document(is_array($this->rawObject->data) ? $this->rawObject->data : [$this->rawObject->data]);
    }

    /**
     * parser errors object
     *
     * @return Errors
     * @since 1.0.0
     */
    public function errors(): Errors
    {
        return new Errors($this->rawObject->errors);
    }

    /**
     * parser links object
     *
     * @return Links
     * @since 1.0.0
     */
    public function links(): Links
    {
        return new Links($this->rawObject->links);
    }

    /**
     * Parser included block for relationships
     *
     * @return Relations
     */
    public function included(): Relations
    {
        if (is_null($this->included)) {
            $this->includedInitCount++;
            $this->included = new Relations($this->rawObject->included);
        }
        return $this->included;
    }
}
