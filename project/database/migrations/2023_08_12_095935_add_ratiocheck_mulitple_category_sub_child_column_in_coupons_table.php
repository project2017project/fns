<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatiocheckMulitpleCategorySubChildColumnInCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->string('product_sku_ids')->nullable();
            $table->string('is_included_excluded')->default('included');
            $table->string('excluded_category')->nullable();
            $table->string('excluded_sub_category')->nullable();
            $table->string('excluded_child_category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['product_sku_ids', 'is_included_excluded', 'excluded_category', 'excluded_sub_category', 'excluded_child_category']);
        });
    }
}
