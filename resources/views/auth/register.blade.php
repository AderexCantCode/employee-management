@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center" style="background: linear-gradient(to bottom, #4397BB 0%, #ffffff 100%);">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200" data-aos="zoom-in">
            <div class="text-center mb-8">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="mx-auto mb-2 w-100 h-100 object-contain">
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="name" required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 bg-gray-50"
                               placeholder="Enter your full name">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                        <input type="email" name="email" required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 bg-gray-50"
                               placeholder="Enter your email">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                        <input type="password" name="password" required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 bg-gray-50"
                               placeholder="Enter your password">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                        <input type="password" name="password_confirmation" required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 bg-gray-50"
                               placeholder="Confirm your password">
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-[#111111] text-white py-3 rounded-lg font-medium hover:bg-cyan-600 transition-all duration-200 shadow-md">
                    <i class="fas fa-user-plus mr-2"></i>
                    Create Account
                </button>
            </form>

            <div class="text-center mt-6">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-cyan-600 hover:text-cyan-800 font-medium">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
