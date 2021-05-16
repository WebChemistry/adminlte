<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\ValueObject;

use Nette\Application\UI\Form;

class SignInFormProvider
{

	public function __construct(
		private Form $form,
		private string $inputId,
		private string $inputPassword,
		private string $inputSubmit,
		private string $caption = 'Sign in to start your session',
	)
	{
	}

	public function getCaption(): string
	{
		return $this->caption;
	}

	public function getForm(): Form
	{
		return $this->form;
	}

	public function getInputId(): string
	{
		return $this->inputId;
	}

	public function getInputPassword(): string
	{
		return $this->inputPassword;
	}

	public function getInputSubmit(): string
	{
		return $this->inputSubmit;
	}

}
