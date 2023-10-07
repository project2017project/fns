@if(isset($shipment_track) && count($shipment_track)>0)
<div class="container tracking-head-wrapper">
    <div class="row track-top-row">
        <div class="col-lg-6 col-6 text-left">
          
            <p><strong>Delivered Date :</strong> @if(!empty($shipment_track['delivered_date'])){{$shipment_track['delivered_date']}} @else {{'--'}} @endif</p>
            <p><strong>Pickup Date :</strong> @if(!empty($shipment_track['pickup_date'])){{$shipment_track['pickup_date']}} @else {{'--'}} @endif</p>
            <p><strong>EDD : </strong>@if(!empty($shipment_track['edd'])){{$shipment_track['edd']}} @else {{'--'}} @endif</p>
        </div>
        
        <div class="col-lg-6 col-6 text-right">
              <p><strong>AWB Code :</strong> @if(!empty($shipment_track['awb_code'])){{$shipment_track['awb_code']}} @else {{'--'}} @endif</p>
            <p><strong>Current Status :</strong> @if(!empty($shipment_track['current_status'])){{$shipment_track['current_status']}} @else {{'--'}} @endif</p>
            <p><strong>Courier Name :</strong> @if(!empty($shipment_track['courier_name'])){{$shipment_track['courier_name']}} @else {{'--'}} @endif</p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="track-center-wrap d-flex">
                <div class="track-fns-logo">
                    <img class="logo-img mh-100" src="{{ asset('assets/images/'.$gs->logo) }}" data-src="{{ asset('assets/images/'.$gs->logo) }}" alt="logo" title="logo" width="50" />
                    <p class="mb-0"><strong>Origin :</strong> @if(!empty($shipment_track['origin'])){{$shipment_track['origin']}} @else {{'--'}} @endif</p>
                    
                </div>
                <div class="shipping-bus-icon">
                    <i class="icofont-truck-alt"></i>
                </div>
                <div class="track-origin-wrap">
                    <div class="delivered-icon">
                        <i class="an an-home-l"></i>
                    </div>
                    <p class="mb-0"><strong>Destination :</strong> @if(!empty($shipment_track['destination'])){{$shipment_track['destination']}} @else {{'--'}} @endif</p>
                </div>
            </div>
            
    
        </div>
    </div>
</div>
   
@endif


@if(isset($shipment_track_activities) && count($shipment_track_activities)>0)
<div class="container track--listed py-5">
  <div class="row">

    <div class="col-md-12 col-lg-12">
      <div id="tracking-pre"></div>
      <div id="tracking">
        <div class="tracking-list">
     

    @foreach($shipment_track_activities as $dKey=>$dVal)
        @php $track_activities = (array)$dVal; @endphp
        <div class="tracking-item">
            <div class="tracking-icon status-intransit">
              <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
              </svg>
            </div>
            <div class="tracking-date"><img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg" class="img-responsive" alt="order-placed" /></div>
            <div class="tracking-content">
                @php
                    if($track_activities['sr-status-label'] == 'DELIVERED'){
                        $classstatus = 'completed';
                    } elseif($track_activities['sr-status-label'] == 'SHIPPED'){
                        $classstatus = 'shipped';
                    }
                    elseif($track_activities['sr-status-label'] == 'PICKED UP'){
                        $classstatus = 'pick';
                    } else {
                        $classstatus = 'general';
                    }
                @endphp
                @if(!empty($track_activities['activity'])){{$track_activities['activity']}} @else {{'--'}} @endif - [ @if(!empty($track_activities['location'])){{$track_activities['location']}} @else {{'--'}} @endif ]<span>@if(!empty($track_activities['date'])){{$track_activities['date']}} @else {{'--'}} @endif @if(!empty($track_activities['sr-status-label']))<i class="{{$classstatus}}">{{$track_activities['sr-status-label']}} </i>@else {{'--'}} @endif</span></div>
          </div>
    @endforeach


<!--  <div class="tracking-date"><img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg" class="img-responsive" alt="order-placed" /></div>
            <div class="tracking-content">Delivered<span>12 Aug 2021, 09:00pm</span></div> -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endif

@if(isset($track_url) && !empty($track_url))
    <p><a href="{{$track_url}}" target="_blank">Track Your Shipment</a></p>
@endif

@if(isset($order))
    
@else
    <h3 class="text-center">{{ __('No Order Found.') }}</h3>
@endif          
