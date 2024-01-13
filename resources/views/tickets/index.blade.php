@extends('layouts.app')
@section('title', 'Tickets')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Tickets</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('tickets.create') }}" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i> New ticket
                            </a>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row mt-5">
                            <div class="col-12 col-md-4">
                                <div class="d-flex align-items-center rounded p-5" id="all">
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold font-size-lg">All</span>
                                    </div>
                                    <span class="label label-dot mx-3"></span>
                                    <span class="font-weight-bolder font-size-lg">{{ $all }}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex align-items-center rounded p-5" id="new">
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold font-size-lg">New</span>
                                    </div>
                                    <span class="label label-dot mx-3"></span>
                                    <span class="font-weight-bolder font-size-lg">{{ $new }}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex align-items-center rounded p-5" id="canceled">
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold font-size-lg">Canceled</span>
                                    </div>
                                    <span class="label label-dot mx-3"></span>
                                    <span class="font-weight-bolder font-size-lg">{{ $canceled }}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="d-flex align-items-center rounded p-5" id="completed">
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold font-size-lg">Completed</span>
                                    </div>
                                    <span class="label label-dot mx-3"></span>
                                    <span class="font-weight-bolder font-size-lg">{{ $completed }}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="d-flex align-items-center rounded p-5" id="part_ordered">
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold font-size-lg">Part Ordered</span>
                                    </div>
                                    <span class="label label-dot mx-3"></span>
                                    <span class="font-weight-bolder font-size-lg">{{ $partOrdered }}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="d-flex align-items-center rounded p-5" id="recall">
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold font-size-lg">Recall</span>
                                    </div>
                                    <span class="label label-dot mx-3"></span>
                                    <span class="font-weight-bolder font-size-lg">{{ $recall }}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="d-flex align-items-center rounded p-5" id="reschedule">
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold font-size-lg">Reschedule</span>
                                    </div>
                                    <span class="label label-dot mx-3"></span>
                                    <span class="font-weight-bolder font-size-lg">{{ $reschedule }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <form action="{{ route('tickets.index') }}">
                                        <tr>
                                            <th></th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control w-100 mb-3"
                                                        name="ticket_number"
                                                        value="{{ request('ticket_number') }}"
                                                        placeholder="Ticket Number"
                                                    >
                                                    <select class="form-control w-100" name="numbered_ticket">
                                                        <option value="" selected disabled>Numbered Ticket</option>
                                                        <option value="1" @selected(request('numbered_ticket') == 1)>
                                                            Yes
                                                        </option>
                                                        <option value="0" @selected(request('numbered_ticket') == 0 && is_numeric(request('numbered_ticket')))>
                                                            No
                                                        </option>
                                                    </select>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="customer_name"
                                                        value="{{ request('customer_name') }}"
                                                        placeholder="Customer Name"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="customer_phone"
                                                        value="{{ request('customer_phone') }}"
                                                        placeholder="Customer Phone"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="customer_address"
                                                        value="{{ request('customer_address') }}"
                                                        placeholder="Customer Address"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="admin"
                                                        value="{{ request('admin') }}"
                                                        placeholder="Admin"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control w-100 mb-3"
                                                        name="technician"
                                                        value="{{ request('technician') }}"
                                                        placeholder="Technician"
                                                    >
                                                    <select class="form-control w-100" name="technician_type">
                                                        <option value="" selected disabled>Technician Type</option>
                                                        <option value="1" @selected(request('technician_type') == 1)>
                                                            Internal
                                                        </option>
                                                        <option value="0" @selected(request('technician_type') == 0 && is_numeric(request('technician_type')))>
                                                            External
                                                        </option>
                                                    </select>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="fee"
                                                        value="{{ request('fee') }}"
                                                        placeholder="Fee"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <select class="form-control" name="status">
                                                        <option value="" selected disabled>Status</option>
                                                        <option value="">All</option>
                                                        @foreach($statuses as $status)
                                                        <option value="{{ $status->value }}" @selected(request('status') == $status->value)>
                                                            {{ str($status->name)->replace('_', ' ')->lower()->headline() }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control date w-100 mb-3"
                                                        name="from_date"
                                                        value="{{ request('from_date') }}"
                                                        placeholder="From Date"
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control date w-100"
                                                        name="to_date"
                                                        value="{{ request('to_date') }}"
                                                        placeholder="To Date"
                                                    >
                                                </div>
                                            </th>
                                            <th class="justify-content-between">
                                                <button type="submit" class="btn btn-primary font-weight-bolder search-btn">
                                                    <i class="la la-search"></i>
                                                </button>
                                                <a href="{{ route('tickets.index') }}" class="btn btn-secondary font-weight-bolder">
                                                    <i class="la la-close"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    </form>
                                    <tr>
                                        <th>#</th>
                                        <th>Ticket Number</th>
                                        <th>Customer Name</th>
                                        <th>Customer Phone</th>
                                        <th>Customer Address</th>
                                        <th>Admin</th>
                                        <th>Technician</th>
                                        <th>Fee</th>
                                        <th>Status</th>
                                        <th>Reschedule Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tickets as $ticket)
                                    <tr @style(['background: yellow' => $ticket?->user?->type === 0])>
                                        <td>{{ $loop->iteration }}</td>
                                        <td @style(background($ticket->status?->value))>{{ $ticket->ticket_number }}</td>
                                        <td>{{ $ticket->customer_name }}</td>
                                        <td>{{ $ticket->customer_phone }}</td>
                                        <td>{{ $ticket->customer_address }}</td>
                                        <td>{{ $ticket->admin?->full_name }}</td>
                                        <td>{{ $ticket->user?->full_name }}</td>
                                        <td>{{ $ticket->fee?->price . '$' }}</td>
                                        <td>{{ $ticket->status ? str($ticket->status->name)->replace('_', ' ')->lower()->headline() : 'New' }}</td>
                                        <td>{{ $ticket->reschedule_at }}</td>
                                        <td>
                                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-icon btn-clean mr-2">
                                                <i class="la la-cog"></i>
                                            </a>
                                            <a href="{{ route('tickets.deposit', $ticket) }}" class="btn btn-sm btn-icon btn-clean mr-2">
                                                <i class="la la-eye"></i>
                                            </a>
                                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-sm btn-icon btn-clean mr-2">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-clean">
                                                    <i class="la la-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="11">There is no information to display</td>
                                    </tr>
                                   @endforelse
                                </tbody>
                            </table>
                            <div class="float-right">{{ $tickets->appends($_GET)->links() }}</div>
                        </div>
                    </div>
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
    <script>
        $('input.date').datepicker({
            autoclose: true,
            format: 'm.d.yyyy',
            locale: 'en',
        });
    </script>
@endsection
