<?php

namespace Database\Seeders;

use App\Models\Bulan;
use App\Models\Metode;
use App\Models\Tahun;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Activity extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli'];
        $metode = [
            [
                'id_thn' => 1,
                'nm_metode' => 'Workshop/Self Learning',
            ],
            [
                'id_thn' => 1,
                'nm_metode' => 'Sharing Practice/Professionals Talk',
            ],
            [
                'id_thn' => 1,
                'nm_metode' => 'Discussion room',
            ],
            [
                'id_thn' => 1,
                'nm_metode' => 'Coaching',
            ],
            [
                'id_thn' => 1,
                'nm_metode' => 'Mentoring',
            ],
            [
                'id_thn' => 1,
                'nm_metode' => 'Job Assigment',
            ],
            [
                'id_thn' => 2,
                'nm_metode' => 'Metode 1',
            ],
            [
                'id_thn' => 2,
                'nm_metode' => 'Metode 2',
            ],
        ];
        $tahun = [
            [
                'nm_tahun' => 2022,
                'deskripsi' => 'Year 1',
            ], 
            [
                'nm_tahun' => 2023,
                'deskripsi' => 'Year 2',
            ]
        ];
        foreach($tahun as $row)
        {
            Tahun::create($row);
        }
        foreach($bulan as $row)
        {
            Bulan::create([
               'nm_bulan' => $row, 
            ]);
        }
        foreach($metode as $row)
        {
            Metode::create($row);
        }
        User::create([
            'name' => 'Faisol Gans',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin'),
        ]);

    }
}
