@extends('app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endpush

@section('content')
<div class="card mt-3">
    <a href="/logout">logout</a>
    <div class="card-header">
        <input type="text" class="form-control" placeholder="Search...">
    </div>
    <ul class="list-group list-group-flush">
        @foreach ($users as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                        <div>
                            <a href="/chat/{{ $user->id }}">
                                <h6 class="mb-0">{{ $user->username }}</h6>
                                <small>Hi Im {{ $user->username }} my age {{ $user->age }}</small>
                            </a>
                        </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
