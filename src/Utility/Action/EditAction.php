<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action;

use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Nette\Application\UI\ITemplate;
use Nette\Application\UI\Presenter;

final class EditAction extends Action
{

	private mixed $id;

	public function __construct(
		private Presenter $presenter,
		private EntityManagerInterface $em,
		private string $class,
		private string $title,
		private string $controlName,
	)
	{
	}

	public function setId(mixed $id): void
	{
		$this->id = $id;
	}

	public function run(): void
	{
		if ($this->presenter->action !== 'edit') {
			return;
		}

		if (!method_exists($this->presenter, 'actionEdit') && !method_exists($this->presenter, 'renderEdit')) {
			throw new LogicException(sprintf('Presenter %s must have actionEdit or renderEdit method with paremeter $id', get_class($this->presenter)));
		}

		$id = $this->id ?? $this->presenter->getParameter('id');

		if (!$id || !($entity = $this->em->getRepository($this->class)->find($id))) {
			$this->presenter->error();
		}

		$template = $this->createTemplate($this->presenter, __DIR__ . '/templates/edit.latte');

		$template->title = $this->title;
		$template->controlName = $this->controlName;
	}

}
