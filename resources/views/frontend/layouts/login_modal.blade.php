<div class="account-entry">
    <form method="post" action="{{ route('adminLoginPost') }}">
        @csrf
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i data-feather="user"></i>{{__('Login')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input id="email" type="email" name="email" placeholder="{{__('Email Address')}}" class="form-control @error('email') is-invalid @enderror form-control-lg" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @if ($message = Session::get('warning'))
                                <div class="alert alert-warning alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            @if ($message = Session::get('success'))
                                <div class="alert alert-warning alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span id="error-span">
                            </span>
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" name="password" placeholder="{{__('Password')}}" class="form-control @error('password') is-invalid @enderror form-control-lg" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="more-option">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    {{__('Remember Me')}}
                                </label>
                            </div>
                            {{-- <a href="#">Forget Password?</a> --}}
                        </div>
                        <button class="button primary-bg btn-block">{{__('Login')}}</button>
                        <div class="shortcut-login">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>