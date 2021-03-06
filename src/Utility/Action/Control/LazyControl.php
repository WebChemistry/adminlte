<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action\Control;

use Nette\ComponentModel\Component;

final class LazyControl implements LazyControlInterface
{

	/** @var callable(): Component */
	private $factory;

	/**
	 * @var callable(): Component
	 */
	public function __construct(
		callable $factory,
	)
	{
		$this->factory = $factory;
	}

	public function create(): Component
	{
		return ($this->factory)();
	}

}
