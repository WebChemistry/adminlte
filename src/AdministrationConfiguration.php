<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE;

use JetBrains\PhpStorm\ExpectedValues;
use LogicException;
use Nette\Application\LinkGenerator;
use Nette\Application\UI\Link;
use Nette\Application\UI\Presenter;
use Nette\Http\IRequest;
use Nette\Utils\Html;
use WebChemistry\AdminLTE\ValueObject\Administrator;
use WebChemistry\AdminLTE\ValueObject\MenuLink;
use WebChemistry\AdminLTE\ValueObject\NavbarLink;
use WebChemistry\AdminLTE\ValueObject\SignInFormProvider;

abstract class AdministrationConfiguration
{

	private string $title = 'Administration';

	private Presenter $presenter;

	protected string $adminLteVersion = '3.1.0';

	protected string $bootstrapVersion = '4.6.0';

	protected string $jqueryVersion = '3.6.0';

	protected string $fontAwesomeVersion = '5.15.3';

	private array $extensions = [
		'chartJs' => false,
	];

	public function __construct(
		private IRequest $request,
		private LinkGenerator $linkGenerator,
	)
	{
	}

	public function attachPresenter(Presenter $presenter): void
	{
		$this->presenter = $presenter;
	}

	protected function link(string $destination, ...$params): Link|string
	{
		if (isset($this->presenter)) {
			return $this->presenter->lazyLink($destination, $params);
		}

		if (str_starts_with($destination, ':')) {
			$destination = substr($destination, 1);
		}

		return $this->linkGenerator->link($destination, $params);
	}

	public function getFavicon(): ?Html
	{
		return Html::el('link')
			->rel('icon')
			->href('/favicon.ico');
	}

	abstract public function getLoginLink(): string|Link;

	abstract public function getSignInFormProvider(): SignInFormProvider;

	abstract public function getAdministrationHomepage(): string|Link;

	/**
	 * @return NavbarLink[]
	 */
	public function getNavbarLinks(): array
	{
		return [];
	}

	/**
	 * @return MenuLink[]
	 */
	public function getMenuLinks(): array
	{
		return [];
	}

	public function getCurrentAdministrator(): ?Administrator
	{
		return null;
	}

	public function getLogoName(): string
	{
		return 'Administration';
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function getHomepageLink(): string
	{
		return $this->request->getUrl()->getBasePath();
	}

	/**
	 * @return string[]
	 */
	public function getJavascript(): array
	{
		$array = [
			sprintf('https://cdn.jsdelivr.net/npm/jquery@%s/dist/jquery.min.js', $this->jqueryVersion),
			sprintf('https://cdn.jsdelivr.net/npm/bootstrap@%s/dist/js/bootstrap.bundle.min.js', $this->bootstrapVersion),
			sprintf('https://cdn.jsdelivr.net/npm/admin-lte@%s/dist/js/adminlte.min.js', $this->adminLteVersion),
		];

		if ($this->extensions['chartJs']) {
			$array[] = 'https://cdn.jsdelivr.net/npm/chart.js';
		}

		return $array;
	}

	/**
	 * @return string[]
	 */
	public function getStylesheet(): array
	{
		return [
			'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback',
			sprintf('https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@%s/css/all.min.css', $this->fontAwesomeVersion),
			sprintf('https://cdn.jsdelivr.net/npm/admin-lte@%s/dist/css/adminlte.min.css', $this->adminLteVersion),
		];
	}

	public function enableExtension(
		#[ExpectedValues(['chartJs'])]
		string $name,
	): void
	{
		if (!isset($this->extensions[$name])) {
			throw new LogicException(sprintf('Admin extension %s not exists.', $name));
		}
		
		$this->extensions[$name] = true;
	}

	public function disableExtension(
		#[ExpectedValues(['chartJs'])]
		string $name,
	): void
	{
		if (!isset($this->extensions[$name])) {
			throw new LogicException(sprintf('Admin extension %s not exists.', $name));
		}

		$this->extensions[$name] = false;
	}

}
