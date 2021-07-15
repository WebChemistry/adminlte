<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\DI;

use Nette\DI\CompilerExtension;
use WebChemistry\AdminLTE\Component\TableComponentFactory;
use WebChemistry\AdminLTE\Utility\AdministrationUtilityFactory;

final class AdminLTEExtension extends CompilerExtension
{

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addFactoryDefinition($this->prefix('utilityFactory'))
			->setImplement(AdministrationUtilityFactory::class);

		$builder->addFactoryDefinition($this->prefix('tableFactory'))
			->setImplement(TableComponentFactory::class);
	}

}
