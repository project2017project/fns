<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setof extends Model
{
    public $table = 'sets';
    protected $fillable = ['name','slug','photo','is_featured','image','meta_title','meta_keyword','meta_description'];
    public $timestamps = false;

   
     public function products()
    {
		return $this->hasMany('App\Models\Product')->where('status', 1)->where('sum_stock','!=','');        
    }
	public function sproducts()
    {
		return $this->hasMany('App\Models\Product')->where('status', 1)->where('sal_status',1)->where('sum_stock','!=','');
        
    }
	public function bproducts()
    {
		return $this->hasMany('App\Models\Product')->where('status', 1)->where('minPrice','<',1000)->where('sum_stock','!=','');        
    }

   public function vproducts()
    {
		$slug='Anicha';
		$string = str_replace('-',' ', $slug);
        $vendor = User::where('shop_name','=',$string)->firstOrFail();		
		return $this->hasMany('App\Models\Product')->where('status', 1)->where('sum_stock','!=','');
    }

}
