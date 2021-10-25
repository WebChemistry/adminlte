<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action;

use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\Control;
use Nette\Application\UI\ITemplate;
use Nette\Application\UI\Presenter;
use WebChemistry\AdminLTE\Component\LineChartComponentFactory;
use WebChemistry\AdminLTE\Component\TableComponentFactory;
use WebChemistry\AdminLTE\Utility\Action\Objects\TableColumn;

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
		private LineChartComponentFactory $lineChartComponentFactory,
		private string $action,
		private string $title,
	)
	{
	}

	public function addLineChart(string $title, array $labels, array $values, ?callable $callback = null): self
	{
		if (!$this->show) {
			return $this;
		}

		$control = $this->lineChartComponentFactory->create($labels, $values);
		$this->enableExtension($this->presenter, 'chartJs');

		if ($callback) {
			$callback($control);
		}

		$this->panels[] = [$title, $control];
		$this->attach[] = $control;

		return $this;
	}

	public function addInfoBox(string $title, mixed $content): self
	{
		if (!$this->show) {
			return $this;
		}

		$this->infoBoxes[] = [$title, (string) $content];

		return $this;
	}

	/**
	 * @param TableColumn[] $columns
	 * @param mixed[] $values
	 */
	public function addTable(string $title, array $columns, array $values): self
	{
		if (!$this->show) {
			return $this;
		}

		$this->panels[] = [$title, $control = $this->tableComponentFactory->create($values, $columns)];
		$this->attach[] = $control;

		return $this;
	}

	public function addPanelWithControlName(string $title, string $controlName): self
	{
		if (!$this->show) {
			return $this;
		}

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
