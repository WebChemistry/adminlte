<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Component;

interface TableComponentFactory
{

	public function create(array $values, array $columns): TableComponent;

}
