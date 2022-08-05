<?php

namespace Cart\Shared\Infrastructure\Repositories;

use Cart\Shared\Domain\Contracts\Repositories\Repository;
use Cart\Shared\Domain\Entities\DomainEntity;

abstract class EloquentBaseRepository implements Repository
{
    /**
     * @param DomainEntity $domainEntity
     * @param string $className
     * @param array<string,mixed> $data
     * @return void
     */
    public function upsert(DomainEntity $domainEntity, string $className, array $data): void
    {
        /** @var EloquentBaseModel $eloquentClass */
        $eloquentClass = new $className;

        if ($domainEntity->isNew()) {   //Creating
            $this->insert($eloquentClass, $data);

        } else {    //Updating
            /** @var EloquentBaseModel|null $ec */
            $ec = $eloquentClass::query()->find($domainEntity->id->getValue());
            if (null === $ec) {
                $this->insert($eloquentClass, $data);
            } else {
                $this->update($ec, $data);
            }
        }
    }

    /**
     * @param EloquentBaseModel $eloquentClass
     * @param array<string,mixed> $data
     * @return void
     */
    private function insert(EloquentBaseModel $eloquentClass, array $data): void
    {
        $eloquentClass::query()->create($data);
    }

    /**
     * @param EloquentBaseModel $ec
     * @param array<string,mixed> $data
     * @return void
     */
    private function update(EloquentBaseModel $ec, array $data): void
    {
        $ec->fill($data);
        $ec->save();
    }
}
