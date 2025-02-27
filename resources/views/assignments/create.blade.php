@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Developer to Ticket #{{ $ticket->id }}</h1>

    <form action="{{ route('assignments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="ticket_info" class="form-label">Ticket Information</label>
            <input type="text" class="form-control" id="ticket_info" name="ticket_info" value="{{ $ticket->info }}" readonly>
        </div>
        <div class="mb-3">
            <label for="developer" class="form-label">Select Developer</label>
            <select class="form-control" id="developer" name="developer_id">
                @foreach($developers as $developer)
                    <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Assign</button>
    </form>
</div>
@endsection