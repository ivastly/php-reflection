<?php

declare(strict_types=1);

namespace DhJasmin\MailerApi\Arachne\Business\Service;

use InvalidArgumentException;
use ReflectionObject;

class Reflection
{
	public function getProperty(object $object, string $propertyName)
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
			throw new InvalidArgumentException("Property $propertyName does not exist in " . get_class($object));
		}

		$reflectionProperty->setAccessible(true);

		return $reflectionProperty->getValue($object);
	}

	public function getAllPropertiesAsObjects(object $object): array
	{
		$reflectionObject = new ReflectionObject($object);

		$allProperties = [];
		foreach ($reflectionObject->getProperties() as $reflectionProperty) {
			$propertyName                 = $reflectionProperty->getName();
			$allProperties[$propertyName] = $this->getProperty($object, $propertyName);
		}

		return $allProperties;
	}
}
