@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Ticket Details</span>
                        <div>
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('tickets.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="card-title">{{ $ticket->title }}</h5>
                    </div>

                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p class="card-text">{{ $ticket->description }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Priority:</strong>
                        <span class="badge bg-{{ $ticket->priority == 'high' ? 'danger' : ($ticket->priority == 'medium' ? 'warning' : 'info') }}">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $ticket->status == 'open' ? 'success' : ($ticket->status == 'in_progress' ? 'warning' : 'secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <strong>Created:</strong>
                        <p>{{ $ticket->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Last Updated:</strong>
                        <p>{{ $ticket->updated_at->format('Y-m-d H:i:s') }}</p>