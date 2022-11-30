<?php declare(strict_types = 1);

namespace ApiGenTests\Features\Php81\NeverType;

use Exception;


class NeverType
{
	public function throwError(): never
	{
		throw new Exception();
	}
}
