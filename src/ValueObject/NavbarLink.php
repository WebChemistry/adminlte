<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\ValueObject;

use Nette\Application\UI\Link;

final class NavbarLink
{

	public function __construct(
		private Link|string $link,
		private string $name,
	)
	{
	}

	public function getLink(): string
	{
		return (string) $this->link;
	}

	public function isLinkCurrent(): bool
	{
		return $this->link instanceof Link && $this->link->isLinkCurrent();
	}

	public function getName(): string
	{
		return $this->name;
	}



}
