<div class="col-xl-3">
    <div id="sidebar" class="widget-title-bordered-full">
        <div class="dashbaord-sidebar-close d-xl-none">
    <i class="fas fa-times"></i>
  </div>
        <form id="catalogForm" action="{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}" method="GET">

        <div id="woocommerce_product_categories-4" class="widget woocommerce widget_product_categories widget-toggle">
            <h2 class="widget-title">{{ __('Product categories') }}</h2>
            <ul class="product-categories">
                @foreach (App\Models\Category::where('language_id',$langg->id)->where('status',1)->get() as $category)

                <li class="cat-item cat-parent">
                    <a href="{{route('front.category', $category->slug)}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="category-link" id="cat">{{ $category->name }} <span class="count"></span></a>

                    @if($category->subs->count() > 0)
                        <span class="has-child"></span>
                        <ul class="children">
                            @foreach (App\Models\Subcategory::where('category_id',$category->id)->get() as $subcategory)
                            <li class="cat-item cat-parent">
                                <a href="{{route('front.category', [$category->slug, $subcategory->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="category-link {{ isset($subcat) ? ($subcat->id == $subcategory->id ? 'active' : '') : '' }}">{{$subcategory->name}} <span class="count"></span></a>


                                @if($subcategory->childs->count()!=0)
                                    <span class="has-child"></span>
                                    <ul class="children">
                                        @foreach (DB::table('childcategories')->where('subcategory_id',$subcategory->id)->get() as $key => $childelement)
                                        <li class="cat-item ">
                                            <a href="{{route('front.category', [$category->slug, $subcategory->slug, $childelement->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="category-link {{ isset($childcat) ? ($childcat->id == $childelement->id ? 'active' : '') : '' }}"> {{$childelement->name}} <span class="count"></span></a>
                                        </li>
                                        @endforeach
                                    </ul>

                                @endif
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>

        <div id="bigbazar-price-filter-list-1" class="widget bigbazar_widget_price_filter_list widget_layered_nav widget-toggle mx-3">
            <h2 class="widget-title">{{ __('Filter by Price') }}</h2>
            <ul class="price-filter-list">
                <div class="price-range-block">
                    <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
                    <div class="livecount">
                        <input type="number" name="min"  oninput="" id="min_price" class="price-range-field" />
                        <span>
                            {{ __('To') }}
                        </span>
                        <input type="number" name="max"  oninput="" id="max_price" class="price-range-field" />
                    </div>
                </div>

                <button class="filter-btn btn btn-primary mt-3 mb-4" type="submit">{{ __('Search') }}</button>
            </ul>
        </div>

               <div class="widget filter_tabs_wrap widget_layered_nav widget-toggle mx-3">
            <h2 class="widget-title">{{ __('Filter by Set of') }}</h2>
                 <div class="sets-ares">
      <form id="setForm" action="{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}" method="post">

          <div class="sets-list">
              
            <ul class="sidebar-checkbox_list">
                @php
                    $set = DB::table('sets')->get();
                @endphp
                @foreach ($set as $se)
                    <li>
                        @if( isset( $_GET['set'] ) && in_array($se->id, $_GET['set']))
                        <input name="set[]" class="form-check-input set-input" type="checkbox" checked id="set{{$se->id}}" value="{{$se->id}}">
                        @else
                        <input name="set[]" class="form-check-input set-input" type="checkbox" id="set{{$se->id}}" value="{{$se->id}}">
                        @endif
                        
                        <label class="form-check-label" for="set{{$se->id}}">{{$se->name}}</label>
                    </li>
                @endforeach

           </ul>
         </div>
         
  </form>
</div>
        </div>

        <div class="widget filter_tabs_wrap widget_layered_nav widget-toggle mx-3">
            <h2 class="widget-title">{{ __('Filter by Color') }}</h2>
                 <div class="sets-ares">
      <form id="setForm" action="{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}" method="post">

          <div class="sets-list">
              
            <ul class="sidebar-checkbox_list">
                @php
                    $color = DB::table('colors')->get();
                @endphp
                @foreach ($color as $col)
                    <li>
                        @if( isset( $_GET['color'] ) && in_array($col->id, $_GET['color']))
                        <input name="color[]" class="form-check-input color-input" type="checkbox" checked id="color{{$col->id}}" value="{{$col->id}}">
                        @else
                        <input name="color[]" class="form-check-input color-input" type="checkbox" id="color{{$col->id}}" value="{{$col->id}}">
                        @endif
                        
                        <label class="form-check-label" for="color{{$col->id}}">{{$col->name}}</label>
                    </li>
                @endforeach

           </ul>
         </div>
         
  </form>
</div>
        </div>


        <div class="widget filter_tabs_wrap widget_layered_nav widget-toggle mx-3">
            <h2 class="widget-title">{{ __('Filter by Size') }}</h2>
                 <div class="sets-ares">
      <form id="setForm" action="{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}" method="post">

          <div class="sets-list">
              
            <ul class="sidebar-checkbox_list">
                @php
                    $size = DB::table('sizes')->get();
                @endphp
                @foreach ($size as $siz)
                    <li>
                        @if( isset( $_GET['size'] ) && in_array($siz->id, $_GET['size']))
                        <input name="size[]" class="form-check-input size-input" type="checkbox" checked id="size{{$siz->id}}" value="{{$siz->id}}">
                        @else
                        <input name="size[]" class="form-check-input size-input" type="checkbox" id="size{{$siz->id}}" value="{{$siz->id}}">
                        @endif
                        
                        <label class="form-check-label" for="size{{$siz->id}}">{{$siz->name}}</label>
                    </li>
                @endforeach

           </ul>
         </div>
         
  </form>
</div>
        </div>



    </form>


    @if ((!empty($cat) && !empty(json_decode($cat->attributes, true))) || (!empty($subcat) && !empty(json_decode($subcat->attributes, true))) || (!empty($childcat) && !empty(json_decode($childcat->attributes, true))))

    <form id="attrForm" action="{{ route('front.category',[Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" method="post">

        @if (!empty($cat) && !empty(json_decode($cat->attributes, true)))
        @foreach ($cat->attributes as $key => $attr)

        <div id="bigbazar-attributes-filter-{{$attr->name}}" class="widget woocommerce bigbazar-attributes-filter widget_layered_nav widget-toggle">
            <h2 class="widget-title">{{$attr->name}}</h2>
            <ul class="swatch-filter-pa_color">
                @if (!empty($attr->attribute_options))
                      @foreach ($attr->attribute_options as $key => $option)
                      <div class="form-check ml-0 pl-0">
                        <input name="{{$attr->input_name}}[]" class="form-check-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                        <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}">{{$option->name}}</label>
                      </div>
                      @endforeach
                    @endif
            </ul>
        </div>
        @endforeach
        @endif

        @if (!empty($subcat) && !empty(json_decode($subcat->attributes, true)))
            @foreach ($subcat->attributes as $key => $attr)
                <div id="bigbazar-attributes-filter-{{$attr->name}}" class="widget woocommerce bigbazar-attributes-filter widget_layered_nav widget-toggle">
                    <h2 class="widget-title">{{$attr->name}}</h2>
                    <ul class="swatch-filter-pa_color">
                        @if (!empty($attr->attribute_options))
                              @foreach ($attr->attribute_options as $key => $option)
                              <div class="form-check ml-0 pl-0">
                                <input name="{{$attr->input_name}}[]" class="form-check-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                                <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}">{{$option->name}}</label>
                              </div>
                              @endforeach
                            @endif
                    </ul>
                </div>
            @endforeach
        @endif

    @if (!empty($childcat) && !empty(json_decode($childcat->attributes, true)))
        @foreach ($childcat->attributes as $key => $attr)
            <div id="bigbazar-attributes-filter-{{$attr->name}}" class="widget woocommerce bigbazar-attributes-filter widget_layered_nav widget-toggle px-3">
                <h2 class="widget-title">{{$attr->name}}</h2>
                <ul class="swatch-filter-pa_color">
                    @if (!empty($attr->attribute_options))
                          @foreach ($attr->attribute_options as $key => $option)
                          <div class="form-check ml-0 pl-0">
                            <input name="{{$attr->input_name}}[]" class="form-check-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                            <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}">{{$option->name}}</label>
                          </div>
                          @endforeach
                        @endif
                </ul>
            </div>
        @endforeach
     @endif



    </form>
    @endif
        
    </div>
</div>
