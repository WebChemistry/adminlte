<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action;

use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\ITemplate;
use Nette\Application\UI\Presenter;

final class DefaultAction extends Action
{

	/** @var mixed[] */
	private array $panels = [];

	/** @var mixed[] */
	private array $infoBoxes = [];

	public function __construct(
		private Presenter $presenter,
		private EntityManagerInterface $em,
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

		$template = $this->createTemplate($this->presenter, __DIR__ . '/templates/action.latte');
		$template->title = $this->title;
		$template->panels = $this->panels;
		$template->infoBoxes = $this->infoBoxes;
	}

}
