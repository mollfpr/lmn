<?php

namespace App\Addons\EloquentRelationship;

abstract class RelationModel
{
    /**
     * Array of request to filter.
     *
     * @var array
     */
    protected $request = [];

    /**
     * The model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * ModelFilter constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model  $model
     * @param array $request
     * @param bool
     */
    public function __construct($model, array $request = [])
    {
        $this->request = $this->removeEmptyInput($request);

        $this->model = $model;
    }

    /**
     * Handle all filters.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handle()
    {
        // Run request filters
        $this->filterRequest();

        return $this->model;
    }

    /**
     * Remove empty strings from the request array.
     *
     * @param array $request
     * @return array
     */
    public function removeEmptyInput($request)
    {
        $filterableRequest = [];

        foreach ($request as $key => $val) {
            if ($val !== '' && $val !== null) {
                $filterableRequest[$key] = $val;
            }
        }
        return $filterableRequest;
    }

    /**
     * Filter with request array.
     *
     * @return void
     */
    public function filterRequest()
    {
        foreach ($this->request as $key => $val) {
            // Call all local methods on filter
            $method = $this->getFilterMethod($key);

            if ($this->callableMethod($method)) {
                $this->{$method}($val);
            }
        }
    }
    /**
     * Get filter methods.
     *
     * @param $key
     * @return string
     */
    public function getFilterMethod($key)
    {
        return '__'.camel_case($key);
    }

    /**
     * Retrieve request by key or all request as array.
     *
     * @param null $key
     * @param null $default
     * @return array|mixed|null
     */
    public function request($key = null, $default = null)
    {
        if ($key === null) {
            return $this->request;
        }
        return array_key_exists($key, $this->request) ? $this->request[$key] : $default;
    }

    /**
     * Check if the method is callable on the extended class.
     *
     * @param  string $method
     * @return bool
     */
    public function callableMethod($method)
    {
        return method_exists($this, $method) && ! method_exists(RelationModel::class, $method);
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        $resp = call_user_func_array([$this->model, $method], $args);

        // Only return $this if model is returned
        return $resp instanceof \Illuminate\Database\Eloquent\Model ? $this : $resp;
    }
}
