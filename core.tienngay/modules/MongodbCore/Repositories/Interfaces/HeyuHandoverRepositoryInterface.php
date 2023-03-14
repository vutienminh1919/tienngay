<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface HeyuHandoverRepositoryInterface
{
	/**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return collection
     */
    public function store($attributes);
}
