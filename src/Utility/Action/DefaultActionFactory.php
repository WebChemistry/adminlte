<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action;

use Nette\Application\UI\Presenter;

interface DefaultActionFactory
{

	public function create(Presenter $presenter, string $action, string $title): DefaultAction;
	
}
