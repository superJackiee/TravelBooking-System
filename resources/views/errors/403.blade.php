@extends('layouts.fullLayoutMaster')
{{-- page title --}}
@section('title','Not-authorized')

@section('content')
<!-- not authorized start -->
<section class="row flexbox-container">
  <div class="col-xl-7 col-md-8 col-12">
    <div class="card bg-transparent shadow-none">
      <div class="card-content">
        <div class="card-body text-center">
          <img src="{{asset('images/pages/not-authorized.png')}}" class="img-fluid" alt="not authorized" width="400">
          <h1 class="my-2 error-title">You are not authorized!</h1>
          <p>
              You do not have permission to view this directory or page using 
              the credentials that you supplied.
          </p>
          <a href="{{asset('/')}}" class="btn btn-primary round glow mt-2">BACK TO HOME</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- not authorized end -->
@endsection