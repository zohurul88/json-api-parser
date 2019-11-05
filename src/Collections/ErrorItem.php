<?php
namespace JsonApiParser\Collections;

class ErrorItem
{
    private $error;

    public function __construct(array $error)
    {
        $this->error = $error;
    }

    public function code()
    {
        return $this->error->code ?? null;
    }

    public function source()
    {
        return $this->error->source ?? null;
    }
    public function title()
    {
        return $this->error->title ?? null;
    }
    public function detail()
    {
        return $this->error->detail ?? null;
    }

}
