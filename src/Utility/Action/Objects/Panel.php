<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action\Objects;

use Nette\Application\UI\Presenter;
use Nette\ComponentModel\Component;
use Nette\Utils\Arrays;
use WebChemistry\AdminLTE\Utility\Action\Control\LazyControlInterface;

final class Panel
{

	private Component|string $finalControl;

	/** @var (callable(Component, Presenter): void)[] */
	public $onAttached = [];

	public function __construct(
		public string $title,
		private Component|LazyControlInterface|string $control,
	)
	{
		if (!$this->control instanceof LazyControlInterface) {
			$this->finalControl = $this->control;
		}
	}

	public function getControl(): Component|string
	{
		return $this->finalControl;
	}

	public function attach(Presenter $presenter, string $name): void
	{
		if (is_string($this->control)) {
			return;
		}

		if ($this->control instanceof LazyControlInterface) {
			$presenter->addComponent($this->finalControl = $control = $this->control->create(), $name);

			Arrays::invoke($this->onAttached, $control, $presenter);
		} else if (!$this->control->getParent()) {
			$presenter->addComponent($control = $this->control, $name);

			Arrays::invoke($this->onAttached, $control, $presenter);
		}
	}

}
