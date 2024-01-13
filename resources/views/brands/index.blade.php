@extends('layouts.app')
@section('title', 'Brands')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Brands</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('brands.create') }}" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i> New brand
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($brands as $brand)
                                    <tr>
                                        <td>{{ $brand->id }}</td>
                                        <td>{{ $brand->name }}</td>
                                        <td>{!! badge($brand->status, ['Active', 'Inactive']) !!}</td>
                                        <td>
                                            <a href="{{ route('brands.edit', $brand) }}" class="btn btn-sm btn-icon btn-clean mr-2">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <form action="{{ route('brands.destroy', $brand) }}" method="POST">
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
                                        <td class="text-center" colspan="4">There is no information to display</td>
                                    </tr>
                                   @endforelse
                                </tbody>
                            </table>
                            <div class="float-right">{{ $brands->links() }}</div>
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
@endsection
