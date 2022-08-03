<?php

namespace Apps\Shared\Http\Response;

interface ResourceContract
{
    /**
     * @return array<string,mixed>
     */
    public function toArray(): array;
}
