@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <div class="login login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white">
        <div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
            <div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
                <div class="login-form login-signin">
                    <div class="text-center mb-10 mb-lg-20">
                        <h3 class="font-size-h1-lg">Login for Technicians</h3>
                    </div>
                    <form action="{{ route('technician.loginPost') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <input
                                type="number"
                                class="form-control form-control-solid h-auto py-5 px-6 @error('uid') is-invalid @enderror"
                                name="uid"
                                placeholder="Enter the ID"
                                required
                            >
                            @error('id')
                            <span class="form-text text-danger pt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input
                                type="password"
                                class="form-control form-control-solid h-auto py-5 px-6 @error('password') is-invalid @enderror"
                                name="password"
                                placeholder="Enter the password"
                            >
                            @error('password')
                            <span class="form-text text-danger pt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" name="remember" value="1">
                                    <span></span> Remember me
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
@endsection

