<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action\Control;

use Nette\Application\UI\Form;

final class LazyForm implements LazyControlInterface
{

	/** @var callable(): Form */
	private $factory;

	/**
	 * @var callable(): Form
	 */
	public function __construct(
		callable $factory,
	)
	{
		$this->factory = $factory;
	}

	public function create(): Form
	{
		return ($this->factory)();
	}

}
