<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'price', 'times', 'start_date', 'end_date', 'coupon_type', 'category', 'sub_category', 'child_category', 'used_type', 'used_type_value', 'used_per_user', 'product_sku_ids', 'is_included_excluded', 'excluded_category', 'excluded_sub_category', 'excluded_child_category'];
    public $timestamps = false;
}
