<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action;

use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\Control;
use Nette\Application\UI\ITemplate;
use Nette\Application\UI\Presenter;
use WebChemistry\AdminLTE\Component\TableComponentFactory;

final class DefaultAction extends Action
{

	/** @var mixed[] */
	private array $panels = [];

	/** @var mixed[] */
	private array $infoBoxes = [];

	/** @var mixed[] */
	private array $tables = [];

	/** @var Control[] */
	private array $attach = [];

	public function __construct(
		private Presenter $presenter,
		private EntityManagerInterface $em,
		private TableComponentFactory $tableComponentFactory,
		private string $action,
		private string $title,
	)
	{
	}

	public function addInfoBox(string $title, mixed $content): self
	{
		$this->infoBoxes[] = [$title, (string) $content];

		return $this;
	}

	public function addTable(string $title, array $values, array $columns, array $headers): self
	{
		$this->panels[] = [$title, $control = $this->tableComponentFactory->create($values, $columns, $headers)];
		$this->attach[] = $control;

		return $this;
	}

	public function addPanelWithControlName(string $title, string $controlName): self
	{
		$this->panels[] = [$title, $controlName];

		return $this;
	}

	public function run(): void
	{
		if ($this->presenter->action !== $this->action) {
			return;
		}

		foreach ($this->attach as $i => $control) {
			$this->presenter->addComponent($control, 'component_' . $i);
		}

		$template = $this->createTemplate($this->presenter, __DIR__ . '/templates/action.latte');
		$template->title = $this->title;
		$template->panels = $this->panels;
		$template->infoBoxes = $this->infoBoxes;
		$template->tables = $this->tables;
	}

}
