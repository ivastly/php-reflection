<?php

declare(strict_types=1);

namespace Ivastly\PhpReflection\Exception;

use Exception;

class PropertyNotFoundInObject extends Exception
{
	public function __construct(object $object, string $propertyName)
	{
		parent::__construct("Property $propertyName does not exist in " . get_class($object));
	}
}
