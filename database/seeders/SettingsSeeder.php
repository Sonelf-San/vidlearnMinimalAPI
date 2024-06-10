<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        settings()->set([
            'app_name' => 'ERICAE',

            'contact_email'     => 'admin@ericaelab.ca',
            'contact_phone'     => '+1 (418) 656-2131',
            'post'              => '2789',
            'address'           => '1065 Av. de la Médecine, Québec, QC',
            'zip_code'          => 'G1V 0A6',
            'local'             => 'PLT 3901'
        ]);
    }
}
