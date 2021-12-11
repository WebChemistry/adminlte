<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action;

use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Nette\Application\UI\Control;
use Nette\Application\UI\ITemplate;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Template;
use WebChemistry\AdminLTE\Component\LineChartComponentFactory;
use WebChemistry\AdminLTE\Component\TableComponentFactory;
use WebChemistry\AdminLTE\Utility\Action\Injection\DefaultActionInjectionFactory;

/**
 * @template T of object
 */
final class EditAction extends DefaultAction
{

	private mixed $id;

	/** @var T */
	private object $entity;

	/**
	 * @param class-string<T> $class
	 */
	public function __construct(
		Presenter $presenter,
		string $action,
		string $title,
		string|callable $control,
		private string $class,
		DefaultActionInjectionFactory $defaultActionInjectionFactory,
	)
	{
		if (!method_exists($presenter, 'actionEdit') && !method_exists($presenter, 'renderEdit')) {
			throw new LogicException(
				sprintf(
					'Presenter %s must have actionEdit or renderEdit method with paremeter $id',
					$presenter::class
				)
			);
		}

		parent::__construct($presenter, $action, $title, $defaultActionInjectionFactory);

		$entity = $this->getEntity();
		if (is_callable($control)) {
			$this->addPanel($title, $component = ($control)($entity), true);
		} else {
			$this->addPanelWithControlName($title, $control);
		}
	}

	/**
	 * @return T
	 */
	private function getEntity(): object
	{
		if (!isset($this->entity)) {
			$id = $this->id ?? $this->presenter->getParameter('id');

			if (!$id || !($entity = $this->em->getRepository($this->class)->find($id))) {
				$presenter->error();
			}

			$this->entity = $entity;
		}

		return $this->entity;
	}

	/**
	 * @param callable(T) $factory
	 */
	public function addPanelWithEntity(string $title, callable $factory): self
	{
		$this->addPanel($title, $factory($this->getEntity()), true);

		return $this;
	}

	public function setId(mixed $id): void
	{
		$this->id = $id;
	}

}
