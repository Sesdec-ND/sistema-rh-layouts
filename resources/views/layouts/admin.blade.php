<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin RH - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }

        .sidebar-collapsed {
            width: 70px;
        }

        .sidebar-expanded {
            width: 260px;
        }

        .main-content-collapsed {
            margin-left: 70px;
        }

        .main-content-expanded {
            margin-left: 260px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 260px;
                transform: translateX(-100%);
            }

            .sidebar-mobile-open {
                transform: translateX(0);
            }

            .main-content-collapsed,
            .main-content-expanded {
                margin-left: 0;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="sidebar sidebar-expanded bg-blue-800 text-white fixed h-full overflow-y-auto z-50" id="sidebar">
        <!-- Logo e Toggle -->
        <div class="p-4 border-b border-blue-700 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-600 p-2 rounded-lg">
                    <i class="fas fa-users-cog text-white text-xl"></i>
                </div>
                <span class="text-xl font-bold" id="logo-text">Admin RH</span>
            </div>
            <button id="sidebar-toggle" class="text-white hover:text-blue-200 lg:block hidden">
                <i class="fas fa-bars"></i>
            </button>
            <button id="sidebar-close" class="text-white hover:text-blue-200 lg:hidden">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- User Info -->
        <div class="p-4 border-b border-blue-700" id="user-info">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-600 p-2 rounded-full">
                    <i class="fas fa-user-shield text-white"></i>
                </div>
                <div>
                    <div class="font-semibold text-sm">{{ auth()->user()->name }}</div>
                    <div class="text-blue-200 text-xs">Recursos Humanos</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-200 {{ request()->routeIs('rh.dashboard') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-tachometer-alt w-6 text-center"></i>
                <span id="nav-dashboard">Dashboard</span>
            </a>

            <!-- Colaboradores -->
            <a href="{{ route('admin.colaborador') }}"
                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-200 {{ request()->routeIs('rh.colaboradores') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-users w-6 text-center"></i>
                <span id="nav-colaboradores">Colaboradores</span>
            </a>

            <!-- Relatórios -->
            <a href="{{ route('admin.relatorios.index') }}"
                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-200 {{ request()->routeIs('rh.relatorios') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-chart-bar w-6 text-center"></i>
                <span id="nav-relatorios">Relatórios</span>
            </a>

            <!-- Acesso ao Sistema -->
            <a href="{{ route('admin.acesso-sistema') }}"
                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.acesso-sistema') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-key w-6 text-center"></i>
                <span id="nav-acesso">Acesso ao Sistema</span>
            </a>

            <!-- Perfis de Acesso -->
            <a href="{{ route('admin.perfis-acesso') }}"
                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-200">
                <i class="fas fa-user-tag w-6 text-center"></i>
                <span id="nav-perfis">Perfis de Acesso</span>
            </a>

            <!-- Configurações -->
            <div class="pt-4">
                <div class="text-blue-300 text-xs font-semibold px-3 py-2 uppercase tracking-wider"
                    id="nav-config-title">
                    Configurações
                </div>
                <a href="{{ route('admin.configuracoes-sistema') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-cog w-6 text-center"></i>
                    <span id="nav-config">Configurações do Sistema</span>
                </a>
                <a href="{{ route('admin.seguranca') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-shield-alt w-6 text-center"></i>
                    <span id="nav-security">Segurança</span>
                </a>
            </div>
        </nav>

        <!-- Logout -->
        <div class="absolute bottom-0 w-full p-4 border-t border-blue-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-200 w-full text-left">
                    <i class="fas fa-sign-out-alt w-6 text-center"></i>
                    <span id="nav-logout">Sair do Sistema</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content-expanded min-h-screen transition-all duration-300" id="main-content">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between p-4">
                <!-- Left Side -->
                <div class="flex items-center space-x-4">
                    <button id="mobile-menu-toggle" class="text-gray-600 hover:text-gray-900 lg:hidden">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-2xl font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative">
                        <button class="text-gray-600 hover:text-gray-900 p-2 rounded-full hover:bg-gray-100">
                            <i class="fas fa-bell"></i>
                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                3
                            </span>
                        </button>
                    </div>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center space-x-3 text-gray-700 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100">
                            <div class="bg-blue-100 p-2 rounded-full">
                                <i class="fas fa-user-shield text-blue-600"></i>
                            </div>
                            <div class="text-left hidden md:block">
                                <div class="font-semibold text-sm">{{ auth()->user()->name }}</div>
                                <div class="text-gray-500 text-xs">Administrador RH</div>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                            <a href="{{ route('perfil-pessoal.show') }}"
                                class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-circle text-gray-400"></i>
                                <span>Meu Perfil Pessoal</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog text-gray-400"></i>
                                <span>Configurações</span>
                            </a>
                            <div class="border-t border-gray-200 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center space-x-3 px-4 py-2 text-red-600 hover:bg-gray-100 w-full text-left">
                                    <i class="fas fa-sign-out-alt text-red-400"></i>
                                    <span>Sair</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-home mr-2"></i>
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-sm font-medium text-gray-500">@yield('title', 'Dashboard')</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Alerts -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-2 rounded-full mr-3">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-green-800 font-semibold">Sucesso!</h3>
                            <p class="text-green-700 text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <div class="bg-red-100 p-2 rounded-full mr-3">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="text-red-800 font-semibold">Erro!</h3>
                            <p class="text-red-700 text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <div class="bg-red-100 p-2 rounded-full mr-3">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="text-red-800 font-semibold">Por favor, corrija os seguintes erros:</h3>
                            <ul class="text-red-700 text-sm list-disc list-inside mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4 px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-600 text-sm">
                    &copy; 2024 Sistema de RH - Todos os direitos reservados.
                </div>
                <div class="flex space-x-4 mt-2 md:mt-0">
                    <span class="text-gray-500 text-sm">
                        <i class="fas fa-user-shield mr-1"></i>
                        Acesso Administrativo
                    </span>
                    <span class="text-gray-500 text-sm">
                        <i class="fas fa-clock mr-1"></i>
                        {{ now()->format('d/m/Y H:i') }}
                    </span>
                </div>
            </div>
        </footer>
    </div>

    <!-- Mobile Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" id="mobile-overlay"></div>

    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const mobileOverlay = document.getElementById('mobile-overlay');

            // Load sidebar state from localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                collapseSidebar();
            }

            // Desktop toggle
            sidebarToggle?.addEventListener('click', function() {
                toggleSidebar();
            });

            // Mobile menu open
            mobileMenuToggle?.addEventListener('click', function() {
                sidebar.classList.add('sidebar-mobile-open');
                mobileOverlay.classList.remove('hidden');
            });

            // Mobile menu close
            sidebarClose?.addEventListener('click', function() {
                sidebar.classList.remove('sidebar-mobile-open');
                mobileOverlay.classList.add('hidden');
            });

            // Overlay click to close mobile menu
            mobileOverlay?.addEventListener('click', function() {
                sidebar.classList.remove('sidebar-mobile-open');
                mobileOverlay.classList.add('hidden');
            });

            function toggleSidebar() {
                if (sidebar.classList.contains('sidebar-collapsed')) {
                    expandSidebar();
                } else {
                    collapseSidebar();
                }
            }

            function collapseSidebar() {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
                mainContent.classList.remove('main-content-expanded');
                mainContent.classList.add('main-content-collapsed');

                // Hide text elements
                document.querySelectorAll('[id$="-text"], [id^="nav-"]').forEach(el => {
                    el.classList.add('hidden');
                });

                localStorage.setItem('sidebarCollapsed', 'true');
            }

            function expandSidebar() {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
                mainContent.classList.remove('main-content-collapsed');
                mainContent.classList.add('main-content-expanded');

                // Show text elements
                document.querySelectorAll('[id$="-text"], [id^="nav-"]').forEach(el => {
                    el.classList.remove('hidden');
                });

                localStorage.setItem('sidebarCollapsed', 'false');
            }

            // Auto-close mobile menu on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('sidebar-mobile-open');
                    mobileOverlay.classList.add('hidden');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
