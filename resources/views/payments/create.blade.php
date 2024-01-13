@extends('layouts.app')
@section('title', 'Payments')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom example example-compact">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Payments</h3>
                        </div>
                    </div>
                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Technician <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <select
                                            class="form-control @error('user_id') is-invalid @enderror select-2"
                                            name="user_id"
                                        >
                                            <option value=""></option>
                                            @foreach($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                                {{ $user->full_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Amount <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="number"
                                            class="form-control @error('amount') is-invalid @enderror"
                                            name="amount"
                                            value="{{ old('amount') }}"
                                            placeholder="Enter the amount"
                                        >
                                        @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    From date <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control datepicker @error('from_date') is-invalid @enderror"
                                            name="from_date"
                                            value="{{ old('from_date') }}"
                                            placeholder="Select the from date"
                                        >
                                        @error('from_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    To date <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control datepicker @error('to_date') is-invalid @enderror"
                                            name="to_date"
                                            value="{{ old('to_date') }}"
                                            placeholder="Select the to date"
                                        >
                                        @error('to_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-9 ml-lg-auto">
                                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                                    <a href="{{ route('payments.index') }}" class="btn btn-light-primary">Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('select[name="user_id"]').select2({
            placeholder: 'Select the technician',
        });

        $('.datepicker').datepicker({
            autoclose: true,
            format: 'm.d.yyyy',
            locale: 'en',
            todayHighlight: true,
        });
    </script>
@endsection
