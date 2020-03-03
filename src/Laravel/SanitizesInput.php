<?php

namespace Waavi\Sanitizer\Laravel;

trait SanitizesInput
{
    /**
     *  Sanitize input before validating.
     *
     *  Kept for backwards compatibility with Laravel <= 5.5
     *  
     *  @deprecated Renamed to validateResolved() in Laravel 5.6
     *  @return void
     */
    public function validate()
    {
        $this->sanitize();
        parent::validate();
    }

    /**
     *  Sanitize input before validating.
     *
     *  Compatible with Laravel 5.6+
     *
     *  @return void
     */
    public function validateResolved()
    {
        $this->sanitize();
        parent::validateResolved();
    }

    /**
     *  Sanitize this request's input
     *
     *  @return void
     */
    public function sanitize()
    {
        $this->addCustomFilters();
        $this->sanitizer = app('sanitizer')->make($this->input(), $this->filters());
        $this->replace($this->sanitizer->sanitize());
    }

    /**
     *  Add custom fields to the Sanitizer
     *
     *  @return void
     */
    public function addCustomFilters()
    {
        foreach ($this->customFilters() as $name => $filter) {
            app('sanitizer')->extend($name, $filter);
        }
    }

    /**
     *  Filters to be applied to the input.
     *
     *  @return array
     */
    public function filters()
    {
        return [];
    }

    /**
     *  Custom Filters to be applied to the input.
     *
     *  @return array
     */
    public function customFilters()
    {
        return [];
    }
}
