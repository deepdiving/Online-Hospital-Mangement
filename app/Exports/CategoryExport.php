<?php

namespace App\Exports;

use App\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class CategoryExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $categories = Category::all();
        $data [] = ['id','name','slug','description'];

        foreach($categories as $cat){
            $data [] = [
                $cat->id,
                $cat->name,
                $cat->slug,
                $cat->description,
            ];
        }
        return $data;
    }
}
