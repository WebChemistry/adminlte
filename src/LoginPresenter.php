<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE;

use Nette\Application\UI\Form;

trait LoginPresenter
{

	private AdministrationConfiguration $configuration;

	final public function injectAdminPresenter(
		AdministrationConfiguration $configuration,
	): void
	{
		$this->configuration = $configuration;
		$this->configuration->attachPresenter($this);

		$this->onStartup[] = function (): void {
			if ($this->configuration->getCurrentAdministrator()) {
				$this->redirectUrl((string) $this->configuration->getAdministrationHomepage());
			}
		};
	}

	private function prepareLogin(): void
	{
		$template = $this->getTemplate();
		$template->setFile(__DIR__ . '/templates/@layout.login.latte');

		$template->config = $this->configuration;
	}

	public function actionOut(): void {
		if ($this->getUser()->isLoggedIn()) {
			$this->getUser()->logout();
		}

		$this->redirectUrl((string) $this->configuration->getLoginLink());
	}

	protected function createComponentLoginForm(): Form
	{
		$form = $this->configuration->getSignInFormProvider()->getForm();

		$form->addHidden('backlink', $this->getParameter('backlink'));

		$form->onSuccess[] = function (Form $form, array $values): void {
			if ($values['backlink']) {
				$this->redirectUrl($values['backlink']);
			}

			$this->redirectUrl((string) $this->configuration->getAdministrationHomepage());
		};

		return $form;
	}

}
