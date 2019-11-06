<?php

namespace JsonApiParser\Collections;

class ErrorItem
{
    /**
     * Error container
     *
     * @var array
     * @since 1.0.0
     */
    private $error;

    /**
     * error constructor
     *
     * @param array $error
     */
    public function __construct(\stdClass $error)
    {
        $this->error = $error;
    }

    /**
     * error code
     *
     * @return integer|null
     * @since 1.0.0
     */
    public function code(): ?int
    {
        return $this->error->code ?? null;
    }

    /**
     * error source
     *
     * @return stdClass|null
     * @since 1.0.0
     */
    public function source(): ?\stdClass
    {
        return $this->error->source ?? null;
    }

    /**
     * error title
     *
     * @return string|null
     * @since 1.0.0
     */
    public function title(): ?string
    {
        return $this->error->title ?? null;
    }

    /**
     * error details
     *
     * @return string|null
     * @since 1.0.0
     */
    public function detail(): ?string
    {
        return $this->error->detail ?? null;
    }
}
