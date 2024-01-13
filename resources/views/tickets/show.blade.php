@extends('layouts.app')
@section('title', 'Tickets')
@inject('carbon', 'Illuminate\Support\Carbon')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Tickets {{ $ticket->ticket_number ? "- {$ticket->ticket_number}" : '' }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-light table-light-success mb-0">
                                <tbody>
                                    <tr>
                                        <td class="table-row-title w-25">ID</td>
                                        <td class="table-center">{{ $ticket->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Ticket Number</td>
                                        <td class="table-center">{{ $ticket->ticket_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Customer Address</td>
                                        <td class="table-center">{{ $ticket->customer_address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Latitude</td>
                                        <td class="table-center">{{ $ticket->latitude }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Longitude</td>
                                        <td class="table-center">{{ $ticket->longitude }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Customer Name</td>
                                        <td class="table-center">{{ $ticket->customer_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Customer Phone</td>
                                        <td class="table-center">{{ $ticket->customer_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Admin</td>
                                        <td class="table-center">{{ $ticket->admin?->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Technician</td>
                                        <td class="table-center">{{ $ticket->user?->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Brand</td>
                                        <td class="table-center">{{ $ticket->brand?->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Appliance</td>
                                        <td class="table-center">{{ $ticket->appliance?->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Fee</td>
                                        <td class="table-center">{{ $ticket->fee?->price ?: 0 }} $</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Note</td>
                                        <td class="table-center">{{ $ticket->note }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Status</td>
                                        <td class="table-center">{{ $ticket->status ? str($ticket->status->name)->replace('_', ' ')->lower()->headline() : 'New' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Show Home</td>
                                        <td class="table-center">{{ $ticket->show_home ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Parts Fee</td>
                                        <td class="table-center">{{ $ticket->parts_fee }} $</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Total Fee</td>
                                        <td class="table-center">{{ $ticket->total_fee }} $</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Reschedule Date</td>
                                        <td class="table-center">{{ $carbon->make($ticket->reschedule_date)->format('n.j.Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Start time</td>
                                        <td class="table-center">{{ $carbon->make($ticket->start_time)->format('H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">End time</td>
                                        <td class="table-center">{{ $carbon->make($ticket->end_time)->format('H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Executed At</td>
                                        <td class="table-center">{{ $ticket->executed_at ? $carbon->make($ticket->executed_at)->format('n.j.Y H:i:s') : null }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-primary mr-2">Update</a>
                                <a href="{{ route('tickets.index') }}" class="btn btn-light-primary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
