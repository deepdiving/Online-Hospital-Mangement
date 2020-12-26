<?php

use Illuminate\Database\Seeder;

class PreMedicinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Tab. Almex (400 mg)','Tab-Calbo','Carva','B 50 Forte','Cap. Moxacil (250 mg)','Drop-Lebac','Drop Moxacil Peadiativ','Tab. Cardipro 50 mg','Cap. Cef-3 (400 mg)','Tab. Cotrim (480 mg)','Susp. Cotrim (60 mg)','Calbo-D','Cap.Doxacil (100 mg)','Nexum (20 mg)','Nexum (40 mg)','Filwel Gold','Tab Zimax (500 mg)','Sup Zimax (15 ml)','Sup Zimax (30 ml)','A Fan Cream','Tab. Amodis (400 mg)','Multivit Plus','Cap.Seclo 20 mg','Tab Anril SR','Phylopen Fotre','Flurigin','Tab. Ace (500mg)','Syp. Ace (60 ml)','Syp. Ace Padiatic','Zifolet','Loratin 10 mg','Neotack','Ceevit','Zif-CI','Zif- Forte','Tab Cerevas 5 mg','Cap-Maxrin 0.4 mg','Tab-Rasuva 5 mg','Syp-Becozine I','Syp- Alarid','Tab-Triptin-10 mg','Tab-Marison 6mg','Tab-Zimax 250mg','Syp-Levoster 50mg','Tab-Famotack 50mg','Tab-Angilock plus','Tab-Rasuva 10 mg','Syp-Fenadin','Maxpro 20 mg','Becosule Gold','Calcin-D 500 mg','Tab-Gestronal','Levoking 500 mg','Zithtim ','Cap. Lucan-R (150mg)','Orcef 400mg','Normens','Tab-Ceclofen','Tab-Domerin','Tab-Zithrin 500 mg','Tab Algin','Tab-Calcin','Tab-Ferix','Tab-Totifen','Cap-Frerix'];
        $data = [];
        $i = 0;
        $j = 1;
        foreach($names as $name){
            $data[] = [
                'name'       => $name, 
                'pre_medicine_type_id' => $j,        
                'status'     => 'Active',          
                'user_id'    => '5',
                'created_at' => now(),
                'updated_at' => now()  
            ];
            $i++;
            if($i == 10){
                $j++;
                $i=0;
            }
        }
        
        DB::table('pre_medicines')->insert($data);
  
    }
}
