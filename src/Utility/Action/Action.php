<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action;

use Nette\Application\UI\ITemplate;
use Nette\Application\UI\Presenter;

abstract class Action
{

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

}
