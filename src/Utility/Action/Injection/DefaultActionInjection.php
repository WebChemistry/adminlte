<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action\Injection;

use Doctrine\ORM\EntityManagerInterface;
use WebChemistry\AdminLTE\Component\LineChartComponentFactory;
use WebChemistry\AdminLTE\Component\TableComponentFactory;

final class DefaultActionInjection
{

	public function __construct(
		private EntityManagerInterface $em,
		private TableComponentFactory $tableComponentFactory,
		private LineChartComponentFactory $lineChartComponentFactory,
	) {}

	public function getEntityManager(): EntityManagerInterface
	{
		return $this->em;
	}

	public function getTableComponentFactory(): TableComponentFactory
	{
		return $this->tableComponentFactory;
	}

	public function getLineChartComponentFactory(): LineChartComponentFactory
	{
		return $this->lineChartComponentFactory;
	}

}
