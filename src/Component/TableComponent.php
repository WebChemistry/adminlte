<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Component;

use Nette\Application\UI\Control;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

final class TableComponent extends Control
{

	public function __construct(
		private array $values,
		private array $columns,
		private array $headers,
		private ?PropertyAccessorInterface $propertyAccessor = null,
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
		$template->headers = $this->headers;

		$template->render();
	}

	private function getProperties(mixed $value): array
	{
		$values = [];
		foreach ($this->columns as $column => $callback) {
			if (is_numeric($column)) {
				$column = $callback;
				$callback = null;
			}

			$val = $this->propertyAccessor->getValue($value, $column);

			if ($callback !== null) {
				$val = $callback($val, $value);
			}

			$values[] = $val;
		}

		return $values;
	}

}
