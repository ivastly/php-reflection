<?php

declare(strict_types=1);

namespace Ivastly\PhpReflection;

use Ivastly\PhpReflection\Exception\PropertyNotFoundInObject;
use ReflectionException;
use ReflectionObject;
use ReflectionProperty;

class Reflection
{
	/**
	 * @param object $object
	 * @param string $propertyName
	 *
	 * @return bool true if $propertyName exists in object's class, including parent classes, false otherwise.
	 */
	public function hasProperty(object $object, string $propertyName): bool
	{
		$reflectionObject = new ReflectionObject($object);

		return $reflectionObject->hasProperty($propertyName);
	}

	/**
	 * @param object $object
	 * @param string $propertyName
	 *
	 * @return mixed value of the property + including properties from parent classes.
	 * @throws PropertyNotFoundInObject
	 * @throws ReflectionException
	 */
	public function getProperty(object $object, string $propertyName)
	{
		$reflectionProperty = $this->getReflectionProperty($object, $propertyName);
		$reflectionProperty->setAccessible(true);

		return $reflectionProperty->getValue($object);
	}

	/**
	 * @param object $object
	 * @param string $propertyName
	 *
	 * @return string 'public', 'protected' or 'private' ("default" visibility is considered as `public`)
	 * @throws PropertyNotFoundInObject
	 * @throws ReflectionException
	 */
	public function getVisibility(object $object, string $propertyName): string
	{
		$reflectionProperty = $this->getReflectionProperty($object, $propertyName);

		if ($reflectionProperty->isPrivate()) {
			return 'private';
		}

		if ($reflectionProperty->isPublic()) {
			return 'public';
		}

		return 'protected';
	}

	/**
	 * @param object $object
	 * @param string $propertyName
	 *
	 * @return ReflectionProperty
	 * @throws PropertyNotFoundInObject
	 * @throws ReflectionException
	 */
	private function getReflectionProperty(object $object, string $propertyName): ReflectionProperty
	{
		$reflectionObject = new ReflectionObject($object);

		$reflectionProperty = null;

		if ($reflectionObject->hasProperty($propertyName)) {
			$reflectionProperty = $reflectionObject->getProperty($propertyName);
		} else {
			$parent = $reflectionObject->getParentClass();
			while ($reflectionProperty === null && $parent !== false) {
				if ($parent->hasProperty($propertyName)) {
					$reflectionProperty = $parent->getProperty($propertyName);
				}

				$parent = $parent->getParentClass();
			}
		}

		if (!$reflectionProperty) {
			throw new PropertyNotFoundInObject($object, $propertyName);
		}

		return $reflectionProperty;
	}
}
