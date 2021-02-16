<?php

declare(strict_types=1);

namespace Ivastly\PhpReflection\Test\Fixtures;

class AClass extends AParent
{
	use ATrait;

	public string $publicField = 'public';

	protected string $protectedField = 'overloaded protected';

	private string $privateField = 'private';

	public static string $publicStaticField = 'public static';

	private string $shadowedField = 'private shadowed in child';
}
