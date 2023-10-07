<?php

namespace App\Http\Controllers\Admin;

use App\{
    Http\Controllers\Controller,
    Models\Webpushnotification
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

use Datatables;

class WebpushnotificationController extends Controller
{
    public function index(){
        $datas = Webpushnotification::orderBy('id', 'DESC')->get();
        return view('admin.webpushnotification.index', compact('datas'));
    }
    public function create(){
        return view('admin.webpushnotification.create');
    }
    public function store(Request $request) {
        $thumbnail = '';
        if($file = $request->file('image')){
            $val = $file->getClientOriginalExtension();
            if($val == 'jpeg'|| $val == 'jpg'|| $val == 'png'|| $val == 'svg'){
                $img = Image::make($file->getRealPath())->resize(320, 240);
                $thumbnail = time().Str::random(8).'.jpg';
                $img->save(public_path().'/assets/images/webpushnotification/'.$thumbnail);
            }
        }

        $wpn = new Webpushnotification;

        $wpn->title         =   $request->title;
        $wpn->message       =   $request->message;
        $wpn->target_url    =   $request->target_url;
        $wpn->image         =   $thumbnail;
        $wpn->created_at    =   date('Y-m-d H:i:s');
        $wpn->updated_at    =   date('Y-m-d H:i:s');
        $wpn->save();

        $WebPushData = [
            'title'         =>  $request->title,
            'message'       =>  $request->message,
            'target_url'    =>  $request->target_url,
        ];
        
        if(!empty($thumbnail)){
            if(file_exists(public_path().'/assets/images/webpushnotification/'.$thumbnail)){
                $WebPushData['image'] = asset('assets/images/webpushnotification/'.$thumbnail);   
            }
        }

        \WebPushNotificationHelper::sendNotification($WebPushData);

        $msg = __('Web Push Notification sent successfully.');
        return response()->json($msg);
    }
    public function destroy($id) {
        $del = Webpushnotification::findOrFail($id);
        if(file_exists(public_path().'/assets/images/webpushnotification/'.$del->image)) {
            unlink(public_path().'/assets/images/webpushnotification/'.$del->image);
        }
        $del->delete();
        $msg = __('Deleted Successfully.');
        return response()->json($msg);
    }
}
