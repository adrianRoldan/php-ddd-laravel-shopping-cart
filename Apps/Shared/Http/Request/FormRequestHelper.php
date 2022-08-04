<?php

namespace Apps\Shared\Http\Request;

use Cart\Shared\Domain\Exceptions\InvalidParameterException;
use Cart\Shared\Domain\Exceptions\JsonInvalidException;
use Cart\Shared\Domain\Exceptions\RequiredParameterException;
use RuntimeException;

class FormRequestHelper
{
    private AbstractFormRequest $formRequest;

    public function __construct(AbstractFormRequest $formRequest)
    {
        $this->formRequest = $formRequest;
    }


    /**
     * @param string $attribute
     * @param int|null $default
     * @return int
     */
    public function getInt(string $attribute, ?int $default = null): int
    {
        $value = $this->formRequest->input($attribute, $default);
        if (is_numeric($value)) {
            return (int)$value;
        }
        if (is_string($value)) {
            return (int)$value;
        }
        throw new RuntimeException('Invalid Value ' . $attribute . ' ' . $value);
    }


    /**
     * @param string $attribute
     * @param int|null $default
     * @return string
     */
    public function getString(string $attribute, ?int $default = null): string
    {
        $value = $this->formRequest->input($attribute, $default);
        if (is_string($value)) {
            return $value;
        }
        throw InvalidParameterException::fromMessage('Invalid Value ' . $attribute . ' ' . $value);
    }


    /**
     * @param string $attribute
     * @return int|null
     */
    public function getRequiredInt(string $attribute): ?int
    {
        $value = $this->formRequest->input($attribute);
        if ($value === null) {
            throw RequiredParameterException::fromParameter($attribute);
        }
        return $this->getInt($attribute);
    }


    /**
     * @param string $attribute
     * @param int|null $default
     * @return string
     */
    public function getRequiredString(string $attribute, ?int $default = null): string
    {
        $value = $this->formRequest->input($attribute, $default);

        if(null === $value){
            throw RequiredParameterException::fromParameter($attribute);
        }

        return $this->getString($attribute, $default);
    }


    public function getStringOrNull(string $attribute): ?string
    {
        $value = $this->formRequest->input($attribute);
        if ($value === null) {
            return null;
        }
        return $this->getString($attribute);
    }


    /**
     * @param string $string
     * @return string
     */
    public function routeString(string $string): string
    {
        $value = $this->formRequest->route($string);
        if (is_string($value)) {
            return $value;
        }
        throw InvalidParameterException::fromMessage('Wrong route value ' . $value);
    }

    /**
     * @param string $string
     * @return string|null
     */
    public function routeStringOrNull(string $string): ?string
    {
        $value = $this->formRequest->route($string);
        if ($value === null) {
            return null;
        }
        return $this->routeString($string);
    }


    /**
     * @return array<string,string>
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return bool|string|null
     */
    public function getContent(): bool|string|null
    {
        return $this->formRequest->getContent();
    }



    public function expectJson(): void
    {

        if(!$this->formRequest->isJson()){
            throw new JsonInvalidException("The content-type header is incorrect. Must be application/json");
        }
        $this->checkJson();
    }



    public function checkJson(): void
    {
        $content = $this->getContent();
        $data = json_decode($content);

        if ($data === null) {
            throw new JsonInvalidException();
        }
    }
}
