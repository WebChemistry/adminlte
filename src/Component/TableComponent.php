<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Component;

use DateTimeInterface;
use LogicException;
use Nette\Application\UI\Control;
use Nette\Utils\Html;
use Nette\Utils\Strings;
use Nette\Utils\Validators;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use WebChemistry\AdminLTE\Utility\Action\Objects\Enums\TableColumnFormatEnum;
use WebChemistry\AdminLTE\Utility\Action\Objects\TableColumn;

final class TableComponent extends Control
{

	private PropertyAccessorInterface $propertyAccessor;

	/**
	 * @param TableColumn[] $columns
	 * @param mixed[] $options
	 */
	public function __construct(
		private array $values,
		private array $columns,
		?PropertyAccessorInterface $propertyAccessor = null,
	)
	{
		$this->propertyAccessor ??= PropertyAccess::createPropertyAccessor();
	}

	public function render(): void {
		$template = $this->getTemplate();
		$template->setFile(__DIR__ . '/templates/table.latte');

		$template->values = array_map(
			fn (mixed $value) => $this->getProperties($value),
			$this->values,
		);
		$template->headers = array_map(
			fn (TableColumn $column) => $column->getCaption(),
			$this->columns,
		);

		$template->render();
	}

	private function getProperties(mixed $value): array
	{
		$values = [];
		foreach ($this->columns as $column) {
			$val = $this->propertyAccessor->getValue($value, $column->getFieldPath());

			if (($renderer = $column->getRenderer()) !== null) {
				$val = $renderer($val, $value);
			}

			if ($format = $column->getFormat()) {
				$val = $this->formatValue($val, $column, $format);
			}

			$values[] = $val;
		}

		return $values;
	}

	private function formatValue(mixed $val, TableColumn $column, TableColumnFormatEnum $enum): mixed
	{
		$enumValue = $enum->getValue();
		if ($enumValue === 'datetime' || $enumValue === 'date') {
			Validators::assert($val, DateTimeInterface::class . '|null');

			return $val ? $val->format($enumValue === 'datetime' ? 'Y-m-d H:i:s' : 'Y-m-d') : '';
		}

		if ($enumValue === 'html_to_text') {
			Validators::assert($val, 'string|null');

			return Strings::truncate(strip_tags((string) $val), 250);
		}

		if ($enumValue === 'link') {
			Validators::assert($val, 'string|null');

			if (!$val) {
				return '';
			}

			$val = (string) $val;

			return Html::el('a')
				->target('_blank')
				->href($val)
				->setText($column->getOptions()['text'] ?? $val)
				->setAttribute('class', $column->getOptions()['class'] ?? '');
		}

		if ($enumValue === 'link_btn') {
			Validators::assert($val, 'string|null');

			if (!$val) {
				return '';
			}

			$val = (string) $val;

			return Html::el('a')
				->target('_blank')
				->href($val)
				->setText($column->getOptions()['text'] ?? 'Detail')
				->setAttribute('class', 'btn btn-xs btn-primary');
		}

		return $val;
	}

}
