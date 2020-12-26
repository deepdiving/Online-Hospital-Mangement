<?php

use Illuminate\Database\Seeder;
use App\Batch;
class BatchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Pharma\Batch::class,100)->create();
    }
}
