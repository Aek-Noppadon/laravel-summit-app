<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            array(
                [
                    'name' => 'Noppadon',
                    'last_name' => 'Bumrerchao',
                    'sales_id' => null,
                    'employee_id' => null,
                    'department_id' => null,
                    'email ' => 'noppadon.b@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Mintra',
                    'last_name' => 'Sukkeha',
                    'sales_id' => '320',
                    'employee_id' => null,
                    'department_id' => 1,
                    'email ' => 'mintra@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Tawatchai',
                    'last_name' => 'Siriprapaiwan',
                    'sales_id' => '323',
                    'employee_id' => null,
                    'department_id' => 1,
                    'email ' => 'tawatchai@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Piratchaporn',
                    'last_name' => 'Wanwin',
                    'sales_id' => '326',
                    'employee_id' => null,
                    'department_id' => 1,
                    'email ' => 'piratchaporn@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Mattanavadee',
                    'last_name' => 'Ponsrinual',
                    'sales_id' => '327',
                    'employee_id' => null,
                    'department_id' => 1,
                    'email ' => 'mattanavadee@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Samitanan',
                    'last_name' => 'Booncharoen',
                    'sales_id' => '328',
                    'employee_id' => null,
                    'department_id' => 1,
                    'email ' => 'samitanan@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Natthawadee',
                    'last_name' => 'Kijsaengthong',
                    'sales_id' => '330',
                    'employee_id' => null,
                    'department_id' => 1,
                    'email ' => 'natthawadee.k@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Panuwat',
                    'last_name' => 'Chomchuen',
                    'sales_id' => '331',
                    'employee_id' => null,
                    'department_id' => 1,
                    'email ' => 'panuwat.c@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Chanapa',
                    'last_name' => 'Kanokwattananon',
                    'sales_id' => '335',
                    'employee_id' => null,
                    'department_id' => 1,
                    'email ' => 'chanapa.k@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Phuwanai',
                    'last_name' => 'Thanomngam',
                    'sales_id' => '312',
                    'employee_id' => null,
                    'department_id' => 2,
                    'email ' => 'phuwanai@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Pattarawan',
                    'last_name' => 'Wuttisan',
                    'sales_id' => '321',
                    'employee_id' => null,
                    'department_id' => 2,
                    'email ' => 'pattarawan@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Supanat',
                    'last_name' => 'Puaraksa',
                    'sales_id' => '344',
                    'employee_id' => null,
                    'department_id' => 2,
                    'email ' => 'supanat.p@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Kanchana',
                    'last_name' => 'Songsilawat',
                    'sales_id' => '307',
                    'employee_id' => null,
                    'department_id' => 3,
                    'email ' => 'kanchana@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Worapat',
                    'last_name' => 'Phuenglamai',
                    'sales_id' => '322',
                    'employee_id' => null,
                    'department_id' => 3,
                    'email ' => 'worapat@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Krittaya',
                    'last_name' => 'Pasuriyan',
                    'sales_id' => '324',
                    'employee_id' => null,
                    'department_id' => 3,
                    'email ' => 'krittaya@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Srikanya',
                    'last_name' => 'Thongyai',
                    'sales_id' => '332',
                    'employee_id' => null,
                    'department_id' => 3,
                    'email ' => 'srikanya.t@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Harisa',
                    'last_name' => 'Hayee-uma',
                    'sales_id' => '341',
                    'employee_id' => null,
                    'department_id' => 3,
                    'email ' => 'harisa.h@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Samitanan',
                    'last_name' => 'Booncharoen',
                    'sales_id' => '336',
                    'employee_id' => null,
                    'department_id' => 4,
                    'email ' => 'samitanan.ni@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Sorawis',
                    'last_name' => 'Chirachanchai',
                    'sales_id' => '339',
                    'employee_id' => null,
                    'department_id' => 4,
                    'email ' => 'sorawis.c@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
                [
                    'name' => 'Pimwadee',
                    'last_name' => 'Kaewnukul',
                    'sales_id' => '340',
                    'employee_id' => null,
                    'department_id' => 4,
                    'email ' => 'pimwadee.k@smchemical.com',
                    'password ' => Hash::make('12345678'),
                ],
            )
        );
    }
}
