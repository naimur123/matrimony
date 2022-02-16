

<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    
    <div class="modal-body">        
        <div class="row">            
            <div class="col-sm-12">
                <h3>Package Information</h3>
                Package name : {{ $subscription->packageDetails->title }} <br>
                Subscribe User : MMBD-{{ $subscription->user->id }} , {{ $subscription->user->first_name }} {{ $subscription->user->last_name}} <br>
                Package activation : {{ $subscription->activation_date }} <br>
                Package expire : {{ $subscription->expire_date }} <br>                
                Package Price : {{ number_format($subscription->payment_amount) }} {{ $system->currency }}
                <hr>
            </div>

            <div class="col-sm-12">
                <h4>Payment History</h4>
                Paid Payment: {{ number_format($subscription->paid_amount) }} {{ $system->currency }} <br>
                Tansaction ID : {{ $subscription->tran_id }} <br>
                @if($subscription->payment_type == "offline")   
                    Payment Method: {{ $subscription->payment_method }} <br>
                    Comments : {!! $subscription->comments !!}
                @else
                    Transaction Time : {{ isset($subscription->paymentTransaction->tran_date) ? $subscription->paymentTransaction->tran_date : 'N/A' }} <br>
                    Payment Method: {{ $subscription->payment_method }} <br>
                @endif    
                
                Payment Status : {{ $subscription->payment_method }}
                @if($subscription->payment_status == "paid")
                    <span class="label label-success">{{ $subscription->payment_status }}</span>
                @elseif($subscription->payment_status == "due")
                    <span class="label label-warning">{{ $subscription->payment_status }}</span>
                @else
                    <span class="label label-danger">{{ $subscription->payment_status }}</span>
                @endif

            </div>
        </div>

        <div class="modal-footer" style="margin-top: 20px;">
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
        </div>
</div>