<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Form;

use Nette\Application\UI\Form;

interface AdminFormFactoryInterface
{

	public function create(): Form;

}
