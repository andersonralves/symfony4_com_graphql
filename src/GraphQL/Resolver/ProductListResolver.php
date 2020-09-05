<?php

namespace App\GraphQL\Resolver;

use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class ProductListResolver implements ResolverInterface, AliasedInterface
{
	/**
	 * @var EntityManager
	 */
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function resolve(Argument $argument)
	{
		$criterios = [];

		if (isset($argument['price']))
			$criterios['price'] = $argument['price'];

		if (isset($argument['slug']))
			$criterios['slug'] = $argument['slug'];

		$products = $this->em->getRepository('App:Product')
			->findBy($criterios, [], $argument['limit'], 0);

		return ['products' => $products];
	}

	public static function getAliases(): array
	{
		return [
			'resolve' => 'ProductList'
		];
	}
}