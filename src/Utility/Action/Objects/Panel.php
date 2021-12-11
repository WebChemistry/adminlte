<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action\Objects;

use Nette\Application\UI\Presenter;
use Nette\ComponentModel\Component;
use WebChemistry\AdminLTE\Utility\Action\Control\LazyControl;

final class Panel
{

	private Component|string $finalControl;

	public function __construct(
		public string $title,
		private Component|LazyControl|string $control,
	)
	{
		if (!$this->control instanceof LazyControl) {
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

		if ($this->control instanceof LazyControl) {
			$presenter->addComponent($this->finalControl = $this->control->create(), $name);
		} else if (!$this->control->getParent()) {
			$presenter->addComponent($this->control, $name);
		}
	}

}
