@extends('layouts.app')
@section('title', 'Tickets')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom example example-compact">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Tickets</h3>
                        </div>
                    </div>
                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Customer Name <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control @error('customer_name') is-invalid @enderror"
                                            name="customer_name"
                                            value="{{ old('customer_name') }}"
                                            placeholder="Enter the customer name"
                                        >
                                        @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Customer Phone <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="number"
                                            class="form-control @error('customer_phone') is-invalid @enderror"
                                            name="customer_phone"
                                            value="{{ old('customer_phone') }}"
                                            placeholder="Enter the customer phone"
                                        >
                                        @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Technician
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
                                    Brand <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <select
                                            class="form-control @error('brand_id') is-invalid @enderror select-2"
                                            name="brand_id"
                                        >
                                            <option value=""></option>
                                            @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>
                                                {{ $brand->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Appliance <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <select
                                            class="form-control @error('appliance_id') is-invalid @enderror select-2"
                                            name="appliance_id"
                                        >
                                            <option value=""></option>
                                            @foreach($appliances as $appliance)
                                            <option value="{{ $appliance->id }}" @selected(old('appliance_id') == $appliance->id)>
                                                {{ $appliance->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('appliance_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Fee <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <select
                                            class="form-control @error('fee_id') is-invalid @enderror select-2"
                                            name="fee_id"
                                        >
                                            <option value=""></option>
                                            @foreach($fees as $fee)
                                            <option value="{{ $fee->id }}" @selected(old('fee_id') == $fee->id)>
                                                {{ $fee->price }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('fee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Note
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <textarea
                                            class="form-control @error('note') is-invalid @enderror"
                                            name="note"
                                            placeholder="Enter the note"
                                            rows="4"
                                        >
                                            {{ old('note') }}
                                        </textarea>
                                        @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Reschedule Date <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control @error('reschedule_date') is-invalid @enderror"
                                            name="reschedule_date"
                                            value="{{ old('reschedule_date') }}"
                                            placeholder="Select the reschedule date"
                                        >
                                        @error('reschedule_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Start time <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control @error('start_time') is-invalid @enderror"
                                            name="start_time"
                                            value="{{ old('start_time') }}"
                                            placeholder="Select the start time"
                                        >
                                        @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    End time <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control @error('end_time') is-invalid @enderror"
                                            name="end_time"
                                            value="{{ old('end_time') }}"
                                            placeholder="Select the end time"
                                        >
                                        @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Customer Address <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control controls @error('customer_address') is-invalid @enderror"
                                            name="customer_address"
                                            value="{{ old('customer_address') }}"
                                            placeholder="Enter the customer address"
                                            id="address"
                                        >
                                        @error('customer_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-md-9 col-sm-12 offset-lg-3">
                                    <div id="map"></div>
                                </div>
                            </div>
                            <input
                                type="hidden"
                                name="latitude"
                                value="{{ old('latitude') }}"
                                id="latitude"
                            >
                            <input
                                type="hidden"
                                name="longitude"
                                value="{{ old('longitude') }}"
                                id="longitude"
                            >
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-9 ml-lg-auto">
                                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                                    <a href="{{ route('tickets.index') }}" class="btn btn-light-primary">Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/map.css') }}">
    <script type="module" src="{{ asset('js/map.js') }}"></script>
@endsection
@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('map.key') }}&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
    <script>
        $('select[name="user_id"]').select2({
            placeholder: 'Select the technician',
        });

        $('select[name="brand_id"]').select2({
            placeholder: 'Select the brand',
        });

        $('select[name="appliance_id"]').select2({
            placeholder: 'Select the appliance',
        });

        $('select[name="fee_id"]').select2({
            placeholder: 'Select the fee',
        });

        $('input[name="reschedule_date"]').datepicker({
            autoclose: true,
            format: 'm.d.yyyy',
        });

        $('input[name="start_time"]').timepicker({
            defaultTime: null,
            format: 'HH:mm',
            minuteStep: 5,
            showMeridian: false,
        });

        $('input[name="end_time"]').timepicker({
            defaultTime: null,
            format: 'HH:mm',
            minuteStep: 5,
            showMeridian: false,
        });
    </script>
@endsection
