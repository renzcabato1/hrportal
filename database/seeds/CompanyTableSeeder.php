<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
          array('name'=>'AAIDC', 'domain' => 'amigoagro.com'),
          array('name'=>'AAPC', 'domain' => 'advancedagrisolutionsphil.com'),
          array('name'=>'ALC', 'domain' => 'amigologisticscorp.com'),
          array('name'=>'ASC', 'domain' => 'lafilgroup.net'),
          array('name'=>'ATH', 'domain' => 'amigoterracehotel.com'),
          array('name'=>'CAFC', 'domain' => 'lafilgroup.net'),
          array('name'=>'CSCI', 'domain' => 'lafilgroup.net'),
          array('name'=>'DTSI', 'domain' => 'lafilgroup.net'),
          array('name'=>'EFC', 'domain' => 'excelfarmcorp.com'),
          array('name'=>'GLOBAL', 'domain' => 'lafilgroup.com'),
          array('name'=>'IGCC', 'domain' => 'lafilgroup.net'),
          array('name'=>'LF MEATS', 'domain' => 'lafilipinauygongco.com'),
          array('name'=>'LFUG', 'domain' => 'lafilipinauygongco.com'),
          array('name'=>'MGC', 'domain' => 'marivelesgrains.com'),
          array('name'=>'MGCPI', 'domain' => 'mindanaograins.com'),
          array('name'=>'MTCPI', 'domain' => 'mamatinapasta.com'),
          array('name'=>'PFMC' , 'domain' => 'philippineforemost.com'),
          array('name'=>'PLILI', 'domain' => 'philleadinginfinite.com'),
          array('name'=>'RAFC', 'domain' => 'lafilgroup.net'),
          array('name'=>'SWEETTREATS', 'domain' => 'lafilgroup.net')
        ]);
    }
}
