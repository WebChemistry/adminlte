<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action\Argument;

use Nette\Application\UI\Link;

final class FormArgument
{

	public function __construct(
		public ?string $flashMessage = 'Form was submitted.',
		public string|Link|null $redirect = 'this',
	)
	{
	}

}
