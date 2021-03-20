<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class HumanSeeder extends Seeder
{
    public function run()
    {
        // $data = [
        //     [
        //         'name'          => 'Ulrich Stren',
        //         'address'      => 'Jln. France GG.Gaming No.32',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now()
        //     ],
        //     [
        //         'name'          => 'Aelita Stone',
        //         'address'      => 'Jln. Partikulu No. 31',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now()
        //     ],
        //     [
        //         'name'          => 'Odd Della Robia',
        //         'address'      => 'Jln. Darmani GG.Aja No.30',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now()
        //     ]
        // ];

        // membuat faker
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'name'          => $faker->name,
                'address'      => $faker->address,
                'created_at' => Time::createFromTimestamp($faker->unixTime()),
                'updated_at' => Time::now()
            ];
            $this->db->table('human')->insert($data);            // hanya bisa satu data
        }

        // Simple Queries
        // $this->db->query("INSERT INTO human (name, address, created_at, updated_at) VALUES(:name:, :address:, :created_at:, :updated_at:)", $data);

        // Using Query Builder
        // $this->db->table('human')->insertBatch($data);   // untuk data yang banyak
    }
}
