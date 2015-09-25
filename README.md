# WAAVI Sanitizer

## About WAAVI

WAAVI is a Spanish web development and product consulting agency, working with Startups and other online businesses since 2013. Need to get work done in Laravel or PHP? Contact us through [waavi.com](http://waavi.com/en/contactanos).

## Introduction

WAAVI Sanitizer provides an easy way to format user input, both through the provided filters or through custom ones that can easily be added to the sanitizer library.

Although not limited to Laravel 5 users, there are some extensions provided for this framework, like a way to easily Sanitize user input through a custom FormRequest and easier extensibility.

## Example

Given a data array with the following format:

    $data = [
        'first_name'    =>  'john',
        'last_name'     =>  '<strong>DOE</strong>',
        'email'         =>  '  JOHn@DoE.com',
        'birthdate'     =>  '06/25/1980',
    ];

We can easily format it using our Sanitizer and the some of Sanitizer's default filters:

    use \Waavi\Sanitizer\Sanitizer;

    $filters = [
        'first_name'    =>  'trim|escape|capitalize',
        'last_name'     =>  'trim|escape|capitalize',
        'email'         =>  'trim|escape|lowercase',
        'birthdate'     =>  'trim|format_date:m/d/Y, Y-m-d'
    ];

    $sanitizer  = new Sanitizer($data, $filters);
    var_dump($sanitizer->sanitize());

Which will yield:

    [
        'first_name'    =>  'John',
        'last_name'     =>  'Doe',
        'email'         =>  'john@doe.com',
        'birthdate'     =>  '1980-06-25',
    ];

It's usage is very similar to Laravel's Validator module, for those who are already familiar with it, although Laravel is not required to use this library.

Filters are applied in the same order they're defined in the $filters array. For each attribute, filters are separered by | and options are specified by suffixing a comma separated list of arguments (see format_date).

## Available filters

The following filters are included with Sanitize:

* 'trim': Trims a string
* 'escape': Escapes HTML and special chars using php's filter_var 
* 'lowercase': Converts the given string to all lowercase
* 'uppercase': Convert the given string to uppercase.
* 'capitalize': Capitalize a string.
* 'date_format': Always takes two arguments, the date's given format and the target format, following DateTime notation.

## Adding custom filters

You can add your own filters by passing a custom filter array to the Sanitize constructor as the third parameter. For each filter name, either a closure or a full classpath to a Class implementing the Waavi\Sanitizer\Contracts\Filter interface must be provided. Closures must always accept two parameters: $value and an $options array:

    class NoOddNumbersFilter implements Waavi\Sanitizer\Contracts\Filter
    {
        public function apply($value, $options = [])
        {
            return str_replace($options, '', $value);
        }
    }

    $customFilters = [
        'hash'   =>  function($value, $options = []) {
                return sha1($value);
            },
        'remove_strings' => RemoveStringsFilter::class,
    ];

    $filters = [
        'secret'    =>  'hash',
        'text'      =>  'remove_strings:Curse,Words,Galore',
    ];

    $sanitize = new Sanitize($data, $filters, $customFilters);

## Install

To install, just run:

    composer require waavi/sanitizer ~1.0

And you're done! If you're using Laravel, in order to be able to access some extra functionality you must register both the Service provider in the providers array in config/app.php, as well as the Sanitizer Facade:

    'providers' => [
        ...
        Waavi\Sanitizer\Laravel\SanitizerServiceProvider::class,
    ];

    'aliases' => [
        ...
        'Sanitizer' => Waavi\Sanitizer\Laravel\Facade::class,
    ];
    
## Laravel goodies

If you are using Laravel, you can use the Sanitizer through the Facade:

    $newData = \Sanitizer::make($data, $filters)->sanitize();

You can also easily extend the Sanitizer library just like you would the Validator library in Laravel, by calling extend from a ServiceProvider like so:

    \Sanitizer::extend($filterName, $closureOrClassPath);

Included with WAAVI Sanitizer is a FormRequest extension that allows you to define your data filters right in a FormRequest. To generate a Sanitized Request just execute the included Artisan command:

    php artisan make:sanitized-request TestSanitizedRequest

The only difference with a Laravel FormRequest is that now you'll have an extra 'fields' method in which to enter the input filters you wish to apply, and that input will be sanitized before being validated.

### License

WAAVI Sanitizer is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)