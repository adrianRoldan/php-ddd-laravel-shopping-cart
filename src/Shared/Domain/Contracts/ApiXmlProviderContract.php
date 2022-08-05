<?php

namespace Cart\Shared\Domain\Contracts;

use SimpleXMLElement;

interface ApiXmlProviderContract
{
    public function fromUrl(string $url): SimpleXMLElement;
}
