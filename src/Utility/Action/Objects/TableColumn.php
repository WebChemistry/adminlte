<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action\Objects;

use BadMethodCallException;
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
		private ?string $fieldPath = null,
		?callable $renderer = null,
		private ?TableColumnFormatEnum $format = null,
		private array $options = [],
	)
	{
		$this->renderer = $renderer;

		if (!$renderer && !$this->fieldPath) {
			throw new BadMethodCallException('Renderer or fieldPath must be set.');
		}
	}

	public function getCaption(): string
	{
		return $this->caption;
	}

	public function getFieldPath(): ?string
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
