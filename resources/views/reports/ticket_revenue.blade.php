@extends('layouts.app')
@section('title', 'Revenue report')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Revenue report</h3>
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
                        <form action="{{ route('reports.revenue') }}">
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control date"
                                            name="from_date"
                                            value="{{ request('from_date') }}"
                                            placeholder="From Date"
                                        >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control date"
                                            name="to_date"
                                            value="{{ request('to_date') }}"
                                            placeholder="To Date"
                                        >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="technician"
                                            value="{{ request('technician') }}"
                                            placeholder="Technician Name"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="job"
                                                        value="{{ request('job') }}"
                                                        placeholder="Job"
                                                    >
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
                                                        class="form-control date"
                                                        name="date_completed"
                                                        value="{{ request('date_completed') }}"
                                                        placeholder="Date Completed"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="total_job"
                                                        value="{{ request('total_job') }}"
                                                        placeholder="Total Job"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="total_card"
                                                        value="{{ request('total_card') }}"
                                                        placeholder="Total Card"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="total_card_percent"
                                                        value="{{ request('total_card_percent') }}"
                                                        placeholder="Total Card Percent"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="full_parts_price"
                                                        value="{{ request('full_parts_price') }}"
                                                        placeholder="Full Parts Price"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="revenue"
                                                        value="{{ request('revenue') }}"
                                                        placeholder="Revenue"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="commission"
                                                        value="{{ request('commission') }}"
                                                        placeholder="Commission"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <select class="form-control" name="payment_type">
                                                        <option value="" selected disabled>
                                                            Payment Type
                                                        </option>
                                                        <option value="cash" @selected(request('payment_type') === 'cash')>
                                                            Cash
                                                        </option>
                                                        <option value="check" @selected(request('payment_type') === 'check')>
                                                            Check
                                                        </option>
                                                        <option value="credit_card" @selected(request('payment_type') === 'credit_card')>
                                                            Credit Card
                                                        </option>
                                                        <option value="zelle" @selected(request('payment_type') === 'zelle')>
                                                            Zelle
                                                        </option>
                                                    </select>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="work_description"
                                                        value="{{ request('work_description') }}"
                                                        placeholder="Work Description"
                                                    >
                                                </div>
                                            </th>
                                            <th>
                                                <button type="submit" class="btn btn-primary font-weight-bolder search-btn">
                                                    <i class="la la-search"></i>
                                                </button>
                                                <a href="{{ route('reports.revenue') }}" class="btn btn-secondary font-weight-bolder">
                                                    <i class="la la-close"></i>
                                                </a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Job</th>
                                            <th>Customer name</th>
                                            <th>Date completed</th>
                                            <th>Total job, $</th>
                                            <th>Total card</th>
                                            <th>3.5% card</th>
                                            <th>Full parts price</th>
                                            <th>Revenue, $</th>
                                            <th>Commission, $, 40%</th>
                                            <th>Payment Type</th>
                                            <th>Work description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($reports as $report)
                                        <tr>
                                            <td>{{ $reports->perPage() * ($reports->currentPage() - 1) + $loop->iteration }}</td>
                                            <td @style(background($report->status?->value))>{{ $report->job }}</td>
                                            <td>{{ $report->customer_name }}</td>
                                            <td>{{ $report->date_completed }}</td>
                                            <td>{{ $report->total_job }}</td>
                                            <td>{{ $report->total_card }}</td>
                                            <td>{{ $report->total_card_percent }}</td>
                                            <td>{{ $report->full_parts_price }}</td>
                                            <td>{{ $report->revenue }}</td>
                                            <td>{{ $report->commission }}</td>
                                            <td style="width: 500px">{!! $report->payment_type !!}</td>
                                            <td>{{ $report->work_description }}</td>
                                            <td>
                                                <a href="{{ route('tickets.edit', $report) }}" class="btn btn-sm btn-icon btn-clean mr-2">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center" colspan="13">There is no information to display</td>
                                        </tr>
                                       @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Total: </b></td>
                                            <td>{{ $totalReport->total_job ?: 0 }}$</td>
                                            <td>{{ $totalReport->total_card ?: 0 }}$</td>
                                            <td>{{ $totalReport->total_card_percent ?: 0 }}$</td>
                                            <td>{{ $totalReport->full_parts_price ?: 0 }}$</td>
                                            <td>{{ $totalReport->revenue ?: 0 }}$</td>
                                            <td>{{ $totalReport->commission ?: 0 }}$</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>TJob + TCard: </b></td>
                                            <td>{{ $totalReport->total_job_total_card ?: 0 }}$</td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Total Due: </b></td>
                                            <td>{{ $totalReport->total_due ?: 0 }}$</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Cash: </b></td>
                                            <td>{{ $totalReport->cash ?: 0 }}$</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>TD minus cash: </b></td>
                                            <td>{{ $totalReport->td_minus_cash ?: 0 }}$</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="float-right">{{ $reports->appends($_GET)->links() }}</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('input.date').datepicker({
            autoclose: true,
            format: 'm.d.yyyy',
            locale: 'en',
        });
    </script>
@endsection
