<?php declare(strict_types = 1);

namespace ApiGenTests\Features\Php82\NullType;


class NullType
{
	public function test(null $value): null
	{
		return $value;
	}
}
