<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;

class OrderController extends UserBaseController
{
    public function orders()
    {
        $user = $this->user;
        $orders = Order::where('user_id', '=', $user->id)->latest('id')->get();

        return view('user.order.index', compact('user', 'orders'));
    }

    public function ordertrack()
    {
        $user = $this->user;

        return view('user.order-track', compact('user'));
    }

    public function trackload($id)
    {
        $user = $this->user;
        $order = $user->orders()->where('shiprocket_awb_code', '=', $id)->first();
        
        $track_url                  =   '';
        $shipment_track             =   [];
        $shipment_track_activities  =   [];
        
        $authTken = \ShipRocketHelper::Authentication();
        if(isset($authTken['token']) && !empty($authTken['token'])){
            $TrackingthroughAWB =   \ShipRocketHelper::GetTrackingthroughAWB($authTken['token'], $id);
            $TrackingData       =   (array)$TrackingthroughAWB['tracking_data'];
            
            $track_url          =   $TrackingData['track_url'];
            
            $shipment_track     =   (array)$TrackingData['shipment_track'][0];
            $shipment_track_activities = (array)$TrackingData['shipment_track_activities'];
        }
        $datas = ['Pending', 'Processing', 'On Delivery', 'Completed'];
        return view('load.track-load', compact('order', 'datas', 'shipment_track', 'shipment_track_activities', 'track_url'));
    }

    public function order($id)
    {
        $user = $this->user;
        $order = $user->orders()->whereId($id)->firstOrFail();
        $cart = json_decode($order->cart, true);

        return view('user.order.details', compact('user', 'order', 'cart'));
    }

    public function orderdownload($slug, $id)
    {
        $user = $this->user;
        $order = Order::where('order_number', '=', $slug)->first();
        $prod = Product::findOrFail($id);
        if (!isset($order) || $prod->type == 'Physical' || $order->user_id != $user->id) {
            return redirect()->back();
        }

        return response()->download(public_path('assets/files/'.$prod->file));
    }

    public function orderprint($id)
    {
        $user = $this->user;
        $order = Order::findOrfail($id);
        $cart = json_decode($order->cart, true);

        return view('user.order.print', compact('user', 'order', 'cart'));
    }

    public function trans()
    {
        $id = $_GET['id'];
        $trans = $_GET['tin'];
        $order = Order::findOrFail($id);
        $order->txnid = $trans;
        $order->update();
        $data = $order->txnid;

        return response()->json($data);
    }
    
    public function RefundSpecificProductFromOrderRequest(Request $request){
        $updateData = [
            'is_refund'         =>  1,
            'refund_proceed_on' =>  date('Y-m-d H:i:s'),
            'refund_reason'     =>  $request->refund_reason,
            'refund_text'       =>  $request->refund_text,
        ];
        if(isset($request->item) && count($request->item)>0){
            $refunded_products = array();
            $ip = 0;
            foreach($request->item as $key=>$val){
                $refunded_products[$ip]['item_id'] = $key;
                $refunded_products[$ip]['refund_qty'] = $val;
                $ip++;
            }
            $updateData['refunded_products'] = json_encode($refunded_products);    
        }
        Order::where('id', $request->order_id)->update($updateData);
        $data = [
            'status' => true
        ];
        return response()->json($data);    
    }
    
    public function completeOrderRefundRequest(Request $request){
        Order::where('id', $request->order_id)->update([
            'is_refund'         =>  1,
            'refund_proceed_on' =>  date('Y-m-d H:i:s'),
            'refund_reason'     =>  $request->refund_reason,
            'refund_text'       =>  $request->refund_text,
        ]);  
        
        $data = [
            'status' => true
        ];
        
        return response()->json($data);
    }
}
