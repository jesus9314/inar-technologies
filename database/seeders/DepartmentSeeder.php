<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* `ubigeo_peru_inei_2016`.`ubigeo_peru_departments` */
        $ubigeo_peru_departments = array(
            array('id' => '01', 'name' => 'Amazonas', 'country_id' => '172'),
            array('id' => '02', 'name' => 'Áncash', 'country_id' => '172'),
            array('id' => '03', 'name' => 'Apurímac', 'country_id' => '172'),
            array('id' => '04', 'name' => 'Arequipa', 'country_id' => '172'),
            array('id' => '05', 'name' => 'Ayacucho', 'country_id' => '172'),
            array('id' => '06', 'name' => 'Cajamarca', 'country_id' => '172'),
            array('id' => '07', 'name' => 'Callao', 'country_id' => '172'),
            array('id' => '08', 'name' => 'Cusco', 'country_id' => '172'),
            array('id' => '09', 'name' => 'Huancavelica', 'country_id' => '172'),
            array('id' => '10', 'name' => 'Huánuco', 'country_id' => '172'),
            array('id' => '11', 'name' => 'Ica', 'country_id' => '172'),
            array('id' => '12', 'name' => 'Junín', 'country_id' => '172'),
            array('id' => '13', 'name' => 'La Libertad', 'country_id' => '172'),
            array('id' => '14', 'name' => 'Lambayeque', 'country_id' => '172'),
            array('id' => '15', 'name' => 'Lima', 'country_id' => '172'),
            array('id' => '16', 'name' => 'Loreto', 'country_id' => '172'),
            array('id' => '17', 'name' => 'Madre de Dios', 'country_id' => '172'),
            array('id' => '18', 'name' => 'Moquegua', 'country_id' => '172'),
            array('id' => '19', 'name' => 'Pasco', 'country_id' => '172'),
            array('id' => '20', 'name' => 'Piura', 'country_id' => '172'),
            array('id' => '21', 'name' => 'Puno', 'country_id' => '172'),
            array('id' => '22', 'name' => 'San Martín', 'country_id' => '172'),
            array('id' => '23', 'name' => 'Tacna', 'country_id' => '172'),
            array('id' => '24', 'name' => 'Tumbes', 'country_id' => '172'),
            array('id' => '25', 'name' => 'Ucayali', 'country_id' => '172')
        );

        foreach ($ubigeo_peru_departments as $department) {
            Department::create([
                'id' => $department['id'],
                'name' => $department['name'],
                'country_id' => $department['country_id'],
            ]);
        }
    }
}
