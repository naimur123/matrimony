<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered{ background: transparent;padding-top:5px !important; }
    .select2-container .select2-selection--single{ height:35px !important;}
</style>

<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > Make Payment </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['route'=>'payments.offline.create', 'method' => 'post', 'class'=>'ajax-form']) !!}
        <div class="modal-body">
            <div class="row">
                <input type="hidden" name="id" value="{{ isset($data->id) ? $data->slug : 0 }}" >
                <!-- Select User -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>User <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control select2" required >
                            <option value="" >Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" >MMBD-{{ $user->id }} - {{ $user->first_name }} {{ $user->last_name }} - {{ $user->phone }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> 

                <!-- Package -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Package <span class="text-danger">*</span></label>
                        <select name="package_id" class="form-control select2" required >
                            <option value="" >Select Package</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}" >{{ $package->title }} - {{ $package->current_fee .$system->currency }} - {{ $package->duration }} {{ ucfirst($package->duration_type) }}s</option>
                            @endforeach
                        </select>
                    </div>
                </div>  
                
                <!-- Paymeth Method -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method" class="form-control select2" required >
                            <option value="">Select Payment Method</option>
                            <option value="Cash">Cash</option>
                            <option value="Bkash">Bkash</option>
                            <option value="Roket">Roket</option>
                            <option value="mCash">mCash</option>
                            <option value="EasyCash">EasyCash</option>
                            <option value="SureCash">SureCash</option>
                            <option value="Mobile Money">Mobile Money</option>
                            <option value="SMS Banking">SMS Banking</option>                            
                        </select>
                    </div>
                </div>

                <!-- Paid Amount -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Paid Amount <span class="text-danger">*</span></label>
                        <input type="number" step="any" min="1" name="paid_amount" class="form-control" required placeholder="1000">
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Payment Status <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="payment_status" required>
                            <option value=""> Select payment Status</option>
                            <option value="due"> Due </option>
                            <option value="paid"> Paid </option>
                        </select>
                    </div>
                </div>

                <!-- tran_id -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Transaction Id </label>
                        <input type="text"  name="tran_id" class="form-control" placeholder="Keep it blank to generate automitically" >
                    </div>
                </div>

                <!-- comment -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Admin Comment</label>
                        <textarea class="form-control" name="comments"></textarea>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"> 0% </div>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                <button type="submit" name="btn" class="btn btn-sm btn-primary"> Save </button>
            </div>
        </div>
    {!! Form::close() !!}
</div>

<script>
    $(document).ready(function(){
        $('.select2').select2();
    });
</script>