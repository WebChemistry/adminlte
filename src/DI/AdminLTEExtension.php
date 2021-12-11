<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\DI;

use Nette\DI\CompilerExtension;
use WebChemistry\AdminLTE\Component\LineChartComponentFactory;
use WebChemistry\AdminLTE\Component\TableComponentFactory;
use WebChemistry\AdminLTE\Form\AdminFormFactory;
use WebChemistry\AdminLTE\Form\AdminFormFactoryInterface;
use WebChemistry\AdminLTE\Utility\Action\DefaultActionFactory;
use WebChemistry\AdminLTE\Utility\Action\EditActionFactory;
use WebChemistry\AdminLTE\Utility\Action\Injection\DefaultActionInjectionFactory;
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

		$builder->addFactoryDefinition($this->prefix('lineChartFactory'))
			->setImplement(LineChartComponentFactory::class);

		$builder->addFactoryDefinition($this->prefix('defaultActionFactory'))
			->setImplement(DefaultActionFactory::class);

		$builder->addFactoryDefinition($this->prefix('editActionFactory'))
			->setImplement(EditActionFactory::class);

		$builder->addDefinition($this->prefix('formFactory'))
			->setType(AdminFormFactoryInterface::class)
			->setFactory(AdminFormFactory::class);

		$builder->addFactoryDefinition($this->prefix('defaultActionInjectionFactory'))
			->setImplement(DefaultActionInjectionFactory::class);
	}

}
