@extends('layouts.app')

@section('title', 'Submit Absence')

@section('content')
<div class="flex flex-col items-center px-6 sm:px-8 md:px-12 py-8 gap-4 mx-auto max-w-4xl bg-white shadow-lg rounded-xl card-shadow" data-aos="fade-up">
    <div class="w-full flex flex-col gap-8">
        {{-- Title --}}
        <div class="text-center">
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-2">Submit Absence Request</h1>
            <p class="text-gray-500 text-sm">Fill in the form below to submit your absence request</p>
        </div>

        {{-- Form Fields --}}
        <form action="{{ route('absence.store') }}" method="POST" class="space-y-6 w-full">
            @csrf

            {{-- Leave Category --}}
            <div class="space-y-3">
                <label class="text-base font-medium text-gray-700">Leave Category</label>
                <input type="text" name="leave_category" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Enter leave category..." required>
            </div>

            {{-- Start & End Date --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Start Date --}}
                <div class="space-y-3">
                    <label class="text-base font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                </div>
                {{-- End Date --}}
                <div class="space-y-3">
                    <label class="text-base font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                </div>
            </div>

            {{-- Description --}}
            <div class="space-y-3">
                <label class="text-base font-medium text-gray-700">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg resize-none text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Enter your description here..." required></textarea>
            </div>

            {{-- Questions Section --}}
            <div class="bg-gray-50 p-6 rounded-lg space-y-6">
                {{-- Laptop Question --}}
                <div class="space-y-4">
                    <label class="text-base font-medium text-gray-700">
                        Do you bring a laptop? <span class="text-sm text-gray-500">(if there is a super urgent matter)</span>
                    </label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="has_laptop" value="1" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 transition-all duration-200" required>
                            <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors duration-200">Yes</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="has_laptop" value="0" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 transition-all duration-200" required>
                            <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors duration-200">No</span>
                        </label>
                    </div>
                </div>

                {{-- Contactable Question --}}
                <div class="space-y-4">
                    <label class="text-base font-medium text-gray-700">
                        Can you still be contacted? <span class="text-sm text-gray-500">(if there is a super urgent matter)</span>
                    </label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="can_contact" value="1" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 transition-all duration-200" required>
                            <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors duration-200">Yes</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="can_contact" value="0" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 transition-all duration-200" required>
                            <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors duration-200">No</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center pt-6">
                <a href="{{ route('administration.absence.index') }}" class="px-8 py-3 border-2 border-gray-300 rounded-lg text-gray-700 font-medium text-center hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
