<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action;

use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Application\UI\ITemplate;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Template;
use Nette\Utils\Arrays;
use WebChemistry\AdminLTE\Component\LineChartComponentFactory;
use WebChemistry\AdminLTE\Component\TableComponentFactory;
use WebChemistry\AdminLTE\Utility\Action\Injection\DefaultActionInjection;
use WebChemistry\AdminLTE\Utility\Action\Injection\DefaultActionInjectionFactory;
use WebChemistry\AdminLTE\Utility\Action\Objects\TableColumn;

class DefaultAction extends Action
{

	/** @var array{string, string|Control|Form}[] */
	protected array $panels = [];

	/** @var array{string, string}[] */
	protected array $infoBoxes = [];

	/** @var array<int, Control|Form> */
	protected array $attach = [];

	/** @var callable(Presenter): void */
	protected array $onRun = [];

	/** @var callable(Template, Presenter): void */
	protected array $onTemplate = [];

	protected EntityManagerInterface $em;

	protected TableComponentFactory $tableComponentFactory;

	protected LineChartComponentFactory $lineChartComponentFactory;

	public function __construct(
		protected Presenter $presenter,
		protected string $action,
		protected string $title,
		DefaultActionInjectionFactory $defaultActionInjectionFactory,
	)
	{
		$injection = $defaultActionInjectionFactory->create();

		$this->em = $injection->getEntityManager();
		$this->tableComponentFactory = $injection->getTableComponentFactory();
		$this->lineChartComponentFactory = $injection->getLineChartComponentFactory();
	}

	public function addLineChart(string $title, array $labels, array $values, ?callable $callback = null): static
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

	public function addInfoBox(string $title, mixed $content): static
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
	public function addTable(string $title, array $columns, array $values): static
	{
		if (!$this->show) {
			return $this;
		}

		$this->addPanel($title, $this->tableComponentFactory->create($values, $columns), true);

		return $this;
	}

	public function addPanel(string $title, Control|Form $control, bool $attach = false): static
	{
		$this->panels[] = [$title, $control];

		if ($attach) {
			$this->attach[] = $control;
		}

		return $this;
	}

	public function addPanelWithControlName(string $title, string $controlName): static
	{
		if (!$this->show) {
			return $this;
		}

		$this->panels[] = [$title, $controlName];

		return $this;
	}

	protected function getTemplateFile(): string
	{
		return __DIR__ . '/templates/action.latte';
	}

	public function run(): void
	{
		if ($this->presenter->action !== $this->action) {
			return;
		}

		Arrays::invoke($this->onRun, $this->presenter);

		foreach ($this->attach as $i => $control) {
			$this->presenter->addComponent($control, 'component_' . $i);
		}

		$template = $this->createTemplate($this->presenter, $this->getTemplateFile());
		$template->title = $this->title;
		$template->panels = $this->panels;
		$template->infoBoxes = $this->infoBoxes;

		Arrays::invoke($this->onTemplate, $template, $this->presenter);
	}

}
