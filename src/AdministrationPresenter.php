<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE;

use InvalidArgumentException;
use Nette\Application\UI\Link;
use Nette\Application\UI\Template;
use Nette\Bridges\ApplicationLatte\DefaultTemplate;

trait AdministrationPresenter
{

	private AdministrationConfiguration $configuration;

	private array $embedAliases = [
		'box' => __DIR__ . '/templates/box.latte',
		'infoBox' => __DIR__ . '/templates/info.box.latte',
		'infoBoxContainer' => __DIR__ . '/templates/info.box.container.latte',
	];

	final public function getConfiguration(): AdministrationConfiguration
	{
		return $this->configuration;
	}

	final public function injectAdminPresenter(
		AdministrationConfiguration $configuration,
	): void
	{
		$this->configuration = $configuration;
		$this->configuration->attachPresenter($this);

		$this->onStartup[] = function (): void {
			if (!$this->configuration->getCurrentAdministrator()) {
				$link = $this->configuration->getLoginLink();
				if ($link instanceof Link) {
					$link->setParameter('backlink', $this->link('this'));
				}

				$this->redirectUrl((string) $link);
			} elseif (!$this->configuration->getCurrentAdministrator()->isAdministrator()) {
				$this->error('Current user is not an administrator.');
			}
		};
	}

	public function formatLayoutTemplateFiles(): array {
		$list = parent::formatLayoutTemplateFiles();
		$list[] = $this->getBaseLayout();

		return $list;
	}

	protected function getBaseLayout(): string {
		return __DIR__ . '/templates/@layout.latte';
	}

	protected function createTemplate(?string $class = null): Template
	{
		/** @var DefaultTemplate $template */
		$template = parent::createTemplate($class);
		$template->config = $this->configuration;

		$template->embed = function (string $alias): string {
			return $this->embedAliases[$alias] ?? throw new InvalidArgumentException(
					sprintf('Embed alias %s not exists.', $alias)
				);
		};

		return $template;
	}

}
