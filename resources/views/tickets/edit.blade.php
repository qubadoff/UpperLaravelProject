@extends('layouts.app')
@section('title', 'Tickets')
@inject('carbon', 'Illuminate\Support\Carbon')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom example example-compact">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Tickets {{ $ticket->ticket_number ? "- {$ticket->ticket_number}" : '' }}</h3>
                        </div>
                    </div>
                    <form action="{{ route('tickets.update', $ticket) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                            value="{{ old('customer_name', $ticket) }}"
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
                                            value="{{ old('customer_phone', $ticket) }}"
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
                                            <option value="{{ $user->id }}" @selected(old('user_id', $ticket) == $user->id)>
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
                                            <option value="{{ $brand->id }}" @selected(old('brand_id', $ticket) == $brand->id)>
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
                                            <option value="{{ $appliance->id }}" @selected(old('appliance_id', $ticket) == $appliance->id)>
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
                                            <option value="{{ $fee->id }}" @selected(old('fee_id', $ticket) == $fee->id)>
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
                                            {{ old('note', $ticket) }}
                                        </textarea>
                                        @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Status
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <select
                                            class="form-control @error('status') is-invalid @enderror select-2"
                                            name="status"
                                        >
                                            <option value=""></option>
                                            @foreach($statuses as $status)
                                            <option value="{{ $status->value }}" @selected(old('status', $ticket->status?->value) == $status->value)>
                                                {{ str($status->name)->replace('_', ' ')->lower()->headline() }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Show Home <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <select
                                            class="form-control @error('show_home') is-invalid @enderror select-2"
                                            name="show_home"
                                        >
                                            <option value=""></option>
                                            <option value="1" @selected(old('show_home', $ticket) == 1)>Yes</option>
                                            <option value="0" @selected(old('show_home', $ticket) == 0 && is_numeric(old('show_home', $ticket)))>No</option>
                                        </select>
                                        @error('show_home')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Parts Fee
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="number"
                                            class="form-control @error('parts_fee') is-invalid @enderror"
                                            name="parts_fee"
                                            value="{{ old('parts_fee', $ticket) }}"
                                            placeholder="Enter the parts fee"
                                        >
                                        @error('parts_fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Fee Note
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <textarea
                                            class="form-control @error('fee_note') is-invalid @enderror"
                                            name="fee_note"
                                            placeholder="Enter the fee note"
                                            rows="5"
                                        >
                                            {{ old('fee_note', $ticket) }}
                                        </textarea>
                                        @error('fee_note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Check Number
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="number"
                                            class="form-control @error('check_number') is-invalid @enderror"
                                            name="check_number"
                                            value="{{ old('check_number', $ticket) }}"
                                            placeholder="Enter the check number"
                                        >
                                        @error('check_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Credit Card Number
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="number"
                                            class="form-control @error('credit_card_number') is-invalid @enderror"
                                            name="credit_card_number"
                                            value="{{ old('credit_card_number', $ticket) }}"
                                            placeholder="Enter the credit card number"
                                        >
                                        @error('credit_card_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Cash Amount
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="number"
                                            class="form-control @error('cash_amount') is-invalid @enderror"
                                            name="cash_amount"
                                            value="{{ old('cash_amount', $ticket) }}"
                                            placeholder="Enter the cash amount"
                                        >
                                        @error('cash_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Check Amount
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="number"
                                            class="form-control @error('check_amount') is-invalid @enderror"
                                            name="check_amount"
                                            value="{{ old('check_amount', $ticket) }}"
                                            placeholder="Enter the check amount"
                                        >
                                        @error('check_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Credit Card Amount
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="number"
                                            class="form-control @error('credit_card_amount') is-invalid @enderror"
                                            name="credit_card_amount"
                                            value="{{ old('credit_card_amount', $ticket) }}"
                                            placeholder="Enter the credit card amount"
                                        >
                                        @error('credit_card_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    Zelle Amount
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input
                                            type="number"
                                            class="form-control @error('zelle_amount') is-invalid @enderror"
                                            name="zelle_amount"
                                            value="{{ old('zelle_amount', $ticket) }}"
                                            placeholder="Enter the zelle amount"
                                        >
                                        @error('zelle_amount')
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
                                            value="{{ old('reschedule_date', $carbon->make($ticket->reschedule_date)->format('n.j.Y')) }}"
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
                                            value="{{ old('start_time', $carbon->make($ticket->start_time)->format('H:i')) }}"
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
                                            value="{{ old('end_time', $carbon->make($ticket->end_time)->format('H:i')) }}"
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
                                    Images
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input
                                                type="file"
                                                class="custom-file-input @error('images') is-invalid @enderror"
                                                name="images[]"
                                                accept=".jpg,.jpeg,.png"
                                                multiple
                                            >
                                            <label class="custom-file-label">Choose the images</label>
                                        </div>
                                        @error('images')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @foreach($ticket->images as $image)
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    <div class="checkbox-list">
                                        <label class="checkbox checkbox-lg checkbox-danger ml-auto">
                                            <input
                                                type="checkbox"
                                                name="delete_images[]"
                                                value="{{ $image->id }}" @checked(is_array(old('delete_images')) && in_array($image->id, old('delete_images')))
                                                multiple
                                            >
                                            <span class="mr-0"></span>
                                        </label>
                                    </div>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <img src="{{ asset("uploads/tickets/$image->image") }}" class="d-block w-100">
                                </div>
                            </div>
                            @endforeach
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
                                            value="{{ old('customer_address', $ticket) }}"
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
                                    <div class="map-container">
                                        <div id="map" data-type="map"></div>
                                    </div>
                                </div>
                            </div>
                            <input
                                type="hidden"
                                name="latitude"
                                value="{{ old('latitude', $ticket) }}"
                                id="latitude"
                            >
                            <input
                                type="hidden"
                                name="longitude"
                                value="{{ old('longitude', $ticket) }}"
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

        $('select[name="status"]').select2({
            allowClear: true,
            placeholder: 'Select the status',
        });

        $('select[name="show_home"]').select2({
            allowClear: true,
            placeholder: 'Select the show home',
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
