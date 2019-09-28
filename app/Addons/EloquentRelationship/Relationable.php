<?php

namespace App\Addons\EloquentRelationship;

trait Relationable
{
    /**
     * synchronize relationable model.
     *
     * @param  array  $attributes
     * @return mixed
     */
    public function sync(array $attributes = [])
    {
        $classes = $this->getRelationable();

        $relationClass = new $classes($this, $attributes);

        return $relationClass->handle();
    }

    /**
     * Returns the ModelFilter for the current model.
     *
     * @return string
     */
    public function getRelationable()
    {
        return method_exists($this, 'relationable')
                ? $this->relationable() : $this->provideRelationable();
    }

    /**
     * Returns ModelFilter class to be instantiated.
     *
     * @param null|string $filter
     * @return string
     */
    public function provideRelationable()
    {
        return 'App\\ModelRelationships\\'.class_basename($this).'Relation';
    }
}
