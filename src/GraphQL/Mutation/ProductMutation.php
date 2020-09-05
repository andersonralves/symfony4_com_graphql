<?php

namespace App\GraphQL\Mutation;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

class ProductMutation implements MutationInterface, AliasedInterface
{
	/**
	 * @var EntityManager
	 */
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createProduct(Argument $args)
	{
		$input = $args['input'];

		$product = new Product();
		$product->setName($input['name']);
		$product->setPrice($input['price']);
		$product->setDescription($input['description']);
		$product->setSlug($input['slug']);

		$this->em->persist($product);
		$this->em->flush();

		return $product;
	}

	public static function getAliases(): array
	{
		return [
			'createProduct' => 'create_product'
		];
	}
}