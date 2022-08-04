<?php

namespace Cart\Shared\Infrastructure\Services;

use Cart\Shared\Domain\Contracts\ApiXmlProviderContract;
use Cart\Shared\Domain\Exceptions\ApiXmlProviderException;
use SimpleXMLElement;
use Throwable;

class SimpleXmlProvider implements ApiXmlProviderContract
{


    public function fromUrl(string $url): SimpleXMLElement
    {
        try{

            $xml =  simplexml_load_string(file_get_contents($url));

            if(false === $xml){
                throw ApiXmlProviderException::fromUrl($url);
            }

            return $xml;

        }catch(Throwable $exception){

            throw ApiXmlProviderException::fromUrlAndMessage($url, $exception->getMessage());
        }
    }
}
