<?php

namespace Cart\Shared\Domain\Contracts;

interface ApiXmlProviderContract
{
    public function fromUrl(string $url);
}
