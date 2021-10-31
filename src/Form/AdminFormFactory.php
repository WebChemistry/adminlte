<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Form;

use Nette\Application\UI\Form;
use Nette\Forms\Controls\Checkbox;
use Nette\Forms\Rendering\DefaultFormRenderer;
use Nette\Localization\Translator;

final class AdminFormFactory implements AdminFormFactoryInterface
{

	public function __construct(
		private ?Translator $translator = null,
	)
	{
	}

	public function create(): Form
	{
		$form = new Form();
		$form->setTranslator($this->translator);

		$this->makeBootstrap($form);

		return $form;
	}

	private function makeBootstrap(Form $form): void
	{
		$form->onRender[] = function (Form $form): void
		{
			/** @var DefaultFormRenderer $renderer */
			$renderer = $form->getRenderer();
			$renderer->wrappers['controls']['container'] = null;
			$renderer->wrappers['pair']['container'] = 'div class="form-group row"';
			$renderer->wrappers['pair']['.error'] = 'has-danger';
			$renderer->wrappers['control']['container'] = 'div class=col-sm-9';
			$renderer->wrappers['label']['container'] = 'div class="col-sm-3 col-form-label"';
			$renderer->wrappers['control']['description'] = 'span class=form-text';
			$renderer->wrappers['control']['errorcontainer'] = 'span class=form-control-feedback';
			$renderer->wrappers['control']['.error'] = 'is-invalid';

			foreach ($form->getControls() as $control) {
				$type = $control->getOption('type');
				if ($type === 'button') {
					$control->getControlPrototype()->addClass(
						empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-secondary'
					);
					$usedPrimary = true;
				} elseif (in_array($type, ['text', 'textarea', 'select'], true)) {
					$control->getControlPrototype()->addClass('form-control');
				} elseif ($type === 'file') {
					$control->getControlPrototype()->addClass('form-control-file');
				} elseif (in_array($type, ['checkbox', 'radio'], true)) {
					if ($control instanceof Checkbox) {
						$control->getLabelPrototype()->addClass('form-check-label');
					} else {
						$control->getItemLabelPrototype()->addClass('form-check-label');
					}

					$control->getControlPrototype()->addClass('form-check-input');
					$control->getContainerPrototype()->setName('div')->addClass('form-check');
				}
			}
		};
	}

}
