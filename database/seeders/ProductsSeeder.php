<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Products;
//use Faker\Generator as Faker;
use Faker\Factory as Faker;
  
class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1,10) as $index) {
            Products::create([
                'name' => $faker->word,
                'price' => $faker->unique()->numberBetween(1000, 20000),
                'description' => $faker->text,
            ]);
        }
    }
}