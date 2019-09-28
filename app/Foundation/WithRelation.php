<?php

namespace App\Foundation;

use RuntimeException;
use Illuminate\Database\Eloquent\Builder;

trait WithRelations
{
  /**
   * Scope dynamic load relationship by client request.
   *
   * @param  \Illuminate\Database\Eloquent\Builder $query
   * @param  string  $includes
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIncludes(Builder $query, $includes)
  {
    if (!is_null($includes)) {
      return $query->with(
        $this->getWithableRelations($query, $includes)
      );
    }
  }

  /**
   * array list of relations that can be eagerly loaded.
   *
   * @param \Illuminate\Database\Eloquent\Builder  $query
   * @return array
   */
  protected function getWithableRelations(Builder $query, $includes)
  {
    $withable = $this->getWithable($query);

    $with = explode(',', $includes);

    return collect($with)->filter(function ($include) use ($withable) {
      return in_array($include, $withable);
    })->toArray();
  }

  /**
   * array list of relations that can be eagerly loaded.
   *
   * @param \Illuminate\Database\Eloquent\Builder  $query
   * @return array | throw
   */
  protected function getWithable(Builder $query)
  {
    if (method_exists($query->getModel(), 'includes')) {
      return $query->getModel()->includes();
    }

    if (property_exists($query->getModel(), 'includes')) {
      return $query->getModel()->includes;
    }

    throw new RuntimeException(
      sprintf('Model %s must either implement includes() or have $includes property set', get_class($query->getModel()))
    );
  }
}
