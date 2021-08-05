<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action;

use LogicException;
use Nette\Application\IPresenter;
use Nette\Application\UI\ITemplate;
use Nette\Application\UI\Presenter;
use WebChemistry\AdminLTE\AdministrationConfiguration;

abstract class Action
{

	/** @var array<string, bool> */
	private array $enabledExtensions = [];

	abstract public function run(): void;

	protected function createTemplate(Presenter $presenter, string $templateFile): ITemplate
	{
		$template = $presenter->getTemplate();

		$original = null;
		foreach ($presenter->formatTemplateFiles() as $source) {
			if (file_exists($source)) {
				$original = $source;
			}
		}

		if ($original) {
			$template->parent = $templateFile;
			$template->setFile($original);
		} else {
			$template->setFile($templateFile);
		}

		$template->embedPath = __DIR__ . '/../../templates/';

		return $template;
	}

	protected function enableExtension(IPresenter $presenter, string $name): void
	{
		if (isset($this->enabledExtensions[$name])) {
			return;
		}
		
		if (!method_exists($presenter, 'getConfiguration')) {
			throw new LogicException(sprintf('Cannot enable admin extensions %s in %s.', $name, $presenter::class));
		}

		$configuration = $presenter->getConfiguration();
		if (!$configuration instanceof AdministrationConfiguration) {
			throw new LogicException(
				sprintf(
					'Configuration returned from %s must be instance of %s.',
					$presenter::class,
					AdministrationConfiguration::class
				)
			);
		}

		$configuration->enableExtension($name);
	}

}
