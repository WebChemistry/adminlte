<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Component;

use Nette\Application\UI\Control;

final class LineChartComponent extends Control
{

	private array $data = [];

	private array $dataset = [];

	private array $options = [
		'plugins' => [
			'legend' => [
				'display' => false,
			],
		],
	];

	private ?int $height = null;

	public function __construct(
		array $labels,
		array $values,
	)
	{
		$this->data['labels'] = $labels;
		$this->dataset['data'] = $values;
	}

	public function setHeight(?int $height): self
	{
		$this->height = $height;

		return $this;
	}

	public function render(): void {
		$template = $this->getTemplate();
		$template->setFile(__DIR__ . '/templates/lineChart.latte');

		$data = $this->data;

		$data['datasets'][] = $this->processDataset($this->dataset);

		$template->id = $this->getUniqueId();
		$template->height = $this->height;
		$template->config = [
			'type' => 'line',
			'data' => $data,
			'options' => $this->processOptions($this->options),
		];

		$template->render();
	}

	private function processDataset(array $dataset): array
	{
		$dataset['label'] ??= 'Chart';
		$dataset['backgroundColor'] ??= 'rgb(63,103,145)';
		$dataset['borderColor'] ??= 'rgb(63,103,145)';

		return $dataset;
	}

	private function processOptions(array $options): array
	{
		if ($this->height) {
			$options['maintainAspectRatio'] = false;
		}

		return $options;
	}

}
