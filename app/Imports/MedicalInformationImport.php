<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\MedicalInformation;

class MedicalInformationImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $data)
    {
        foreach ($data as $key => $value) {
        	MedicalInformation::create($value->toArray());
        }
    }
}
