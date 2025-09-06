@extends('layouts.app')

@section('title', 'Submit Absence')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8" data-aos="fade-down">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Submit Absence Request</h1>
                <p class="text-gray-600">Fill in the form below to submit your absence request for approval</p>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-calendar-plus mr-3"></i>
                    Absence Request Form
                </h2>
            </div>

            <!-- Form Content -->
            <form action="{{ route('absence.store') }}" method="POST" class="p-6 space-y-8">
                @csrf

                <!-- Basic Information Section -->
                <div class="space-y-6">
                    <div class="border-l-4 border-blue-400 pl-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Basic Information</h3>
                        <p class="text-sm text-gray-600">Please provide the basic details of your absence request</p>
                    </div>

                    <!-- Leave Category -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-tag text-blue-500 mr-2"></i>
                            Leave Category *
                        </label>
                        <select name="leave_category" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                            <option value="">Select leave category</option>
                            <option value="annual_leave">Annual Leave</option>
                            <option value="sick_leave">Sick Leave</option>
                            <option value="personal_leave">Personal Leave</option>
                            <option value="emergency_leave">Emergency Leave</option>
                            <option value="maternity_leave">Maternity Leave</option>
                            <option value="paternity_leave">Paternity Leave</option>
                            <option value="other">Other</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Choose the type of leave that best fits your request</p>
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-calendar-alt text-green-500 mr-2"></i>
                                Start Date *
                            </label>
                            <input type="date" name="start_date"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-calendar-check text-red-500 mr-2"></i>
                                End Date *
                            </label>
                            <input type="date" name="end_date"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <!-- Duration Display -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4" id="duration-display" style="display: none;">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-600 mr-2"></i>
                            <span class="text-sm font-medium text-blue-800">Duration: </span>
                            <span id="duration-text" class="text-sm text-blue-700 ml-1"></span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-edit text-purple-500 mr-2"></i>
                            Description *
                        </label>
                        <textarea name="description" rows="4"
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg resize-none text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                  placeholder="Please provide a detailed reason for your absence request..." required></textarea>
                        <p class="text-xs text-gray-500 mt-1">Provide clear details about your absence to help with approval</p>
                    </div>
                </div>

                <!-- Availability Section -->
                <div class="space-y-6">
                    <div class="border-l-4 border-orange-400 pl-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Availability During Absence</h3>
                        <p class="text-sm text-gray-600">Please let us know about your availability during the requested period</p>
                    </div>

                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-6 space-y-6">
                        <!-- Laptop Question -->
                        <div class="space-y-4">
                            <label class="text-base font-medium text-gray-800 flex items-start">
                                <i class="fas fa-laptop text-blue-500 mr-3 mt-1"></i>
                                <div>
                                    <span>Will you have access to a laptop during your absence?</span>
                                    <p class="text-sm text-gray-600 font-normal mt-1">This helps us understand if you can handle urgent matters remotely</p>
                                </div>
                            </label>
                            <div class="flex gap-6 md:gap-8 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="has_laptop" value="1"
                                           class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500 transition-all duration-200" required>
                                    <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors duration-200 flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        Yes, I will have access
                                    </span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="has_laptop" value="0"
                                           class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500 transition-all duration-200" required>
                                    <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors duration-200 flex items-center">
                                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                        No, I won't have access
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Contact Question -->
                        <div class="space-y-4">
                            <label class="text-base font-medium text-gray-800 flex items-start">
                                <i class="fas fa-phone text-green-500 mr-3 mt-1"></i>
                                <div>
                                    <span>Can you be contacted during your absence?</span>
                                    <p class="text-sm text-gray-600 font-normal mt-1">For emergency situations or urgent work matters</p>
                                </div>
                            </label>
                            <div class="flex gap-6 md:gap-8 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="can_contact" value="1"
                                           class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500 transition-all duration-200" required>
                                    <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors duration-200 flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        Yes, I can be reached
                                    </span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="can_contact" value="0"
                                           class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500 transition-all duration-200" required>
                                    <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors duration-200 flex items-center">
                                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                        No, please don't contact me
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-6 border-t border-gray-200">
                    <a href="{{ route('administration.absence.index') }}"
                       class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Submit Request
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-start space-x-3">
                <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                <div>
                    <h3 class="font-semibold text-blue-900 mb-2">Important Information</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Absence requests should be submitted at least 3 days in advance (except for emergency situations)</li>
                        <li>• Annual leave requests require manager approval</li>
                        <li>• Sick leave may require medical documentation for periods longer than 3 days</li>
                        <li>• You will receive an email notification once your request is reviewed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.querySelector('input[name="start_date"]');
    const endDateInput = document.querySelector('input[name="end_date"]');
    const durationDisplay = document.getElementById('duration-display');
    const durationText = document.getElementById('duration-text');

    function calculateDuration() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (startDate && endDate && startDate <= endDate) {
            const timeDiff = endDate.getTime() - startDate.getTime();
            const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;

            durationText.textContent = `${dayDiff} day${dayDiff > 1 ? 's' : ''}`;
            durationDisplay.style.display = 'block';

            // Update end date minimum
            endDateInput.min = startDateInput.value;
        } else {
            durationDisplay.style.display = 'none';
        }
    }

    startDateInput.addEventListener('change', calculateDuration);
    endDateInput.addEventListener('change', calculateDuration);
});
</script>
@endsection
