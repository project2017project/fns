<?php

namespace App\Http\Controllers\Admin;

use DB;
use Datatables;
use App\Models\Order;
use App\Models\Download;
use Illuminate\Http\Request;

class DownloadController extends AdminBaseController
{
    
    public function create(){
        $date = DB::table('downloads')->get();
        $startDate = $date[0]->startDate;
        $endDate = $date[0]->endDate;
        return view('admin.download.index', compact('date'));
    }
    //*** POST Request
    public function store(Request $request)
    {
        $id = 1;
        $data = Download::findOrFail($id);
        $input = $request->all();
      
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('New Data Added Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }



    public function downloadExcelFile($status){
        $date = DB::table('downloads')->get();
        $startDate = $date[0]->startDate;
        $endDate = $date[0]->endDate;
        $nooforder = 100000;
        $v_datas = DB::table('orders')->whereBetween('created_at', [$startDate,$endDate])->orderBy('id','desc')->get();
        //print_r($v_datas);die;
        $fileName = 'process_order.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('SL No', 'Order Date', 'Order Id','Status','Product Name','Product Quantity','Order Total','Coupon Code','Coupon Discount','Shipping Cost');
        $j=1;
        $callback = function() use($v_datas, $columns,$j,$nooforder) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);		 
            foreach ($v_datas as $v_data) {                
                $datas =	Order::where('id','=',$v_data->id)->get();
                
                if($j<=$nooforder){
                    foreach ($datas as $data) {                      
                        $cartproduct            = json_decode($data->cart);	
                        foreach ($cartproduct->items as $item) {
                            $row['SL No']           = $j;			
                            $row['Order Date']      = date('d-M-Y H:i:s a',strtotime($data->created_at)); 
                            $row['Order Id']        = $data->id;
                            $row['Status']          = $data->status;
                            $row['Product Name']    = $item->item->name;
                            $row['Product Quantity']    = $item->qty;
                            $row['Order Total']    = $cartproduct->totalPrice;
                            $row['Coupon Code']     = $data->coupon_code;
                            $row['Coupon Discount']  = $data->coupon_discount;
                            $row['Shipping Cost']  = $data->shipping_cost;
                            fputcsv($file, array($row['SL No'] , $row['Order Date'],$row['Order Id'],$row['Status'],$row['Product Name'],$row['Product Quantity'],$row['Order Total'],$row['Coupon Code'],$row['Coupon Discount'],$row['Shipping Cost']));
                            $j++;
                        }                        
                                                
                    }
                }
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);

    }
}