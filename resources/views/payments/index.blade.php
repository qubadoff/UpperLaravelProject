@extends('layouts.app')
@section('title', 'Payments')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Payments</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('payments.create') }}" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i> New payment
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <form action="{{ route('payments.index') }}">
                                        <tr>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="id"
                                                        value="{{ request('id') }}"
                                                        placeholder="ID"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="technician"
                                                    value="{{ request('technician') }}"
                                                    placeholder="Technician"
                                                >
                                                <br>
                                                <select class="form-control" name="technician_type">
                                                    <option value="" selected disabled>Technician Type</option>
                                                    <option value="1" @selected(request('technician_type') == 1)>
                                                        Internal
                                                    </option>
                                                    <option value="0" @selected(request('technician_type') == 0 && is_numeric(request('technician_type')))>
                                                        External
                                                    </option>
                                                </select>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="amount"
                                                        value="{{ request('amount') }}"
                                                        placeholder="Amount"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control date"
                                                        name="from_date"
                                                        value="{{ request('from_date') }}"
                                                        placeholder="From Date"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control date"
                                                        name="to_date"
                                                        value="{{ request('to_date') }}"
                                                        placeholder="To Date"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <button type="submit" class="btn btn-primary font-weight-bolder search-btn">
                                                    <i class="la la-search"></i>
                                                </button>
                                                <a href="{{ route('payments.index') }}" class="btn btn-secondary font-weight-bolder">
                                                    <i class="la la-close"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    </form>
                                    <tr>
                                        <th>ID</th>
                                        <th>Technician</th>
                                        <th>Amount</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>{{ $payment->user?->name . ' ' . $payment->user?->surname }}</td>
                                        <td>{{ $payment->amount . '$' }}</td>
                                        <td>{{ format($payment->from_date, 'n.j.Y') }}</td>
                                        <td>{{ format($payment->to_date, 'n.j.Y') }}</td>
                                        <td>
                                            <form action="{{ route('payments.destroy', $payment) }}" method="POST">
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
                                        <td class="text-center" colspan="6">There is no information to display</td>
                                    </tr>
                                     @endforelse
                                </tbody>
                            </table>
                            <div class="float-right">{{ $payments->links() }}</div>
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
            format: 'yyyy-mm-dd',
            locale: 'en',
        });
    </script>
@endsection
