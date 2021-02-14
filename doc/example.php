<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

class ParentClass
{
	private $property = 'parent private property';
}

class C extends ParentClass
{
}

$object     = new C();
$reflection = new \Ivastly\PhpReflection\Reflection();

$value      = $reflection->getProperty($object, 'property');
$visibility = $reflection->getVisibility($object, 'property');

echo "$visibility \$property = '$value;'\n"; // private $property = 'parent private property';

// Usage: docker-compose run php php doc/example.php
