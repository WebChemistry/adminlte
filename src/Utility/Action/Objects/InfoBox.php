<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action\Objects;

final class InfoBox
{

	public function __construct(
		public string $title,
		public string $content,
	)
	{
	}

}
