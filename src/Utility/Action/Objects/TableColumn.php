<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action\Objects;

use WebChemistry\AdminLTE\Utility\Action\Objects\Enums\TableColumnFormatEnum;

final class TableColumn
{

	/** @var callable|null */
	private $renderer;

	/**
	 * @param mixed[] $options
	 */
	public function __construct(
		private string $caption,
		private string $fieldPath,
		?callable $renderer = null,
		private ?TableColumnFormatEnum $format = null,
		private array $options = [],
	)
	{
		$this->renderer = $renderer;
	}

	public function getCaption(): string
	{
		return $this->caption;
	}

	public function getFieldPath(): string
	{
		return $this->fieldPath;
	}

	public function getRenderer(): ?callable
	{
		return $this->renderer;
	}

	/**
	 * @return mixed[]
	 */
	public function getOptions(): array
	{
		return $this->options;
	}

	public function getFormat(): ?TableColumnFormatEnum
	{
		return $this->format;
	}

}
