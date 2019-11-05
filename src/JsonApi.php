<?php
namespace JsonApiParser;

use JsonApiParser\Collections\Document;
use JsonApiParser\Collections\Errors;
use JsonApiParser\Collections\Links;
use JsonApiParser\Collections\Relations;

class JsonApi extends JsonApiAbstract
{
    private $included = null;

    public function data(): Document
    {
        if (!isset($this->rawObject->data)) {
            throw new JsonApiParserException("Data field missing in the json.");
        }

        if (empty($this->rawObject->data)) {
            throw new JsonApiParserException("There is no data in data field.");
        }

        return new Document(is_array($this->rawObject->data) ? $this->rawObject->data : [$this->rawObject->data]);
    }

    public function errors(): Errors
    {
        return new Errors($this->rawObject->errors);
    }
    public function links(): Links
    {
        return new Links($this->rawObject->links);
    }
    public function included(): Relations
    {
        if (is_null($this->included)) {
            $this->included = new Relations($this->rawObject->included);
        }
        return $this->included;
    }
}
