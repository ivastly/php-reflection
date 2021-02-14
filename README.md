# PHP Reflection

## Rationale
Ever questioned yourself why you need to write more than a single line of code to get a value of private property?
What if the property is private and defined in a parent class? Even more toil is required. 
Please welcome a library to solve this trouble once and for all.

## Functionality
- Read value of any property of an object, including parent classes, with a single call.
- Find out the visibility of a property, including parent classes, with a single call.
- Check if a property exists in a class.

## Installation
```bash
composer require ivastly/php-reflection
```

## Usage
```php
class ParentClass {
    private $property = 'parent private property';
}

class C extends ParentClass {

}

$object = new C();
$reflection = new \Ivastly\PhpReflection\Reflection();

$value = $reflection->getProperty($object, 'property');
$visibility = $reflection->getVisibility($object, 'property');

echo "$visibility \$property = '$value;'\n"; // private $property = 'parent private property';
```

See [example.php](/doc/example.php)

## Tests
```bash
make test
```

### Code coverage 🟩
![coverage is 100%](/doc/coverage.png)

## License
See [LICENSE.md](/LICENSE.md)

## Contributing
See [CONTRIBUTING.md](/CONTRIBUTING.md)
