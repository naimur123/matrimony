
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header text-center" style="border:none;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <img src="{{ isset($system->logo) ? asset($system->logo) : Null }}">
                <h4 class="modal-title">Welcome back! <br> Please Login</h4>
            </div>
            {!! Form::open(['route' => 'login', 'method' => 'post', 'files' => true,'class'=>'ajax-form'] ) !!}    
                <div class="modal-body">                
                    <div class="form-item form-type-textfield form-item-name">
                        <label for="edit-name">Email <span class="form-required text-danger" title="This field is required.">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" size="60" maxlength="60" class="form-text required" placeholder="something@gmail.com" required>
                    </div>
                    <div class="form-item form-type-password form-item-pass">
                        <label for="edit-pass">Password <span class="form-required text-danger" title="This field is required.">*</span></label>
                        <input type="password" name="password" size="60" maxlength="128" minlength="6" class="form-text required" placeholder="Your Password" required >
                    </div>
                    <div class="form-item form-type-checkbox form-item-name">
                        <br>
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" checked {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" style="font-size: 13px;">Remember Me </label>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link pull-right" href="{{ route('password.request') }}" style="font-size: 13px;">
                                {{ __('Forgot Your Password ?') }}
                            </a>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-info form-control">Sign in</button> 
                    </div>
                    <div class="text-center">
                        <a href="{{ url('/register') }}" class="user-auth btn btn-link" style="margin-top: 15px;"> Sign Up Free</a>
                    </div>
                </div> 
            {!! Form::close() !!}
        </div>
    </div>
</div>
