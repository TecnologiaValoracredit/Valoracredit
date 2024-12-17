<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ExcelImport implements ToCollection
{
	/**
	* @param Collection $collection
	*/
	public function collection(Collection $rows)
	{
		$result = [];
		foreach ($rows as $row) 
		{
			$result[] = (array) $row;
		}
		return $result;
	}
}