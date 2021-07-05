<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility;

use Nette\Application\UI\Presenter;

interface AdministrationUtilityFactory
{

	public function create(Presenter $presenter): AdministrationUtility;

}
