<?php

declare(strict_types=1);

namespace Ivastly\PhpReflection\Test\Fixtures;

class AParent
{
	protected string $protectedField = 'parent protected';

	protected string $parentOnlyProtectedField = 'parent only protected';

	private string $parentOnlyPrivateField = 'parent only private';
}
