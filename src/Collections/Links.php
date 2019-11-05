<?php
namespace JsonApiParser\Collections;

class Document
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = \DS\Vector($this->data);;
    }

    

}
