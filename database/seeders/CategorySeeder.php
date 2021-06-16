<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		$categories=['Eğlence','Bilişim','Gezi','Teknoloji','Sağlık','Spor','Günlük Yaşam'];
    		foreach($categories as $category){
    			DB::table('categories')->insert([
        	'name'=>$category,
        	'slug'=>str::slug($category),
        	'created_at'=>now(),
        	'updated_at'=>now()
        ]);
    		}
    }
}
