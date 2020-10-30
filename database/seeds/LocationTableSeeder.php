<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('locations')->insert([
          array('name'=>'AKLAN' ),
          array('name'=>'AURORA'),
          array('name'=>'BACOLOD'),
          array('name'=>'BATAAN'),
          array('name'=>'BENGUET'),
          array('name'=>'BUKIDNON'),
          array('name'=>'BULACAN'),
          array('name'=>'CEBU'),
          array('name'=>'COTABATO'),
          array('name'=>'DAVAO'),
          array('name'=>'DUMAGUETE'),
          array('name'=>'ILOILO'),
          array('name'=>'ISABELA'),
          array('name'=>'MANILA'),
          array('name'=>'MINDANAO'),
          array('name'=>'MISAMIS ORIENTAL'),
          array('name'=>'NEGROS'),
          array('name'=>'NORTH LUZON'),
          array('name'=>'ROXAS'),
          array('name'=>'SULTAN KUDARAT'),
          array('name'=>'TACLOBAN')
        ]);
    }
}
