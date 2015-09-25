<?php

namespace Waavi\Sanitizer;

class Factory
{
    /**
     *  List of default filters
     *  @var array
     */
    protected $defaultFilters;

    /**
     *  List of custom filters
     *  @var array
     */
    protected $customFilters;

    /**
     * Create a new Sanitizer factory instance.
     *
     * @param  array  $defaultFilters   List of filters that can be applied
     * @return void
     */
    public function __construct(array $defaultFilters)
    {
        $this->defaultFilters = $defaultFilters;
        $this->customFilters  = [];
    }

    /**
     *  Create a new Sanitizer instance
     *
     *  @param  array   $data       Data to be sanitized
     *  @param  array   $rules      Filters to be applied to the given data
     *  @return Sanitizer
     */
    public function make(array $data, array $rules)
    {
        $filters   = array_merge($this->defaultFilters, $this->customFilters);
        $sanitizer = new Sanitizer($data, $rules, $filters);
        return $sanitizer;
    }

    /**
     *  Add a custom filters to all Sanitizers created with this Factory.
     *
     *  @param  string  $name       Name of the filter
     *  @param  mixed   $extension  Either the full class name of a Filter class implementing the Filter contract, or a Closure.
     *  @throws InvalidArgumentException
     *  @return void
     */
    public function extend($name, $customFilter)
    {
        if (empty($name) || !is_string($name)) {
            throw new InvalidArgumentException('The Sanitizer filter name must be a non-empty string.');
        }

        if (!($customFilter instanceof Closure) || !in_array(Contracts\Filter::class, class_implements($customFilter))) {
            throw new InvalidArgumentException('Custom filter must be a Closure or a class implementing the Waavi\Sanitizer\Contracts\Filter interface.');
        }

        $this->customFilters[$name] = $customFilter;
    }
}
