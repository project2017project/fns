<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Models\Cart;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Product;
use App\Models\User;
use App\Models\Courier;
use Datatables;
use Illuminate\Http\Request;

class OrderController extends AdminBaseController
{
    // *** GET Request
    public function orders(Request $request)
    {
        if($request->status == 'pending') {
            return view('admin.order.pending');
        }
        elseif ($request->status == 'processing') {
            return view('admin.order.processing');
        }
        elseif ($request->status == 'completed') {
            return view('admin.order.completed');
        }
        elseif ($request->status == 'declined') {
            return view('admin.order.declined');
        }
        elseif ($request->status == 'refund-request') {
            return view('admin.order.refund-request');
        }
        elseif ($request->status == 'refunded') {
            return view('admin.order.refunded');
        }
        elseif ($request->status == 'ondelivery') {
            return view('admin.order.ondelivery');
        }
        else {
            return view('admin.order.index');
        }
    }

    public function processing()
    {
        return view('admin.order.processing');
    }

    public function completed()
    {
        return view('admin.order.completed');
    }

    public function declined()
    {
        return view('admin.order.declined');
    }

    public function ondelivery()
    {
        return view('admin.order.ondelivery');
    }

    public function datatables($status)
    {
        if($status == 'pending') {
            $datas = Order::where('status', '=', 'pending')->where('is_refund', '=', 2)->latest('id')->get();
        } 
        elseif ($status == 'processing') {
            $datas = Order::where('status', '=', 'processing')->where('is_refund', '=', 2)->latest('id')->get();
        } 
        elseif ($status == 'completed') {
            $datas = Order::where('status', '=', 'completed')->where('is_refund', '=', 2)->latest('id')->get();
        } 
        elseif ($status == 'declined') {
            $datas = Order::where('status', '=', 'declined')->where('is_refund', '=', 2)->latest('id')->get();
        }
        elseif ($status == 'ondelivery') {
            $datas = Order::where('status', '=', 'on delivery')->where('is_refund', '=', 2)->latest('id')->get();
        }
        elseif ($status == 'refund-request') {
            $datas = Order::where('is_refund', '=', 1)->latest('id')->get();
        }
        elseif ($status == 'refunded') {
            $datas = Order::where('refund_approved', '=', 1)->latest('id')->get();
        }
        else {
            $datas = Order::latest('id')->where('is_refund', '=', 2)->get();
        }

        // --- Integrating This Collection Into Datatables
        
        if($status == 'refund-request' || $status == 'refunded'){
            return \Datatables::of($datas)
               ->editColumn('id', function (Order $data) {
                   $id = '<a href="'.route('admin-order-invoice', $data->id).'">'.$data->order_number.'</a>';
    
                   return $id;
               })
               ->editColumn('pay_amount', function (Order $data) {
                   return \PriceHelper::showOrderCurrencyPrice(($data->pay_amount + $data->wallet_price) * $data->currency_value, $data->currency_sign);
               })
               ->addColumn('action', function (Order $data) {
                   return '<div class="godropdown"><button class="go-dropdown-toggle">'.__('Actions').'<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="'.route('admin-order-show', $data->id).'" > <i class="fas fa-eye"></i> '.__('View Details').'</a></div></div>';
               })
               ->rawColumns(['id', 'action'])
               ->toJson(); // --- Returning Json Data To Client Side    
        }
        else{
            return \Datatables::of($datas)
               ->editColumn('id', function (Order $data) {
                   $id = '<a href="'.route('admin-order-invoice', $data->id).'">'.$data->order_number.'</a>';
    
                   return $id;
               })
               ->editColumn('pay_amount', function (Order $data) {
                   return \PriceHelper::showOrderCurrencyPrice(($data->pay_amount + $data->wallet_price) * $data->currency_value, $data->currency_sign);
               })
               ->addColumn('action', function (Order $data) {
                   $orders = '<a href="javascript:;" data-href="'.route('admin-order-edit', $data->id).'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> '.__('Delivery Status').'</a>';
    
                   return '<div class="godropdown"><button class="go-dropdown-toggle">'.__('Actions').'<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="'.route('admin-order-show', $data->id).'" > <i class="fas fa-eye"></i> '.__('View Details').'</a><a href="javascript:;" class="send" data-email="'.$data->customer_email.'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> '.__('Send').'</a><a href="javascript:;" data-href="'.route('admin-order-track', $data->id).'" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> '.__('Track Order').'</a><a href="'.route('admin-order-craete-shipment', $data->id).'" > <i class="fas fa-eye"></i> '.__('Create Shipment').'</a>'.$orders.'</div></div>';
               })
               ->rawColumns(['id', 'action'])
               ->toJson(); // --- Returning Json Data To Client Side    
        }
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);

        return view('admin.order.details', compact('order', 'cart'));
    }

    public function createShipment($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);
        $couriers = Courier::orderBy('name', 'ASC')->get();
        
        if(isset($order->shiprocket_shipment_id) && !empty($order->shiprocket_shipment_id) && empty($order->shiprocket_awb_code)){
            $authTken = \ShipRocketHelper::Authentication();
            if(isset($authTken['token']) && !empty($authTken['token'])){
                $response_GenerateAWB = \ShipRocketHelper::GenerateAWB($authTken['token'], $order->shiprocket_shipment_id, $order->courier_id); 
                $response_awb = $response_GenerateAWB['response'];
                $response_awb_code = (array)$response_awb;
                $response_awb_code_dt = (array)$response_awb_code['data'];
                $order->shiprocket_awb_code = $response_awb_code_dt['awb_code'];
                $order->save();
            }
        }
        
        return view('admin.order.create-shipment', compact('order', 'cart', 'couriers'));
    }
    
    public function postShipment(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);
        
        $authTken = \ShipRocketHelper::Authentication();
        if(isset($authTken['token']) && !empty($authTken['token'])){
            $items = array();
            $ik = 0;
            foreach ($cart['items'] as $key1 => $product){
                echo $product['item']['id'];
                echo '<br/>';
                $pData = Product::where('id', $product['item']['id'])->first(['sku']);
                
                $items[$ik]['name']          =   $product['item']['name'];
                $items[$ik]['sku']           =   $pData->sku;
                $items[$ik]['units']         =   $product['qty'];
                $items[$ik]['selling_price'] =   $product['item_price'];
                $items[$ik]['discount']      =   0;
                $items[$ik]['tax']           =   0;
                $items[$ik]['hsn']           =   '';
                $ik++;
            }
            $payment_method = 'Prepaid';
            if($order->method =='Cash On Delivery') $payment_method = 'COD';
            
            if(isset($order->shipping_name) && !empty($order->shipping_name)){
                $orderData = [
                    "order_id"              =>  $order->order_number,
                    "order_date"            =>  $order->created_at,
                    "pickup_location"       =>  "Primary",
                    "channel_id"            =>  "",
                    "comment"               =>  $order->order_number,
                    "billing_customer_name" =>  $order->customer_name,
                    "billing_last_name"     =>  $order->customer_name,
                    "billing_address"       =>  $order->customer_address,
                    "billing_address_2"     =>  $order->customer_address,
                    "billing_city"          =>  $order->customer_city,
                    "billing_pincode"       =>  $order->customer_zip,
                    "billing_state"         =>  $order->customer_state,
                    "billing_country"       =>  $order->customer_country,
                    "billing_email"         =>  $order->customer_email,
                    "billing_phone"         =>  $order->customer_phone,
                    "shipping_is_billing"   =>  false,
                    "shipping_customer_name"=>  $order->shipping_name,
                    "shipping_last_name"    =>  $order->shipping_name,
                    "shipping_address"      =>  $order->shipping_address,
                    "shipping_address_2"    =>  $order->shipping_address,
                    "shipping_city"         =>  $order->shipping_city,
                    "shipping_pincode"      =>  $order->shipping_zip,
                    "shipping_country"      =>  $order->shipping_country,
                    "shipping_state"        =>  $order->shipping_state,
                    "shipping_email"        =>  $order->shipping_email,
                    "shipping_phone"        =>  $order->shipping_phone,
                    "payment_method"        =>  $payment_method,
                    "shipping_charges"      =>  $order->shipping_cost,
                    "giftwrap_charges"      =>  $order->packing_cost,
                    "transaction_charges"   =>  0,
                    "total_discount"        =>  $order->discount,
                    "sub_total"             =>  ($order->pay_amount + $order->wallet_price),
                    "length"                =>  $request->length,
                    "breadth"               =>  $request->width,
                    "height"                =>  $request->height,
                    "weight"                =>  $request->weight
                ];    
            }
            else{
                $orderData = [
                    "order_id"              =>  $order->order_number,
                    "order_date"            =>  $order->created_at,
                    "pickup_location"       =>  "Primary",
                    "channel_id"            =>  "",
                    "comment"               =>  $order->order_number,
                    "billing_customer_name" =>  $order->customer_name,
                    "billing_last_name"     =>  "",
                    "billing_address"       =>  $order->customer_address,
                    "billing_address_2"     =>  "",
                    "billing_city"          =>  $order->customer_city,
                    "billing_pincode"       =>  $order->customer_zip,
                    "billing_state"         =>  $order->customer_state,
                    "billing_country"       =>  $order->customer_country,
                    "billing_email"         =>  $order->customer_email,
                    "billing_phone"         =>  $order->customer_phone,
                    "shipping_is_billing"   =>  true,
                    "shipping_customer_name"=>  "",
                    "shipping_last_name"    =>  "",
                    "shipping_address"      =>  "",
                    "shipping_address_2"    =>  "",
                    "shipping_city"         =>  "",
                    "shipping_pincode"      =>  "",
                    "shipping_country"      =>  "",
                    "shipping_state"        =>  "",
                    "shipping_email"        =>  "",
                    "shipping_phone"        =>  "",
                    "payment_method"        =>  $payment_method,
                    "shipping_charges"      =>  $order->shipping_cost,
                    "giftwrap_charges"      =>  $order->packing_cost,
                    "transaction_charges"   =>  0,
                    "total_discount"        =>  $order->discount,
                    "sub_total"             =>  ($order->pay_amount + $order->wallet_price),
                    "length"                =>  $request->length,
                    "breadth"               =>  $request->width,
                    "height"                =>  $request->height,
                    "weight"                =>  $request->weight
                ];    
            }
            
            
            $shiprocket_order_id    =   '';
            $shiprocket_shipment_id =   '';
            
            $response = \ShipRocketHelper::CreateCustomOrder($authTken['token'], $items, $orderData);
            
            if(isset($response['shipment_id'])){
                $shiprocket_order_id    =   $response['order_id'];
                $shiprocket_shipment_id =   $response['shipment_id'];    
            }    
            
            Order::where('id', $id)->update([
                'length'        =>  $request->length, 
                'width'         =>  $request->width, 
                'height'        =>  $request->height, 
                'weight'        =>  $request->weight, 
                'courier_id'    =>  $request->courier_id,
                'shiprocket_order_id'       =>  $shiprocket_order_id,
                'shiprocket_shipment_id'    =>  $shiprocket_shipment_id
            ]);
            
            return redirect()->back()->with('success', 'Shipment Order Successfully created');
        }
        return redirect()->back()->with('error', 'Error while create shipment');
        
    }

    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);
        return view('admin.order.invoice', compact('order', 'cart'));
    }

    public function emailsub(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);
        if ($gs->is_smtp == 1) {
            $data = [
                'to' => $request->to,
                'subject' => $request->subject,
                'body' => $request->message,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);
        } 
        else {
            $data = 0;
            $headers = 'From: '.$gs->from_name.'<'.$gs->from_email.'>';
            $mail = mail($request->to, $request->subject, $request->message, $headers);
            if ($mail) {
                $data = 1;
            }
        }

        return response()->json($data);
    }

    public function printpage($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);

        return view('admin.order.print', compact('order', 'cart'));
    }

    public function license(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);
        $cart['items'][$request->license_key]['license'] = $request->license;
        $new_cart = json_encode($cart);
        $order->cart = $new_cart;
        $order->update();
        $msg = __('Successfully Changed The License Key.');

        return redirect()->back()->with('license', $msg);
    }

    public function edit($id)
    {
        $data = Order::find($id);

        return view('admin.order.delivery', compact('data'));
    }

    // *** POST Request
    public function update(Request $request, $id)
    {
        // --- Logic Section
        $data = Order::findOrFail($id);
        $gs = Generalsetting::findOrFail(1);
        $input = $request->all();
        if ($request->has('status')) {
            if ($data->status == 'completed') {
                // Then Save Without Changing it.
                $input['status'] = 'completed';
                $data->update($input);
                // --- Logic Section Ends

                // --- Redirect Section
                $msg = __('Status Updated Successfully.');

                return response()->json($msg);
            // --- Redirect Section Ends
            } else {
                if ($input['status'] == 'completed') {
                    foreach ($data->vendororders as $vorder) {
                        $uprice = User::find($vorder->user_id);
                        $uprice->current_balance = $uprice->current_balance + $vorder->price;
                        $uprice->update();
                    }

                    if (User::where('id', $data->affilate_user)->exists()) {
                        $auser = User::where('id', $data->affilate_user)->first();
                        $auser->affilate_income += $data->affilate_charge;
                        $auser->update();
                    }

                    if ($data->affilate_users != null) {
                        $ausers = json_decode($data->affilate_users, true);
                        foreach ($ausers as $auser) {
                            $user = User::find($auser['user_id']);
                            if ($user) {
                                $user->affilate_income += $auser['charge'];
                                $user->update();
                            }
                        }
                    }

                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Confirmed!',
                        'body' => 'Hello '.$data->customer_name.','."\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];

                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);
                }
                if ($input['status'] == 'declined') {
                    // Refund User Wallet If Any
                    if ($data->user_id != 0) {
                        if ($data->wallet_price != 0) {
                            $user = User::find($data->user_id);
                            if ($user) {
                                $user->balance = $user->balance + $data->wallet_price;
                                $user->save();
                            }
                        }
                    }

                    $cart = json_decode($data->cart, true);

                    // Restore Product Stock If Any
                    foreach ($cart->items as $prod) {
                        $x = (string) $prod['stock'];
                        if ($x != null) {
                            $product = Product::findOrFail($prod['item']['id']);
                            $product->stock = $product->stock + $prod['qty'];
                            $product->update();
                        }
                    }

                    // Restore Product Size Qty If Any
                    foreach ($cart->items as $prod) {
                        $x = (string) $prod['size_qty'];
                        if (!empty($x)) {
                            $product = Product::findOrFail($prod['item']['id']);
                            $x = (int) $x;
                            $temp = $product->size_qty;
                            $temp[$prod['size_key']] = $x;
                            $temp1 = implode(',', $temp);
                            $product->size_qty = $temp1;
                            $product->update();
                        }
                    }

                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Declined!',
                        'body' => 'Hello '.$data->customer_name.','."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.",
                    ];
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);
                }

                $data->update($input);

                if ($request->track_text) {
                    $title = ucwords($request->status);
                    $ck = OrderTrack::where('order_id', '=', $id)->where('title', '=', $title)->first();
                    if ($ck) {
                        $ck->order_id = $id;
                        $ck->title = $title;
                        $ck->text = $request->track_text;
                        $ck->update();
                    } else {
                        $data = new OrderTrack();
                        $data->order_id = $id;
                        $data->title = $title;
                        $data->text = $request->track_text;
                        $data->save();
                    }
                }

                // --- Redirect Section
                $msg = __('Status Updated Successfully.');

                return response()->json($msg);
                // --- Redirect Section Ends
            }
        }

        $data->update($input);
        // --- Redirect Section
        $msg = __('Data Updated Successfully.');

        return redirect()->back()->with('success', $msg);
        // --- Redirect Section Ends
    }

    public function product_submit(Request $request)
    {
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        $id = $request->id;
        $product = Product::whereStatus(1)->where('id', $id)->first();
        $data = [];
        if (!$product) {
            $data[0] = false;
            $data[1] = __('No Product Found');
        } else {
            $data[0] = true;
            $data[1] = $product->id;
        }

        return response()->json($data);
    }

    public function product_show($id)
    {
        $data['productt'] = Product::find($id);
        $data['curr'] = $this->curr;

        return view('admin.order.add-product', $data);
    }

    public function addcart($id)
    {
        $order = Order::find($id);
        $id = $_GET['id'];
        $qty = $_GET['qty'];
        $size = str_replace(' ', '-', $_GET['size']);
        $color = $_GET['color'];
        $size_qty = $_GET['size_qty'];
        $size_price = (float) $_GET['size_price'];
        $size_key = $_GET['size_key'];
        $affilate_user = isset($_GET['affilate_user']) ? $_GET['affilate_user'] : '0';
        $keys = $_GET['keys'];
        $keys = explode(',', $keys);
        $values = $_GET['values'];
        $values = explode(',', $values);
        $prices = $_GET['prices'];
        $prices = explode(',', $prices);
        $keys = $keys == '' ? '' : implode(',', $keys);
        $values = $values == '' ? '' : implode(',', $values);
        $size_price = ($size_price / $order->currency_value);
        $prod = Product::where('id', '=', $id)->first(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes', 'minimum_qty']);

        if ($prod->user_id != 0) {
            $prc = $prod->price + $this->gs->fixed_commission + ($prod->price / 100) * $this->gs->percentage_commission;
            $prod->price = round($prc, 2);
        }
        if (!empty($prices)) {
            if (!empty($prices[0])) {
                foreach ($prices as $data) {
                    $prod->price += ($data / $order->currency_value);
                }
            }
        }

        if (!empty($prod->license_qty)) {
            $lcheck = 1;
            foreach ($prod->license_qty as $ttl => $dtl) {
                if ($dtl < 1) {
                    $lcheck = 0;
                } else {
                    $lcheck = 1;
                    break;
                }
            }
            if ($lcheck == 0) {
                return 0;
            }
        }
        if (empty($size)) {
            if (!empty($prod->size)) {
                $size = trim($prod->size[0]);
            }
            $size = str_replace(' ', '-', $size);
        }

        if (empty($color)) {
            if (!empty($prod->color)) {
                $color = $prod->color[0];
            }
        }
        $color = str_replace('#', '', $color);
        $oldCart = \Session::has('cart') ? \Session::get('cart') : null;
        $cart = new Cart($oldCart);

        if (!empty($cart->items)) {
            if (!empty($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)])) {
                $minimum_qty = (int) $prod->minimum_qty;
                if ($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'] < $minimum_qty) {
                    return redirect()->back()->with('unsuccess', __('Minimum Quantity is:').' '.$prod->minimum_qty);
                }
            } else {
                if ($prod->minimum_qty != null) {
                    $minimum_qty = (int) $prod->minimum_qty;
                    if ($qty < $minimum_qty) {
                        return redirect()->back()->with('unsuccess', __('Minimum Quantity is:').' '.$prod->minimum_qty);
                    }
                }
            }
        } else {
            $minimum_qty = (int) $prod->minimum_qty;
            if ($prod->minimum_qty != null) {
                if ($qty < $minimum_qty) {
                    return redirect()->back()->with('unsuccess', __('Minimum Quantity is:').' '.$prod->minimum_qty);
                }
            }
        }

        $cart->addnum($prod, $prod->id, $qty, $size, $color, $size_qty, $size_price, $size_key, $keys, $values, $affilate_user);
        if ($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['dp'] == 1) {
            return redirect()->back()->with('unsuccess', __('This item is already in the cart.'));
        }
        if ($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['stock'] < 0) {
            return redirect()->back()->with('unsuccess', __('Out Of Stock.'));
        }
        if ($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['size_qty']) {
            if ($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'] > $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['size_qty']) {
                return redirect()->back()->with('unsuccess', __('Out Of Stock.'));
            }
        }

        $cart->totalPrice = 0;
        foreach ($cart->items as $data) {
            $cart->totalPrice += $data['price'];
        }
        $o_cart = json_decode($order->cart, true);

        $order->totalQty = $order->totalQty + $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'];
        $order->pay_amount = $order->pay_amount + $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['price'];

        $prev_qty = 0;
        $prev_price = 0;

        if (!empty($o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)])) {
            $prev_qty = $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'];
            $prev_price = $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['price'];
        }

        $prev_qty += $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'];
        $prev_price += $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['price'];

        $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)] = $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)];
        $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'] = $prev_qty;
        $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['price'] = $prev_price;
        $order->cart = json_encode($o_cart);
        $order->update();

        return redirect()->back()->with('success', __('Successfully Added To Cart.'));
    }

    public function product_edit($id, $itemid, $orderid)
    {
        $product = Product::find($itemid);
        $order = Order::find($orderid);
        $cart = json_decode($order->cart, true);
        $data['productt'] = $product;
        $data['item_id'] = $id;
        $data['prod'] = $id;
        $data['order'] = $order;
        $data['item'] = $cart['items'][$id];
        $data['curr'] = $this->curr;

        return view('admin.order.edit-product', $data);
    }

    public function updatecart($id)
    {
        $order = Order::find($id);
        $id = $_GET['id'];
        $qty = $_GET['qty'];
        $size = str_replace(' ', '-', $_GET['size']);
        $color = $_GET['color'];
        $size_qty = $_GET['size_qty'];
        $size_price = (float) $_GET['size_price'];
        $size_key = $_GET['size_key'];
        $affilate_user = isset($_GET['affilate_user']) ? $_GET['affilate_user'] : '0';
        $keys = $_GET['keys'];
        $keys = explode(',', $keys);
        $values = $_GET['values'];
        $values = explode(',', $values);
        $prices = $_GET['prices'];
        $prices = explode(',', $prices);
        $keys = $keys == '' ? '' : implode(',', $keys);
        $values = $values == '' ? '' : implode(',', $values);

        $item_id = $_GET['item_id'];

        $size_price = ($size_price / $order->currency_value);
        $prod = Product::where('id', '=', $id)->first(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes', 'minimum_qty']);

        if ($prod->user_id != 0) {
            $prc = $prod->price + $this->gs->fixed_commission + ($prod->price / 100) * $this->gs->percentage_commission;
            $prod->price = round($prc, 2);
        }
        if (!empty($prices)) {
            if (!empty($prices[0])) {
                foreach ($prices as $data) {
                    $prod->price += ($data / $order->currency_value);
                }
            }
        }

        if (!empty($prod->license_qty)) {
            $lcheck = 1;
            foreach ($prod->license_qty as $ttl => $dtl) {
                if ($dtl < 1) {
                    $lcheck = 0;
                } else {
                    $lcheck = 1;
                    break;
                }
            }
            if ($lcheck == 0) {
                return 0;
            }
        }
        if (empty($size)) {
            if (!empty($prod->size)) {
                $size = trim($prod->size[0]);
            }
            $size = str_replace(' ', '-', $size);
        }

        if (empty($color)) {
            if (!empty($prod->color)) {
                $color = $prod->color[0];
            }
        }
        $color = str_replace('#', '', $color);
        $oldCart = \Session::has('cart') ? \Session::get('cart') : null;
        $cart = new Cart($oldCart);

        if (!empty($cart->items)) {
            if (!empty($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)])) {
                $minimum_qty = (int) $prod->minimum_qty;
                if ($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'] < $minimum_qty) {
                    return redirect()->back()->with('unsuccess', __('Minimum Quantity is:').' '.$prod->minimum_qty);
                }
            } else {
                if ($prod->minimum_qty != null) {
                    $minimum_qty = (int) $prod->minimum_qty;
                    if ($qty < $minimum_qty) {
                        return redirect()->back()->with('unsuccess', __('Minimum Quantity is:').' '.$prod->minimum_qty);
                    }
                }
            }
        } else {
            $minimum_qty = (int) $prod->minimum_qty;
            if ($prod->minimum_qty != null) {
                if ($qty < $minimum_qty) {
                    return redirect()->back()->with('unsuccess', __('Minimum Quantity is:').' '.$prod->minimum_qty);
                }
            }
        }

        $cart->addnum($prod, $prod->id, $qty, $size, $color, $size_qty, $size_price, $size_key, $keys, $values, $affilate_user);
        if ($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['dp'] == 1) {
            return redirect()->back()->with('unsuccess', __('This item is already in the cart.'));
        }
        if ($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['stock'] < 0) {
            return redirect()->back()->with('unsuccess', __('Out Of Stock.'));
        }
        if ($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['size_qty']) {
            if ($cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'] > $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['size_qty']) {
                return redirect()->back()->with('unsuccess', __('Out Of Stock.'));
            }
        }

        $cart->totalPrice = 0;
        foreach ($cart->items as $data) {
            $cart->totalPrice += $data['price'];
        }
        $o_cart = json_decode($order->cart, true);

        if (!empty($o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)])) {
            $cart_qty = $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'];
            $cart_price = $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['price'];

            $prev_qty = $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'];
            $prev_price = $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['price'];

            $temp_qty = 0;
            $temp_price = 0;

            if ($o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'] < $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty']) {
                $temp_qty = $cart_qty - $prev_qty;
                $temp_price = $cart_price - $prev_price;

                $order->totalQty += $temp_qty;
                $order->pay_amount += $temp_price;
                $prev_qty += $temp_qty;
                $prev_price += $temp_price;
            } elseif ($o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'] > $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty']) {
                $temp_qty = $prev_qty - $cart_qty;
                $temp_price = $prev_price - $cart_price;

                $order->totalQty -= $temp_qty;
                $order->pay_amount -= $temp_price;
                $prev_qty -= $temp_qty;
                $prev_price -= $temp_price;
            }
        } else {
            $order->totalQty -= $o_cart['items'][$item_id]['qty'];

            $order->pay_amount -= $o_cart['items'][$item_id]['price'];

            unset($o_cart['items'][$item_id]);

            $order->totalQty = $order->totalQty + $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'];
            $order->pay_amount = $order->pay_amount + $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['price'];

            $prev_qty = 0;
            $prev_price = 0;

            if (!empty($o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)])) {
                $prev_qty = $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'];
                $prev_price = $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['price'];
            }

            $prev_qty += $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'];
            $prev_price += $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['price'];
        }

        $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)] = $cart->items[$id.$size.$color.str_replace(str_split(' ,'), '', $values)];
        $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['qty'] = $prev_qty;
        $o_cart['items'][$id.$size.$color.str_replace(str_split(' ,'), '', $values)]['price'] = $prev_price;

        $order->cart = json_encode($o_cart);

        $order->update();

        return redirect()->back()->with('success', __('Successfully Updated The Cart.'));
    }

    public function product_delete($id, $orderid)
    {
        $order = Order::find($orderid);
        $cart = json_decode($order->cart, true);

        $order->totalQty = $order->totalQty - $cart['items'][$id]['qty'];
        $order->pay_amount = $order->pay_amount - $cart['items'][$id]['price'];
        unset($cart['items'][$id]);
        $order->cart = json_encode($cart);

        $order->update();

        return redirect()->back()->with('success', __('Successfully Deleted From The Cart.'));
    }
}
