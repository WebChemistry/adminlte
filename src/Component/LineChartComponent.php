<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Component;

use Nette\Application\UI\Control;

final class LineChartComponent extends Control
{

	private array $data = [];

	private array $dataset = [];

	private array $options = [
		'interaction' => [
			'intersect' => false,
			'axis' => 'x',
		],
		'responsive' => true,
		'maintainAspectRatio' => false,
		'plugins' => [
			'legend' => [
				'display' => false,
			],
			'tooltip' => [
				'displayColors' => false,
			],
		],
		'scales' => [
			'x' => [
				'grid' => [
					'borderDash' => [8, 4],
				],
				'ticks' => [
					'color' => '#888888',
				],
			],
			'y' => [
				'grid' => [
					'borderDash' => [8, 4],
				],
				'ticks' => [
					'color' => '#888888',
					'precision' => 0,
				],
			],
		],
	];

	private array $backgroundColor = [63, 103, 145, 1];

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
		$template->gradient = $this->toRGBA($this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2], 0.2);
		$template->config = [
			'type' => 'line',
			'data' => $data,
			'options' => $this->processOptions($this->options),
		];

		$template->render();
	}

	public function setBackgroundColor(int $red, int $green, int $blue, int $opacity = 1): void
	{
		$this->backgroundColor = [$red, $green, $blue, $opacity];
	}

	private function toRGBA(int $red, int $green, int $blue, float $opacity = 1): string
	{
		return sprintf('rgba(%d,%d,%d,%s)', $red, $green, $blue, number_format($opacity, 1));
	}

	private function processDataset(array $dataset): array
	{
		$dataset['label'] ??= 'Value';
		$dataset['backgroundColor'] = $this->toRGBA(...$this->backgroundColor);
		$dataset['borderColor'] ??= $this->toRGBA(...$this->backgroundColor);
		$dataset['tension'] ??= 0.4;
		$dataset['borderWidth'] ??= 2;
		$dataset['pointRadius'] ??= 0;

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
