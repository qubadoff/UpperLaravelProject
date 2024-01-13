@extends('layouts.app')
@section('title', 'Technicians')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Technicians</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('users.create') }}" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i> New technician
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Technician Number</th>
                                        <th>Image</th>
                                        <th>Fullname</th>
                                        <th>Birthdate</th>
                                        <th>Phone</th>
                                        <th>Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->uid }}</td>
                                        <td>{!! image('users', $user->image) !!}</td>
                                        <td>{{ $user->name . ' ' . $user->surname }}</td>
                                        <td>{{ format($user->birthdate, 'n.j.Y') }}</td>
                                        <td>{{ '+' . $user->phone }}</td>
                                        <td>{!! badge($user->type, ['Internal', 'External']) !!}</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-icon btn-clean mr-2">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST">
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
                                        <td class="text-center" colspan="7">There is no information to display</td>
                                    </tr>
                                   @endforelse
                                </tbody>
                            </table>
                            <div class="float-right">{{ $users->links() }}</div>
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
