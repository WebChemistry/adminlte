<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\ValueObject;

use Nette\Application\UI\Link;

final class MenuLink
{

	public function __construct(
		private string $name,
		private Link|string $link,
		private ?string $icon = null,
	)
	{
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getLink(): string
	{
		return (string) $this->link;
	}

	public function isLinkCurrent(): bool
	{
		return $this->link instanceof Link && $this->link->isLinkCurrent();
	}

	public function getIcon(): ?string
	{
		return $this->icon;
	}

}
