<?php

declare(strict_types=1);

namespace Ivastly\PhpReflection\Exception;

use Exception;

class PropertyNotFoundInObject extends Exception
{
	private object $object;

	private string $propertyName;

	public function __construct(object $object, string $propertyName)
	{
		$this->object       = $object;
		$this->propertyName = $propertyName;
		parent::__construct("Property $propertyName does not exist in " . get_class($object));
	}

	public function getObject(): object
	{
		return $this->object;
	}

	public function getPropertyName(): string
	{
		return $this->propertyName;
	}
}
