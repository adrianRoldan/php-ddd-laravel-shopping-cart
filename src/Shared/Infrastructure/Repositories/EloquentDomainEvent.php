<?php

namespace Cart\Shared\Infrastructure\Repositories;

class EloquentDomainEvent extends EloquentBaseModel
{
    protected $table = 'events';
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'eventName',
        'relatedId',
        'stream',
        'initiatorId',
        'occurredOn',
        'data',
    ];
}
