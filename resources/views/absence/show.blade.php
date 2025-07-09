@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Absence Details</h1>
            <a href="{{ url()->previous() }}" class="text-blue-500 hover:underline text-sm">&larr; Back</a>
        </div>
        <div class="bg-white rounded shadow p-6">
            <dl class="divide-y divide-gray-200">
                <div class="py-3 flex justify-between">
                    <dt class="font-medium text-gray-600">Employee</dt>
                    <dd class="text-gray-900">{{ $absence->user->name }} <span class="text-xs text-gray-500">({{ $absence->user->email }})</span></dd>
                </div>
                <div class="py-3 flex justify-between">
                    <dt class="font-medium text-gray-600">Category</dt>
                    <dd class="text-gray-900 capitalize">{{ $absence->leave_category }}</dd>
                </div>
                <div class="py-3 flex justify-between">
                    <dt class="font-medium text-gray-600">Period</dt>
                    <dd class="text-gray-900">
                        {{ $absence->start_date->format('M d, Y') }} - {{ $absence->end_date->format('M d, Y') }}
                    </dd>
                </div>
                <div class="py-3 flex justify-between">
                    <dt class="font-medium text-gray-600">Description</dt>
                    <dd class="text-gray-900 text-right max-w-xs">{{ $absence->description ?: 'No description' }}</dd>
                </div>
                <div class="py-3 flex justify-between">
                    <dt class="font-medium text-gray-600">Has Laptop</dt>
                    <dd class="text-gray-900">{{ $absence->has_laptop ? 'Yes' : 'No' }}</dd>
                </div>
                <div class="py-3 flex justify-between">
                    <dt class="font-medium text-gray-600">Can Contact</dt>
                    <dd class="text-gray-900">{{ $absence->can_contact ? 'Yes' : 'No' }}</dd>
                </div>
                <div class="py-3 flex justify-between">
                    <dt class="font-medium text-gray-600">Status</dt>
                    <dd>
                        @if($absence->status == 'pending')
                            <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs">Pending</span>
                        @elseif($absence->status == 'approved')
                            <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">Approved</span>
                        @elseif($absence->status == 'rejected')
                            <span class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs">Rejected</span>
                        @endif
                    </dd>
                </div>
                <div class="py-3 flex justify-between">
                    <dt class="font-medium text-gray-600">Submitted At</dt>
                    <dd class="text-gray-900">{{ $absence->created_at->format('M d, Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
