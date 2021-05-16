<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\ValueObject;

final class Administrator
{

	public function __construct(
		private bool $administrator,
		private string $name,
		private ?string $avatar = null,
	)
	{
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getAvatar(): ?string
	{
		return $this->avatar;
	}

	public function isAdministrator(): bool
	{
		return $this->administrator;
	}

}
