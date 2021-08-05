<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action;

use Nette\Application\UI\Presenter;

interface EditActionFactory
{

	public function create(Presenter $presenter, string $class, string $title, string $controlName): EditAction;
	
}
