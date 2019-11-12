<?php

namespace Waavi\Sanitizer\Laravel;

use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

class FormRequest extends LaravelFormRequest
{
    /**
     *  Sanitize input before validating.
     *
     *  @return void
     */
    public function validate()
    {
        $this->sanitize();
        parent::validate();
    }

    /**
     *  Sanitize this request's input
     *
     *  @return void
     */
    public function sanitize()
    {
        $this->sanitizer = \Sanitizer::make($this->input(), $this->filters());
        $this->replace($this->sanitizer->sanitize());
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
     *  Validation rules to be applied to the input.
     *
     *  @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
