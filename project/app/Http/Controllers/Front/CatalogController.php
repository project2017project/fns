<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Product;
use App\Models\Set;
use App\Models\Color;
use App\Models\Size;
use App\Models\Report;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CatalogController extends FrontBaseController
{
    // CATEGORIES SECTOPN

    public function categories()
    {
        return view('frontend.products');
    }

    // -------------------------------- CATEGORY SECTION ----------------------------------------

    public function category(Request $request, $slug = null, $slug1 = null, $slug2 = null, $slug3 = null)
    {
        if ($request->view_check) {
            session::put('view', $request->view_check);
        }

        //   dd(session::get('view'));

        $cat = null;
        $subcat = null;
        $childcat = null;
        $flash = null;
        $minprice = $request->min;
        $maxprice = $request->max;
        $sort = $request->sort;
        $search = $request->search;
        $pageby = $request->pageby;
        $minprice = ($minprice / $this->curr->value);
        $maxprice = ($maxprice / $this->curr->value);        
        $set = array();
        if(isset($request->set) && is_array($request->set) && count($request->set)>0)  $set = $request->set;
        $color = array();
        if(isset($request->color) && is_array($request->color) && count($request->color)>0)  $color = $request->color;
        $size = array();
        if(isset($request->size) && is_array($request->size) && count($request->size)>0)  $size = $request->size;
        $type = $request->has('type') ?? '';

        if (!empty($slug)) {
            $cat = Category::where('slug', $slug)->firstOrFail();
            $data['cat'] = $cat;
        }

        if (!empty($slug1)) {
            $subcat = Subcategory::where('slug', $slug1)->firstOrFail();
            $data['subcat'] = $subcat;
        }
        if (!empty($slug2)) {
            $childcat = Childcategory::where('slug', $slug2)->firstOrFail();
            $data['childcat'] = $childcat;
        }

        $data['latest_products'] = Product::with('user')->whereStatus(1)->whereLatest(1)
                                      ->home($this->language->id)
                                      ->get()
                                      ->reject(function ($item) {
                                          if ($item->user_id != 0) {
                                              if ($item->user->is_vendor != 2) {
                                                  return true;
                                              }
                                          }

                                          return false;
                                      });

        $prods = Product::when($cat, function ($query, $cat) {
            return $query->where('category_id', $cat->id);
        })
                                    ->when($subcat, function ($query, $subcat) {
                                        return $query->where('subcategory_id', $subcat->id);
                                    })
                                    ->when($type, function ($query, $type) {
                                        return $query->with('user')->whereStatus(1)->whereIsDiscount(1)
                                        ->where('discount_date', '>=', date('Y-m-d'))
                                        ->whereHas('user', function ($user) {
                                            $user->where('is_vendor', 2);
                                        });
                                    })
                                    ->when($childcat, function ($query, $childcat) {
                                        return $query->where('childcategory_id', $childcat->id);
                                    })
                                    ->when($search, function ($query, $search) {
                                        return $query->where('name', 'like', '%'.$search.'%')
                                                ->orWhere('name', 'like', $search.'%')
                                                ->orWhere('sku', 'like', '%'.$search.'%');
                                    })
                                    ->when($minprice, function ($query, $minprice) {
                                        return $query->where('price', '>=', $minprice);
                                    })
                                    ->when($maxprice, function ($query, $maxprice) {
                                        return $query->where('price', '<=', $maxprice);
                                    })
                                    ->when($set, function($query, $set) {
                                      if(is_array($set) && count($set)>0)
                                        return $query->whereIn('set_id',  $set);
                                  })
                                    ->when($color, function($query, $color) {
                                      if(is_array($color) && count($color)>0)
                                        return $query->whereIn('color_id',  $color);
                                  })
                                     ->when($size, function($query, $size) {
                                      if(is_array($size) && count($size)>0)
                                        return $query->whereIn('size_id',  $size);
                                  })
                                     ->when($sort, function ($query, $sort) {
                                         if ($sort == 'date_desc') {
                                             return $query->latest('id');
                                         } elseif ($sort == 'date_asc') {
                                             return $query->oldest('id');
                                         } elseif ($sort == 'price_desc') {
                                             return $query->latest('price');
                                         } elseif ($sort == 'price_asc') {
                                             return $query->oldest('price');
                                         }
                                     })
                                    ->when(empty($sort), function ($query, $sort) {
                                        return $query->latest('id');
                                    });

        $prods = $prods->where(function ($query) use ($cat, $subcat, $childcat, $request) {
            $flag = 0;
            if (!empty($cat)) {
                foreach ($cat->attributes as $key => $attribute) {
                    $inname = $attribute->input_name;
                    $chFilters = $request["$inname"];

                    if (!empty($chFilters)) {
                        $flag = 1;
                        foreach ($chFilters as $key => $chFilter) {
                            if ($key == 0) {
                                $query->where('attributes', 'like', '%"'.$chFilter.'"%');
                            } else {
                                $query->orWhere('attributes', 'like', '%"'.$chFilter.'"%');
                            }
                        }
                    }
                }
            }

            if (!empty($subcat)) {
                foreach ($subcat->attributes as $attribute) {
                    $inname = $attribute->input_name;
                    $chFilters = $request["$inname"];

                    if (!empty($chFilters)) {
                        $flag = 1;
                        foreach ($chFilters as $key => $chFilter) {
                            if ($key == 0 && $flag == 0) {
                                $query->where('attributes', 'like', '%"'.$chFilter.'"%');
                            } else {
                                $query->orWhere('attributes', 'like', '%"'.$chFilter.'"%');
                            }
                        }
                    }
                }
            }

            if (!empty($childcat)) {
                foreach ($childcat->attributes as $attribute) {
                    $inname = $attribute->input_name;
                    $chFilters = $request["$inname"];

                    if (!empty($chFilters)) {
                        $flag = 1;
                        foreach ($chFilters as $key => $chFilter) {
                            if ($key == 0 && $flag == 0) {
                                $query->where('attributes', 'like', '%"'.$chFilter.'"%');
                            } else {
                                $query->orWhere('attributes', 'like', '%"'.$chFilter.'"%');
                            }
                        }
                    }
                }
            }
        });

        $prods = $prods->where('language_id', $this->language->id)->where('status', 1)->get()
        ->reject(function ($item) {
            if ($item->user_id != 0) {
                if ($item->user->is_vendor != 2) {
                    return true;
                }
            }

            if (isset($_GET['max'])) {
                if ($item->vendorSizePrice() >= $_GET['max']) {
                    return true;
                }
            }

            return false;
        })->map(function ($item) {
            $item->price = $item->vendorSizePrice();

            return $item;
        })->paginate(isset($pageby) ? $pageby : $this->gs->page_count);
        $data['prods'] = $prods;
                                //    dd($data['prods']);
        if ($request->ajax()) {
            $data['ajax_check'] = 1;

            return view('frontend.ajax.category', $data);
        }

        return view('frontend.products', $data);
    }

    public function getsubs(Request $request)
    {
        $category = Category::where('slug', $request->category)->firstOrFail();
        $subcategories = Subcategory::where('category_id', $category->id)->get();

        return $subcategories;
    }

    public function report(Request $request)
    {
        // --- Validation Section
        $rules = [
               'note' => 'max:400',
                ];
        $customs = [
               'note.max' => 'Note Must Be Less Than 400 Characters.',
                   ];
        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }
        // --- Validation Section Ends

        // --- Logic Section
        $data = new Report();
        $input = $request->all();
        $data->fill($input)->save();
        // --- Logic Section Ends

        // --- Redirect Section
        $msg = 'New Data Added Successfully.';

        return response()->json($msg);
        // --- Redirect Section Ends
    }
}
