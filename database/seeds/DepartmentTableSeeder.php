<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('departments')->insert([
          array('name'=>'ACCOUNTING' ),
          array('name'=>'ADMINISTRATION'),
          array('name'=>'AUDIT' ),
          array('name'=>'BANQUET' ),
          array('name'=>'BILLING AND COLLECTION'),
          array('name'=>'BOILER'),
          array('name'=>'BRANCH OFFICER DEPARTMENT'),
          array('name'=>'BUDGET'),
          array('name'=>'CANE MARKETING'),
          array('name'=>'CANEHAULING'),
          array('name'=>'ENGINEERING'),
          array('name'=>'EXTENSION&GOVA'),
          array('name'=>'FARM'),
          array('name'=>'FEEDMILL'),
          array('name'=>'FINANCE'),
          array('name'=>'FINISH PRODUCT'),
          array('name'=>'FLOURMILL' ),
          array('name'=>'FRONTOFFICE' ),
          array('name'=>'HOUSEKEEPING' ),
          array('name'=>'HRD' ),
          array('name'=>'LEGAL' ),
          array('name'=>'LOGISTICS' ),
          array('name'=>'MACHINESHOP' ),
          array('name'=>'MANAGEMENTINFO' ),
          array('name'=>'MARKETING' ),
          array('name'=>'MATERIAL MANAGEMENT' ),
          array('name'=>'MILL' ),
          array('name'=>'MIS' ),
          array('name'=>'MVAMIGOI'),
          array('name'=>'MVAMIGOII'),
          array('name'=>'MVDARUMAUNO'),
          array('name'=>'MVFOREMOSTTRADER'),
          array('name'=>'OFFICE MINIMUM'),
          array('name'=>'OFFICE OF THE FACTORY'),
          array('name'=>'OFICE OF THE PRESIDENT'),
          array('name'=>'OFFICE REGULAR'),
          array('name'=>'OPERATIONS'),
          array('name'=>'PACKING'),
          array('name'=>'POLLUTION CONTROL'),
          array('name'=>'PROCESSING'),
          array('name'=>'PRODUCTION'),
          array('name'=>'PURCHASING'),
          array('name'=>'QA'),
          array('name'=>'R&D'),
          array('name'=>'RADIO ROOM'),
          array('name'=>'REALTY'),
          array('name'=>'ROADTRANSPORT'),
          array('name'=>'SALES'),
          array('name'=>'SALES AND DISTRIBUTION'),
          array('name'=>'SALES AND MARKETING'),
          array('name'=>'SHIPPING'),
          array('name'=>'SPECIAL PROJECT GROUP'),
          array('name'=>'TAX'),
          array('name'=>'TQMD'),
          array('name'=>'TRADE'),
          array('name'=>'TRADE COMMODITIES'),
          array('name'=>'TRADE FERTILIZER'),
          array('name'=>'TRADE FLOUR'),
          array('name'=>'TRADE MARKETING'),
          array('name'=>'TRADE SALES'),
          array('name'=>'TREASURY'),
          array('name'=>'TRUCKING'),
          array('name'=>'VESSEL'),
          array('name'=>'WAREHOUSE')
        ]);
    }
}
