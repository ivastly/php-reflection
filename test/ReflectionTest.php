<?php

declare(strict_types=1);

namespace Ivastly\PhpReflection\Test;

use Ivastly\PhpReflection\Exception\PropertyNotFoundInObject;
use Ivastly\PhpReflection\Reflection;
use Ivastly\PhpReflection\Test\Fixtures\AClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * @covers \Ivastly\PhpReflection\Reflection
 * @covers \Ivastly\PhpReflection\Exception\PropertyNotFoundInObject
 */
class ReflectionTest extends TestCase
{
	private Reflection $reflection;

	private AClass $object;

	protected function setUp(): void
	{
		$this->reflection = new Reflection();
		$this->object     = new AClass();
	}

	/**
	 * @dataProvider visibilityDataProvider
	 *
	 * @param string $propertyName
	 * @param string $expectedVisibility
	 */
	public function testGetVisibility(string $propertyName, string $expectedVisibility): void
	{
		self::assertSame($expectedVisibility, $this->reflection->getVisibility($this->object, $propertyName));
	}

	/**
	 * @dataProvider hasPropertyDataProvider
	 *
	 * @param string $propertyName
	 * @param bool   $expectedResult
	 */
	public function testHasProperty(string $propertyName, bool $expectedResult): void
	{
		self::assertSame($expectedResult, $this->reflection->hasProperty($this->object, $propertyName));
	}

	/**
	 * @dataProvider getPropertyDataProvider
	 *
	 * @param string $propertyName
	 * @param string $expectedValue
	 *
	 * @throws PropertyNotFoundInObject
	 * @throws ReflectionException
	 */
	public function testGetProperty(string $propertyName, string $expectedValue): void
	{
		self::assertSame($expectedValue, $this->reflection->getProperty($this->object, $propertyName));
	}

	public function testGetPropertyException(): void
	{
		$this->expectException(PropertyNotFoundInObject::class);
		$this->reflection->getProperty($this->object, 'non-existing 🕵️ property');
	}

	public function getPropertyDataProvider(): array
	{
		return [
			[
				'property'      => 'publicField',
				'expectedValue' => 'public',
			],
			[
				'property'      => 'protectedField',
				'expectedValue' => 'overloaded protected',
			],
			[
				'property'      => 'privateField',
				'expectedValue' => 'private',
			],
			[
				'property'      => 'publicStaticField',
				'expectedValue' => 'public static',
			],
			[
				'property'      => 'traitField',
				'expectedValue' => 'trait field',
			],
			[
				'property'      => 'parentOnlyProtectedField',
				'expectedValue' => 'parent only protected',
			],
			[
				'property'      => 'parentOnlyPrivateField',
				'expectedValue' => 'parent only private',
			],
			[
				'property'      => 'shadowedField',
				'expectedValue' => 'private shadowed in child',
			],
		];
	}

	public function hasPropertyDataProvider(): array
	{
		return [
			[
				'property' => 'publicField',
				'exists'   => true,
			],
			[
				'property' => 'protectedField',
				'exists'   => true,
			],
			[
				'property' => 'privateField',
				'exists'   => true,
			],
			[
				'property' => 'publicStaticField',
				'exists'   => true,
			],
			[
				'property' => 'traitField',
				'exists'   => true,
			],
			[
				'property' => 'parentOnlyProtectedField',
				'exists'   => true,
			],
			[
				'property' => 'parentOnlyPrivateField',
				'exists'   => true,
			],
			[
				'property' => 'non-existing 🕵️ property',
				'exists'   => false,
			],
		];
	}

	public function visibilityDataProvider(): array
	{
		return [
			[
				'property'           => 'publicField',
				'expectedVisibility' => 'public',
			],
			[
				'property'           => 'protectedField',
				'expectedVisibility' => 'protected',
			],
			[
				'property'           => 'privateField',
				'expectedVisibility' => 'private',
			],
			[
				'property'           => 'publicStaticField',
				'expectedVisibility' => 'public',
			],
			[
				'property'           => 'traitField',
				'expectedVisibility' => 'private',
			],
			[
				'property'           => 'parentOnlyProtectedField',
				'expectedVisibility' => 'protected',
			],
			[
				'property'           => 'parentOnlyPrivateField',
				'expectedVisibility' => 'private',
			],
		];
	}
}
