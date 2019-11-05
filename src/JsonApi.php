<?php
namespace JsonApiParser;

use JsonApiParser\Collections\Document;
use JsonApiParser\Collections\Errors;
use JsonApiParser\Collections\Links;
use JsonApiParser\Collections\Relations;
 
class JsonApi extends JsonApiAbstract
{

    public function data(): Document
    {
        if (!isset($this->rawObject->data)) {
            throw new JsonApiParserException("Data field missing in the json.");
        }

        if (!is_array($this->rawObject->data)) {
            throw new JsonApiParserException("Data field must be an array.");
        }

        if (empty($this->rawObject->data)) {
            throw new JsonApiParserException("There is no data in data field.");
        }

        return new Document($this->rawObject->data);
    }

    public function errors(): Errors
    {
        return new Errors($this->rawObject->data);
    }
    public function links(): Links
    {
        return new Links($this->rawObject->data);
    }
    public function included(): Relations
    {
        return new Relations($this->rawObject->data);
    }
}
