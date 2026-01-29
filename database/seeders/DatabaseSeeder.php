<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * @throws Throwable
     */
    public function run(): void
    {
        DB::transaction(function () {

            $classes = [
                '1st Grade',
                '2nd Grade',
                '3rd Grade',
            ];

            foreach ($classes as $className) {

                $classId = DB::table('classes')->insertGetId([
                    'name' => $className,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Sections para cada class
                $sections = ['A', 'B', 'C'];

                foreach ($sections as $sectionName) {

                    $sectionId = DB::table('sections')->insertGetId([
                        'class_id' => $classId,
                        'name' => $sectionName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Students para cada section
                    for ($i = 1; $i <= 10; $i++) {
                        DB::table('students')->insert([
                            'class_id' => $classId,
                            'section_id' => $sectionId,
                            'name' => "Student {$className}-{$sectionName}-{$i}",
                            'email' => Str::slug($className . '-' . $sectionName . '-' . $i) . '@school.test',
                            'active' => (boolean)rand(0, 1),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

        });
    }
}
