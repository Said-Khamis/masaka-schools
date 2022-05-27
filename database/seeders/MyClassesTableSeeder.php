<?php
namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MyClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('my_classes')->delete();
        $ct = ClassType::pluck('id')->all();

        $data = [
            ['name' => 'Standard 1', 'class_type_id' => $ct[2]],
            ['name' => 'Standard 2', 'class_type_id' => $ct[2]],
            ['name' => 'Standard 3', 'class_type_id' => $ct[2]],
            ['name' => 'Standard 4', 'class_type_id' => $ct[3]],
            ['name' => 'Standard 5', 'class_type_id' => $ct[3]],
            ['name' => 'Standard 6', 'class_type_id' => $ct[4]],
            ['name' => 'Standard 7', 'class_type_id' => $ct[4]],
            ];

        DB::table('my_classes')->insert($data);

    }
}
