<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Subcategory;
use Carbon\Carbon;
use Datatables;
use Illuminate\Http\Request;

class CouponController extends AdminBaseController
{
    // *** JSON Request
    public function datatables()
    {
        $datas = Coupon::latest('id')->get();
        // --- Integrating This Collection Into Datatables
        return \Datatables::of($datas)
                           ->editColumn('type', function (Coupon $data) {
                               $type = $data->type == 0 ? 'Discount By Percentage' : 'Discount By Amount';

                               return $type;
                           })
                           ->editColumn('price', function (Coupon $data) {
                               $price = $data->type == 0 ? $data->price.'%' : \PriceHelper::showAdminCurrencyPrice($data->price * $this->curr->value);

                               return $price;
                           })
                           ->addColumn('status', function (Coupon $data) {
                               $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                               $s = $data->status == 1 ? 'selected' : '';
                               $ns = $data->status == 0 ? 'selected' : '';

                               return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'.route('admin-coupon-status', ['id1' => $data->id, 'id2' => 1]).'" '.$s.'>'.__('Activated').'</option><<option data-val="0" value="'.route('admin-coupon-status', ['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>'.__('Deactivated').'</option>/select></div>';
                           })
                           ->addColumn('action', function (Coupon $data) {
                               return '<div class="action-list"><a href="'.route('admin-coupon-edit', $data->id).'"> <i class="fas fa-edit"></i>'.__('Edit').'</a><a href="javascript:;" data-href="'.route('admin-coupon-delete', $data->id).'" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                           })
                           ->rawColumns(['status', 'action'])
                           ->toJson(); // --- Returning Json Data To Client Side
    }

    public function index()
    {
        return view('admin.coupon.index');
    }

    // *** GET Request
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $sub_categories = Subcategory::where('status', 1)->get();
        $child_categories = Childcategory::where('status', 1)->get();

        $products = Product::whereNotNull('sku')->where('status', 1)->select('id', 'sku')->get();

        return view('admin.coupon.create', compact('categories', 'sub_categories', 'child_categories', 'products'));
    }

    // *** POST Request
    public function store(Request $request)
    {
        // --- Validation Section
        $rules = ['code' => 'unique:coupons'];
        $customs = ['code.unique' => __('This code has already been taken.')];
        $validator = \Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }
        // --- Validation Section Ends

        // --- Logic Section
        $data = new Coupon();
        $input = $request->all();
        if ($request->coupon_type == 'category') {
            $input['sub_category'] = null;
            $input['child_category'] = null;
        } elseif ($request->coupon_type == 'sub_category') {
            $input['category'] = null;
            $input['child_category'] = null;
        } else {
            $input['category'] = null;
            $input['sub_category'] = null;
        }
        $input['product_sku_ids'] = null;

        if ($request->has('product_skus') && !empty($request->get('product_skus'))) {
            $input['product_sku_ids'] = implode(',', $request->get('product_skus'));
        }

        $input['excluded_category'] = null;
        $input['excluded_sub_category'] = null;
        $input['excluded_child_category'] = null;
        if ($request->get('is_included_excluded') == 'excluded') {
            if ($request->has('excluded_category') && !empty($request->get('excluded_category'))) {
                $input['excluded_category'] = implode(',', $request->get('excluded_category'));
            }

            if ($request->has('excluded_sub_category') && !empty($request->get('excluded_sub_category'))) {
                $input['excluded_sub_category'] = implode(',', $request->get('excluded_sub_category'));
            }

            if ($request->has('excluded_child_category') && !empty($request->get('excluded_child_category'))) {
                $input['excluded_child_category'] = implode(',', $request->get('excluded_child_category'));
            }
        }

        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d');
        $input['end_date'] = Carbon::parse($input['end_date'])->format('Y-m-d');
        $data->fill($input)->save();
        // --- Logic Section Ends

        // --- Redirect Section
        $msg = __('New Data Added Successfully.').'<a href="'.route('admin-coupon-index').'">'.__('View Coupon Lists').'</a>';

        return response()->json($msg);
        // --- Redirect Section Ends
    }

      // *** GET Request
      public function edit($id)
      {
          $categories = Category::where('status', 1)->get();
          $sub_categories = Subcategory::where('status', 1)->get();
          $child_categories = Childcategory::where('status', 1)->get();
          $products = Product::whereNotNull('sku')->where('status', 1)->select('id', 'sku')->get();
          $data = Coupon::findOrFail($id);

          return view('admin.coupon.edit', compact('data', 'categories', 'sub_categories', 'child_categories', 'products'));
      }

    // *** POST Request
    public function update(Request $request, $id)
    {
        // --- Validation Section

        $rules = ['code' => 'unique:coupons,code,'.$id];
        $customs = ['code.unique' => __('This code has already been taken.')];
        $validator = \Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }
        // --- Validation Section Ends

        // --- Logic Section
        $data = Coupon::findOrFail($id);
        $input = $request->all();
        if ($request->coupon_type == 'category') {
            $input['sub_category'] = null;
            $input['child_category'] = null;
        } elseif ($request->coupon_type == 'sub_category') {
            $input['category'] = null;
            $input['child_category'] = null;
        } else {
            $input['category'] = null;
            $input['sub_category'] = null;
        }

        $input['product_sku_ids'] = null;
        if ($request->has('product_skus') && !empty($request->get('product_skus'))) {
            $input['product_sku_ids'] = implode(',', $request->get('product_skus'));
        }

        $input['excluded_category'] = null;
        $input['excluded_sub_category'] = null;
        $input['excluded_child_category'] = null;
        if ($request->get('is_included_excluded') == 'excluded') {
            if ($request->has('excluded_category') && !empty($request->get('excluded_category'))) {
                $input['excluded_category'] = implode(',', $request->get('excluded_category'));
            }

            if ($request->has('excluded_sub_category') && !empty($request->get('excluded_sub_category'))) {
                $input['excluded_sub_category'] = implode(',', $request->get('excluded_sub_category'));
            }

            if ($request->has('excluded_child_category') && !empty($request->get('excluded_child_category'))) {
                $input['excluded_child_category'] = implode(',', $request->get('excluded_child_category'));
            }
        }

        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d');
        $input['end_date'] = Carbon::parse($input['end_date'])->format('Y-m-d');

        $data->update($input);
        // --- Logic Section Ends

        // --- Redirect Section
        $msg = __('Data Updated Successfully.').'<a href="'.route('admin-coupon-index').'">'.__('View Coupon Lists').'</a>';

        return response()->json($msg);
        // --- Redirect Section Ends
    }

      // *** GET Request Status
      public function status($id1, $id2)
      {
          $data = Coupon::findOrFail($id1);
          $data->status = $id2;
          $data->update();
          // --- Redirect Section
          $msg = __('Status Updated Successfully.');

          return response()->json($msg);
          // --- Redirect Section Ends
      }

    // *** GET Request Delete
    public function destroy($id)
    {
        $data = Coupon::findOrFail($id);
        $data->delete();
        // --- Redirect Section
        $msg = __('Data Deleted Successfully.');

        return response()->json($msg);
        // --- Redirect Section Ends
    }
}
