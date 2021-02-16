@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Login Page')
{{-- page scripts --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<!-- login page start -->
<section id="auth-login" class="row flexbox-container">
  <div class="col-xl-8 col-11">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <!-- left section-login -->
        <div class="col-md-6 col-12 px-0">
          <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            <div class="card-header pb-1">
              <div class="card-title">
                <h4 class="text-center mb-2">Welcome Back</h4>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="d-flex flex-md-row flex-column justify-content-around">
                  <a href="#" class="btn btn-social btn-google btn-block font-small-3 mr-md-1 mb-md-0 mb-1">
                    <i class="bx bxl-google font-medium-3"></i>
                    <span class="pl-50 d-block text-center">Google</span>
                  </a>
                  <a href="#" class="btn btn-social btn-block mt-0 btn-facebook font-small-3">
                    <i class="bx bxl-facebook-square font-medium-3"></i>
                    <span class="pl-50 d-block text-center">Facebook</span>
                  </a>
                </div>
                <div class="divider">
                  <div class="divider-text text-uppercase text-muted">
                    <small>or login with email</small>
                  </div>
                </div>
                {{-- form  --}}
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="form-group mb-50">
                    <label class="text-bold-600" for="email">Email address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus placeholder="Email">
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label class="text-bold-600" for="password">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password" placeholder="Password">
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                     @enderror
                  </div>
                  <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                    <div class="text-left">
                      <div class="checkbox checkbox-sm">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                          <small>Keep me logged in</small>
                        </label>
                      </div>
                    </div>
                    <div class="text-right">
                      <a href="{{ route('password.request') }}" class="card-link"><small>Forgot Password?</small></a>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary glow w-100 position-relative">Login
                    <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                  </button>
                </form>
                <hr>
                <div class="text-center">
                  <small class="mr-25">Don't have an account?</small>
                  <a href="{{route('register')}}"><small>Sign up</small></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- right section image -->
        <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
          <div class="card-content">
            <img class="img-fluid" src="{{asset('images/pages/login.png')}}" alt="branding logo">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- login page ends -->
@endsection
