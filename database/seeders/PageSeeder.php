<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		$pages=['Hakkımızda','Ekibimiz','Basında Biz'];
    		$count=0;
    		foreach($pages as $page){
    			$count++;
    			DB::table('pages')->insert([
        	'title'=>$page,
        	'slug'=>str::slug($page),
        	'image'=>'assets/webasset/images/Ekibimiz_large.jpg',
        	'content'=>'Gerçek ve tüzel kişilerin malvarlıklarının korunması, 
        	alacaklıların muhtemel haciz ve muhafaza talepleri karşısında hali 
        	hazırdaki hususun çözümü konusunda en uygun alternatiflerin belirlenmesi 
        	ile şirket faaliyetlerinin devamına engel olan unsurların geçici ve 
        	kesin olarak ortadan kaldırılabilmesi için yeniden yapılandırmanın tesis 
        	edilmesi gibi konulardaki işlemleri uzmanlık ve titizlikle doğrudan takip edip 
        	tatmin edici sonuçların alınmasını hedefleyen nitelikte hizmet sunmaktayız.',
        	'order'=>$count,
        	'created_at'=>now(),
        	'updated_at'=>now()
        ]);
    		}
    }
}
