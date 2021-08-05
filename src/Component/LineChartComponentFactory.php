<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Component;

interface LineChartComponentFactory
{

	public function create(array $labels, array $values): LineChartComponent;
	
}
