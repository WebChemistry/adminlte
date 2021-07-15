<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility;

use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Nette\Application\UI\Presenter;
use WebChemistry\AdminLTE\Component\TableComponentFactory;
use WebChemistry\AdminLTE\Utility\Action\DefaultAction;
use WebChemistry\AdminLTE\Utility\Action\EditAction;

final class AdministrationUtility
{

	public function __construct(
		private Presenter $presenter,
		private EntityManagerInterface $em,
		private TableComponentFactory $tableComponentFactory,
	)
	{
	}

	public function createAction(string $action, string $title): DefaultAction
	{
		return new DefaultAction($this->presenter, $this->em, $this->tableComponentFactory, $action, $title);
	}

	public function createEditAction(string $entityClass, string $title, string $controlName): EditAction
	{
		return new EditAction($this->presenter, $this->em, $entityClass, $title, $controlName);

//		if ($this->presenter->action !== 'edit') {
//			return;
//		}
//		if (!method_exists($this->presenter, 'actionEdit') && !method_exists($this->presenter, 'renderEdit')) {
//			throw new LogicException(sprintf('Presenter %s must have actionEdit or renderEdit method with paremeter $id', get_class($this->presenter)));
//		}
//		if ($id === null) {
//			$id = $this->presenter->getParameter('id');
//		}
//
//		if (!$id || !($row = $this->em->getRepository($entityClass)->find($id))) {
//			$this->presenter->error();
//		}
//
//		$template = $this->createTemplate(__DIR__ . '/templates/edit.latte');
//
//		$template->name = $panelTitle;
//		$template->controlName = $controlName;
//
//		if ($property) {
//			if (!property_exists($this->presenter, $property)) {
//				throw new UtilsException(sprintf('Property %s not exists in %s class', $property, get_class($this->presenter)));
//			}
//			$setter = 'set' . ucfirst(substr($entityClass, strrpos($entityClass, '\\') + 1));
//			$control = $this->presenter->{$property};
//			if (!method_exists($control, $setter)) {
//				throw new UtilsException(sprintf('Setter %s not exists in %s', $setter, get_class($control)));
//			}
//			$control->{$setter}($row);
//		}
	}

}
