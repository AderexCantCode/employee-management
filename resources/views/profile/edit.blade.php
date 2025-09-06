@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8" data-aos="fade-down">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
                    <p class="text-gray-600 mt-1">Update your personal information and settings</p>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-user"></i>
                    <span>Profile Settings</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-shadow" data-aos="fade-right">
                        <!-- Profile Header with Gradient -->
                        <div class="relative h-32 bg-gradient-to-r from-cyan-500 to-blue-600">
                            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                                <div class="relative">
                                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-xl overflow-hidden bg-white">
                                        @if($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" alt="Profile Picture" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);">
                                                <span class="text-4xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Change Picture Button -->
                                    <label for="avatar" class="absolute bottom-2 right-2 w-10 h-10 bg-cyan-500 rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:bg-cyan-600 transition-all duration-200 group">
                                        <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden">
                                        <i class="fas fa-camera text-white text-sm group-hover:scale-110 transition-transform"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Info -->
                        <div class="pt-20 pb-6 px-6 text-center">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-cyan-600 font-medium mt-1">{{ ucfirst($user->role ?? 'Admin') }}</p>

                            <!-- Status Badge -->
                            <div class="mt-4">
                                @php
                                    $statusColors = [
                                        'ready' => 'bg-green-100 text-green-800',
                                        'standby' => 'bg-yellow-100 text-yellow-800',
                                        'not_ready' => 'bg-red-100 text-red-800'
                                    ];
                                    $statusColor = $statusColors[$user->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                    <div class="w-2 h-2 rounded-full bg-current mr-2"></div>
                                    {{ ucfirst(str_replace('_', ' ', $user->status)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Stats Section -->
                        <div class="border-t border-gray-100 px-6 py-6">
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4">
                                    <div class="text-2xl font-bold text-blue-600">{{ $projects_count }}</div>
                                    <div class="text-xs text-gray-600 mt-1">Projects</div>
                                </div>
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4">
                                    <div class="text-2xl font-bold text-green-600">{{ $tasks_done }}</div>
                                    <div class="text-xs text-gray-600 mt-1">Tasks Done</div>
                                </div>
                                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4">
                                    <div class="text-2xl font-bold text-purple-600">{{ $leave_days }}</div>
                                    <div class="text-xs text-gray-600 mt-1">Leave Days</div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Hours Progress -->
                        <div class="border-t border-gray-100 px-6 py-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Work Hours</span>
                                <span class="text-sm text-gray-500">70%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-cyan-500 to-blue-600 h-3 rounded-full transition-all duration-500" style="width: 70%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Edit Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-shadow" data-aos="fade-left">
                        <!-- Form Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">Personal Information</h3>
                                    <p class="text-gray-600 text-sm mt-1">Update your account details and preferences</p>
                                </div>
                                <button type="submit" class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-2">
                                    <i class="fas fa-save"></i>
                                    <span>Save Changes</span>
                                </button>
                            </div>
                        </div>

                        <!-- Form Content -->
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div class="space-y-2" data-aos="fade-up" data-aos-delay="100">
                                    <label for="name" class="block text-sm font-medium text-gray-700 flex items-center space-x-2">
                                        <i class="fas fa-user text-cyan-500"></i>
                                        <span>Full Name</span>
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ $user->name }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                           required>
                                </div>

                                <!-- Status -->
                                <div class="space-y-2" data-aos="fade-up" data-aos-delay="200">
                                    <label for="status" class="block text-sm font-medium text-gray-700 flex items-center space-x-2">
                                        <i class="fas fa-circle text-cyan-500"></i>
                                        <span>Status</span>
                                    </label>
                                    <select id="status" name="status"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white"
                                            required>
                                        <option value="ready" {{ $user->status == 'ready' ? 'selected' : '' }}>✅ Ready</option>
                                        <option value="standby" {{ $user->status == 'standby' ? 'selected' : '' }}>⏳ Standby</option>
                                        <option value="not_ready" {{ $user->status == 'not_ready' ? 'selected' : '' }}>❌ Not Ready</option>
                                    </select>
                                </div>

                                <!-- Email -->
                                <div class="space-y-2" data-aos="fade-up" data-aos-delay="300">
                                    <label for="email" class="block text-sm font-medium text-gray-700 flex items-center space-x-2">
                                        <i class="fas fa-envelope text-cyan-500"></i>
                                        <span>Email Address</span>
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ $user->email }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-100 text-gray-600 cursor-not-allowed"
                                           readonly>
                                </div>

                                <!-- Phone -->
                                <div class="space-y-2" data-aos="fade-up" data-aos-delay="400">
                                    <label for="phone" class="block text-sm font-medium text-gray-700 flex items-center space-x-2">
                                        <i class="fas fa-phone text-cyan-500"></i>
                                        <span>Phone Number</span>
                                    </label>
                                    <input type="tel" id="phone" name="phone" value="{{ $user->phone ?? '0867744666778' }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                                </div>

                                <!-- Address -->
                                <div class="space-y-2 md:col-span-2" data-aos="fade-up" data-aos-delay="500">
                                    <label for="address" class="block text-sm font-medium text-gray-700 flex items-center space-x-2">
                                        <i class="fas fa-map-marker-alt text-cyan-500"></i>
                                        <span>Address</span>
                                    </label>
                                    <input type="text" id="address" name="address" value="{{ $user->address ?? 'Semarang, Central Java' }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                                </div>

                                <!-- Birth Date -->
                                <div class="space-y-2" data-aos="fade-up" data-aos-delay="600">
                                    <label for="birth_date" class="block text-sm font-medium text-gray-700 flex items-center space-x-2">
                                        <i class="fas fa-birthday-cake text-cyan-500"></i>
                                        <span>Birth Date</span>
                                    </label>
                                    <input type="date" id="birth_date" name="birth_date" value="{{ $user->birth_date ?? '2006-02-13' }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center space-x-2">
                                    <i class="fas fa-lock text-cyan-500"></i>
                                    <span>Change Password</span>
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- New Password -->
                                    <div class="space-y-2" data-aos="fade-up" data-aos-delay="700">
                                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                        <input type="password" id="password" name="password" placeholder="Leave blank to keep current password"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="space-y-2" data-aos="fade-up" data-aos-delay="800">
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* Custom styles for enhanced design */
.card-shadow {
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.card-shadow:hover {
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

/* Input focus animations */
input:focus, select:focus {
    transform: translateY(-1px);
}

/* Button hover animations */
button:hover {
    transform: translateY(-2px);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #06b6d4, #3b82f6);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #0891b2, #2563eb);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .grid.grid-cols-1.lg\\:grid-cols-3 {
        grid-template-columns: 1fr;
    }

    .lg\\:col-span-1, .lg\\:col-span-2 {
        grid-column: span 1;
    }
}

/* Animation delays for staggered effect */
.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Status indicator pulse animation */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

.status-indicator {
    animation: pulse 2s infinite;
}
</style>

<script>
// Preview uploaded image
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const avatar = document.querySelector('.w-32.h-32 img, .w-32.h-32 > div');
            if (avatar.tagName === 'IMG') {
                avatar.src = e.target.result;
            } else {
                // Replace the placeholder div with an img
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-cover';
                img.alt = 'Profile Picture';
                avatar.parentNode.replaceChild(img, avatar);
            }
        };
        reader.readAsDataURL(file);
    }
});

// Add subtle animations on input focus
document.querySelectorAll('input, select').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('transform', 'scale-105');
    });

    input.addEventListener('blur', function() {
        this.parentElement.classList.remove('transform', 'scale-105');
    });
});
</script>
@endsection
