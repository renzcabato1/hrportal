<?php

use Illuminate\Database\Seeder;

class ExecutiveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
			array("id" => "1912", "name" => "CHERYL MAY UYGONGCO CHUA","email" => "cherylmay.chua@lafilgroup.com", "password" => Hash::make("P@ssw0rd2017**")),
			array("id" => "1913", "name" => "AILEEN CHRISTEL UYGONGCO ONGKAUKO","email" => "aileenchristel.ongkauko@lafilgroup.com", "password" => Hash::make("P@ssw0rd2017**")),
			array("id" => "1914", "name" => "IRIS UYGONGCO PAMA","email" => "iris.pama@lafilgroup.com", "password" => Hash::make("P@ssw0rd2017**")),
			array("id" => "1915", "name" => "SU PENG ONGUY","email" => "supeng.uy@lafilgroup.com", "password" => Hash::make("P@ssw0rd2017**")),
			array("id" => "1916", "name" => "ALFONSO ANGUY ","email" => "alfonso.uy@lafilgroup.com", "password" => Hash::make("P@ssw0rd2017**")),
			array("id" => "1917", "name" => "FELIPE ANG UYGONGCO","email" => "felipe.uygongco@lafilgroup.com", "password" => Hash::make("P@ssw0rd2017**")),
			array("id" => "1918", "name" => "TERENCE SOON UYGONGCO","email" => "terence.uygongco@lafilgroup.com", "password" => Hash::make("P@ssw0rd2017**")),
			array("id" => "1919", "name" => "JULIANFELIPE SOON UYGONGCO","email" => "julianfelipe.uygongco@lafilgroup.com", "password" => Hash::make("P@ssw0rd2017**")),
			array("id" => "1920", "name" => "IAN KENNETH ONGUYGONGCO","email" => "iankenneth.uygongco@lafilgroup.com", "password" => Hash::make("P@ssw0rd2017**")),
			array("id" => "1921", "name" => "GERALD JONE ONGUYGONGCO","email" => "geraldjone.uygongco@lafilgroup.com", "password" => Hash::make("P@ssw0rd2017**")),
			array("id" => "1922", "name" => "ETHEL JOY UYGONGCO VALENCIA","email" => "etheljoy.valencia@lafilgroup.com", "password" => Hash::make("P@ssw0rd2017**")),
         ]);
    }
}
