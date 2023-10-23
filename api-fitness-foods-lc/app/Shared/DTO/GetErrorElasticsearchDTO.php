<?php

namespace Shared\DTO;

class GetErrorElasticsearchDTO extends DTOAbstract
{
    /**
     * @var string|null
     */
    public ?string $message;

    /**
     * @var string|null
     */
    public ?string $message_exception;

    /**
     * @var string|null
     */
    public ?string $code;

    /**
     * @param string|null $message
     * @param string|null $message_exception
     * @param string|null $code
     * @return GetErrorElasticsearchDTO
     */
    public function register(?string $message = null, ?string $message_exception = null, ?string $code = null)
    {
        $this->message = $message;
        $this->message_exception = $message_exception;
        $this->code = $code;

        return $this;
    }
}
