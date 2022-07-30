<?php

namespace Cart\Shared\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentBaseModel extends Model
{
    // Avoid auto-generated-incremental database identifier
    public $incrementing = false;

    // Change the name of laravel timestamps
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    // Change format to unix timestamps the laravel timestamps
    public function getDateFormat(): string
    {
        return 'U';
    }
}
