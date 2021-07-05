<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility;

trait TAdministrationUtility
{

	final public function injectUtilize(AdministrationUtilityFactory $factory) {
		$this->onStartup[] = fn () => $this->utilize($factory->create($this));
	}

	abstract protected function utilize(AdministrationUtility $utils): void;

}
