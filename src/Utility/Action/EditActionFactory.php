<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action;

use Nette\Application\UI\Presenter;

interface EditActionFactory
{

	/**
	 * @template T of object
	 * @param class-string<T> $class
	 * @return EditAction<T>
	 */
	public function create(
		Presenter $presenter,
		string $class,
		string $title,
		string|callable $control,
		string $action = 'edit'
	): EditAction;

}
