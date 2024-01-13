@extends('layouts.app')
@section('title', 'Tickets')
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
                                        <td class="table-row-title w-25">Fee Note</td>
                                        <td class="table-center">{{ $ticket->fee_note }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Check Number</td>
                                        <td class="table-center">{{ $ticket->check_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Credit Card Number</td>
                                        <td class="table-center">{{ $ticket->credit_card_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Cash Amount</td>
                                        <td class="table-center">{{ $ticket->cash_amount ?: 0 }} $</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Check Amount</td>
                                        <td class="table-center">{{ $ticket->check_amount ?: 0 }} $</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Credit Card Amount</td>
                                        <td class="table-center">{{ $ticket->credit_card_amount ?: 0 }} $</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Zelle Amount</td>
                                        <td class="table-center">{{ $ticket->zelle_amount ?: 0 }} $</td>
                                    </tr>
                                    <tr>
                                        <td class="table-row-title w-25">Images</td>
                                        @if($ticket->images()->exists())
                                        <td class="table-center">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#imagesModal">See More</button>
                                            <div class="modal fade" id="imagesModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Images</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div id="carouselControls" class="carousel slide" data-ride="carousel">
                                                                <div class="carousel-inner">
                                                                    @foreach($ticket->images as $image)
                                                                    <div class="carousel-item @if($loop->first) active @endif">
                                                                        <img src="{{ asset("uploads/tickets/$image->image") }}" class="d-block w-100">
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                                <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                                                                    <span classs="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                    <span class="sr-only">Next</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @else
                                        <td>No Image</td>
                                        @endif
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
