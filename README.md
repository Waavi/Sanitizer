# WAAVI Sanitizer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/waavi/sanitizer.svg?style=flat-square)](https://packagist.org/packages/waavi/sanitizer)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/waavi/sanitizer/master.svg?style=flat-square)](https://travis-ci.org/waavi/sanitizer)
[![Total Downloads](https://img.shields.io/packagist/dt/waavi/sanitizer.svg?style=flat-square)](https://packagist.org/packages/waavi/sanitizer)

## About WAAVI

WAAVI is a Spanish web development and product consulting agency, working with Startups and other online businesses since 2013. Need to get work done in Laravel or PHP? Contact us through [waavi.com](http://waavi.com/en/contactanos).

## Introduction

WAAVI Sanitizer provides an easy way to format user input, both through the provided filters or through custom ones that can easily be added to the sanitizer library.

Although not limited to Laravel 5 users, there are some extensions provided for this framework, like a way to easily Sanitize user input through a custom FormRequest and easier extensibility.

## Example

Given a data array with the following format:

```php
$data = [
    'first_name'    =>  'john',
    'last_name'     =>  '<strong>DOE</strong>',
    'email'         =>  '  JOHn@DoE.com',
    'birthdate'     =>  '06/25/1980',
    'jsonVar'       =>  '{"name":"value"}',
    'description'   =>  '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>'
];
```

We can easily format it using our Sanitizer and the some of Sanitizer's default filters:

```php
use \Waavi\Sanitizer\Sanitizer;

$filters = [
    'first_name'    =>  'trim|escape|capitalize',
    'last_name'     =>  'trim|escape|capitalize',
    'email'         =>  'trim|escape|lowercase',
    'birthdate'     =>  'trim|format_date:m/d/Y, Y-m-d',
    'jsonVar'       =>  'cast:array',
    'description'   =>  'strip_tags'
];

$sanitizer  = new Sanitizer($data, $filters);
var_dump($sanitizer->sanitize());
```

Which will yield:
```php
[
    'first_name'    =>  'John',
    'last_name'     =>  'Doe',
    'email'         =>  'john@doe.com',
    'birthdate'     =>  '1980-06-25',
    'jsonVar'       =>  '["name" => "value"]',
    'description'   =>  'Test paragraph. Other text'
];
```

It's usage is very similar to Laravel's Validator module, for those who are already familiar with it, although Laravel is not required to use this library.

Filters are applied in the same order they're defined in the $filters array. For each attribute, filters are separered by | and options are specified by suffixing a comma separated list of arguments (see format_date).

## Available filters

The following filters are available out of the box:

 Filter  | Description
:---------|:----------
 **trim**   | Trims a string
 **escape**    | Escapes HTML and special chars using php's filter_var
 **lowercase**    | Converts the given string to all lowercase
 **uppercase**    | Converts the given string to all uppercase
 **capitalize**    | Capitalize a string
 **cast**           | Casts a variable into the given type. Options are: integer, float, string, boolean, object, array and Laravel Collection.
 **format_date**    | Always takes two arguments, the date's given format and the target format, following DateTime notation.
 **strip_tags**    | Strip HTML and PHP tags using php's strip_tags


## Adding custom filters

You can add your own filters by passing a custom filter array to the Sanitize constructor as the third parameter. For each filter name, either a closure or a full classpath to a Class implementing the Waavi\Sanitizer\Contracts\Filter interface must be provided. Closures must always accept two parameters: $value and an $options array:

```php
class RemoveStringsFilter implements Waavi\Sanitizer\Contracts\Filter
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
```

## Install

To install, just run:

```
composer require waavi/sanitizer ~1.0
```

And you're done! If you're using Laravel, in order to be able to access some extra functionality you must register both the Service provider in the providers array in config/app.php, as well as the Sanitizer Facade:

```php
'providers' => [
    ...
    Waavi\Sanitizer\Laravel\SanitizerServiceProvider::class,
];

'aliases' => [
    ...
    'Sanitizer' => Waavi\Sanitizer\Laravel\Facade::class,
];
```

## Facade Usage

If you are using Laravel, you can use the Sanitizer through the Facade:

```php
$newData = \Sanitizer::make($data, $filters)->sanitize();
```

## Extending the Sanitizer

You can also easily extend the Sanitizer library by adding your own custom filters, just like you would the Validator library in Laravel, by calling extend from a ServiceProvider like so:

```php
\Sanitizer::extend($filterName, $closureOrClassPath);
```

## Usage inside a controller

For basic sanitization you can use the sanitizer directly in your controller method like the example below. If you would like to sanitize the request before the controller method code is executed, scroll down.

```php
class Controller
{
    public function someAction(Request $request)
    {
        $filters = [
            'quantity' => 'cast:int',
            'email' => 'strip_tags',
        ];

        $sanitizedData = \Sanitizer::make($request->all(), $filters)

        // do stuff with clean data
    }
}
```

## Sanitizing the Request before controller method is executed

To keep your sanitization code outside of your controller and run the sanitization before the controller method code is executed:
1. Extend the request class and include the `SanitizesInput` trait
1. Define a filters method
1. Type hint the request in your controller method

```php
namespace App\Http\Requests;

use App\Http\Requests\Request;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class SanitizedRequest extends Request
{
    use SanitizesInput;

    public function filters()
    {
        return [
            'name'  => 'trim|capitalize',
            'email' => 'trim',
        ];
    }

    /* ... */
}
```

Now just type hint the sanitized request in your controller

```php
use App\Http\Requests\SanitizedRequest;

class Controller
{
    public function someAction(SanitizedRequest $request)
    {
        // everything is already sanitized
        $sanitizedData = $request->all();

        /* ... */
    }
}
```

## Generating a Sanitized Request

You may generate a sanitized request via the provided artisan command

`php artisan make:sanitized-request TestSanitizedRequest`

## Sanitizing a FormRequest

Sanitizing a FormRequest is the same as sanitizing a basic request. You just put the trait inside your FormRequest class

```php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class ExampleFormRequest extends FormRequest
{
    use SanitizesInput;

    public function filters()
    {
        return [
            'name'  => 'trim|capitalize',
            'email' => 'trim',
        ];
    }

    /* ... */
}
```

### License

WAAVI Sanitizer is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
