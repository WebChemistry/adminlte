<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action\Control;

use Nette\ComponentModel\Component;

interface LazyControlInterface
{

	public function create(): Component;

}
