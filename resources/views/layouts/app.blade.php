<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Project Management</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- End Tailwind CSS -->

    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .sidebar-gradient {
            background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
        }

        .card-shadow {
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .sidebar-active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .sidebar-active .sidebar-icon {
            color: white !important;
        }

        .sidebar-active .sidebar-text {
            color: white !important;
        }

        .sidebar-active .w-8 {
            background: rgba(255, 255, 255, 0.2) !important;
        }

        .sidebar {
            position: fixed;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            width: 48px;
            height: 340px;
            display: flex;
            flex-direction: column;
            gap: 22px;
            z-index: 40;
            padding: 0;
            background: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-item {
            width: 48px;
            height: 48px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: block;
        }
        .nav-item:hover {
            transform: translateX(4px);
        }
        .nav-circle {
            position: absolute;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #F5F5F5;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .nav-item.active .nav-circle {
            background: linear-gradient(135deg, #6FAEC9 0%, #5a9bb8 100%);
            box-shadow: 0 4px 12px rgba(111, 174, 201, 0.25);
        }
        .nav-item:hover .nav-circle {
            background: #e8e8e8;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        }
        .nav-item.active:hover .nav-circle {
            background: linear-gradient(135deg, #5a9bb8 0%, #4a8aa5 100%);
            box-shadow: 0 6px 16px rgba(111, 174, 201, 0.32);
        }
        .nav-icon {
            position: absolute;
            width: 24px;
            height: 24px;
            left: 12px;
            top: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            color: #7D7D7D;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-item.active .nav-icon {
            color: #FFFFFF;
        }
        .nav-item:hover .nav-icon {
            color: #5a5a5a;
            transform: scale(1.08);
        }
        .nav-item.active:hover .nav-icon {
            color: #FFFFFF;
            transform: scale(1.08);
        }
        .tooltip {
            position: absolute;
            left: 58px;
            top: 50%;
            transform: translateY(-50%);
            background: #333;
            color: white;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }
        .tooltip::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #333;
        }
        .nav-item:hover .tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateY(-50%) translateX(4px);
        }

        /* Main content with proper spacing from sidebar */
        .main-content {
            margin-left: 100px !important;
            width: calc(100% - 100px) !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: 0;
                right: 0;
                bottom: 0;
                top: auto;
                width: 100vw;
                height: 64px;
                flex-direction: row;
                align-items: center;
                justify-content: space-around;
                background: #fff;
                box-shadow: 0 -2px 12px rgba(0,0,0,0.08);
                border-top-left-radius: 16px;
                border-top-right-radius: 16px;
                transform: none;
                padding: 0 8px;
            }
            .nav-item {
                width: 48px;
                height: 48px;
                margin: 0 2px;
            }
            .nav-circle {
                width: 48px;
                height: 48px;
            }
            .tooltip {
                left: 50%;
                top: -8px;
                transform: translate(-50%, -100%);
                background: #333;
                color: #fff;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 11px;
                opacity: 0;
                visibility: hidden;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1000;
                box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            }
            .nav-item:hover .tooltip {
                opacity: 1;
                visibility: visible;
                transform: translate(-50%, -120%);
            }
            .main-content {
                margin-left: 0 !important;
                margin-bottom: 80px !important;
                width: 100% !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    @auth
    <!-- Navbar -->
   <nav class="bg-white text-gray-900 shadow-lg sticky top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-25 h-25 object-contain ">
                    </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('profile.edit') }}" class="w-10 h-10 bg-cyan-100 rounded-full flex items-center justify-center hover:shadow-lg transition-all duration-200 overflow-hidden">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset(auth()->user()->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover border">
                            @else
                                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);">
                                    <span class="text-white font-bold text-base">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </a>
                        <div>
                            <div class="font-medium">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:bg-cyan-100 p-2 rounded-lg transition-all duration-200 text-cyan-600">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="nav-circle"></div>
            <div class="nav-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="tooltip">Dashboard</div>
        </a>
        <a href="{{ route('project.index') }}" class="nav-item {{ request()->routeIs('project.*') ? 'active' : '' }}">
            <div class="nav-circle"></div>
            <div class="nav-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="tooltip">Projects</div>
        </a>
        <a href="{{ route('tasks.index') }}" class="nav-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
            <div class="nav-circle"></div>
            <div class="nav-icon">
                <i class="fas fa-check-square"></i>
            </div>
            <div class="tooltip">Tasks</div>
        </a>
        <a href="{{ route('activities.index') }}" class="nav-item {{ request()->routeIs('activities.*') ? 'active' : '' }}">
            <div class="nav-circle"></div>
            <div class="nav-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="tooltip">Activities</div>
        </a>
        <a href="{{ route('administration.absence.index') }}" class="nav-item {{ request()->routeIs('administration.*') ? 'active' : '' }}">
            <div class="nav-circle"></div>
            <div class="nav-icon">
                <i class="fas fa-cog"></i>
            </div>
            <div class="tooltip">Administration</div>
        </a>
        @if(auth()->user()->role !== 'employee')
        <a href="{{ route('sdm.index') }}" class="nav-item {{ request()->routeIs('sdm.*') ? 'active' : '' }}">
            <div class="nav-circle"></div>
            <div class="nav-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="tooltip">SDM</div>
        </a>
        @endif
    </aside>

        <!-- Main Content -->
        <main class="main-content p-6 bg-gray-50">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center space-x-2" data-aos="fade-down">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" data-aos="fade-down">
                    <div class="flex items-center space-x-2 mb-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="font-medium">Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    @endauth

    @guest
        @yield('content')
    @endguest

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>

    <!-- Chart.js CDN (tambahkan jika ingin menampilkan chart) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
