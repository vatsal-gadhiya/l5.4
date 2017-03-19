<?php

use Illuminate\Database\Seeder;

class HolidaySubScriberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\HolidaySubscriber::class, 100)->create();
    }
}
