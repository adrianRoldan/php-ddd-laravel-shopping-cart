<?php

namespace Cart\Shared\Domain\Exceptions;

class ApiXmlProviderException extends BaseDomainException
{

    /**
     * @param string $url
     * @param string $messageError
     * @return self
     */
    public static function fromUrlAndMessage(string $url, string $messageError): self
    {
        return new self("Error connecting this XML API: ".$url.". Error: ".$messageError);
    }

    /**
     * @param string $url
     * @return self
     */
    public static function fromUrl(string $url): self
    {
        return new self("Error connecting this XML API: ".$url);
    }

}
