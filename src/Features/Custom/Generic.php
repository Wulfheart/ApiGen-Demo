<?php declare(strict_types = 1);

namespace ApiGenTests\Features\Custom;

use ApiGenTests\Features\Php80\ConstructorPromotion\Node;
use ApiGenTests\Features\Php80\ConstructorPromotion\ParamNode;
use ApiGenTests\Features\Php81\IntersectionTypes\Collection;


class Generic extends Second
{
    /**
     * @return phpstan-string<Node|ParamNode>
     */
	public function getIt(): string
    {
        return "";
    }

    /**
     * @return Collection<string>
     */
    public function class() {

    }
}
