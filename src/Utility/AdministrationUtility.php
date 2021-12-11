<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility;

use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Nette\Application\UI\Presenter;
use WebChemistry\AdminLTE\Component\TableComponentFactory;
use WebChemistry\AdminLTE\Utility\Action\DefaultAction;
use WebChemistry\AdminLTE\Utility\Action\DefaultActionFactory;
use WebChemistry\AdminLTE\Utility\Action\EditAction;
use WebChemistry\AdminLTE\Utility\Action\EditActionFactory;

final class AdministrationUtility
{

	public function __construct(
		private Presenter $presenter,
		private DefaultActionFactory $defaultActionFactory,
		private EditActionFactory $editActionFactory,
	)
	{
	}

	public function createAction(string $action, string $title): DefaultAction
	{
		return $this->defaultActionFactory->create($this->presenter, $action, $title);
	}

	/**
	 * @template T of object
	 * @param class-string<T> $entityClass
	 * @return EditAction<T>
	 */
	public function createEditAction(string $entityClass, string $title, string $controlName): EditAction
	{
		return $this->editActionFactory->create($this->presenter, $entityClass, $title, $controlName);
	}

}
