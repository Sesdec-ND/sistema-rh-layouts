<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de RH - <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar-transition {
            transition: all 0.3s ease;
        }
        .content-transition {
            transition: margin-left 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-100">
    
    <!-- Top Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <button id="sidebarToggle" class="text-white hover:bg-blue-700 p-2 rounded-lg transition duration-200">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center space-x-2 hover:text-blue-200 transition duration-200">
                        <i class="fas fa-users text-xl"></i>
                        <h1 class="text-xl font-bold">Sistema de RH</h1>
                    </a>
                </div>
                
                <?php if(auth()->guard()->check()): ?>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <div class="font-semibold"><?php echo e(auth()->user()->name); ?></div>
                        <div class="text-blue-200 text-sm"><?php echo e(auth()->user()->perfil->nomePerfil); ?></div>
                    </div>
                    <div class="bg-blue-500 px-3 py-1 rounded-full text-sm">
                        <i class="fas fa-user-shield mr-1"></i>
                        <?php echo e(auth()->user()->perfil->nomePerfil); ?>

                    </div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Sair
                        </button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Layout -->
    <div class="flex">
        <!-- Sidebar Navigation -->
        <div id="sidebar" class="bg-white shadow-lg sidebar-transition w-64 min-h-screen">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold text-gray-700">Menu</h2>
            </div>
            <nav class="mt-4">
                <ul>
                    <li class="mb-2">
                        <a href="<?php echo e(route('dashboard')); ?>" 
                           class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    
                    <?php if(auth()->user()->perfil->nomePerfil === 'Administrador'): ?>
                    <li class="mb-2">
                        <a href="<?php echo e(route('usuarios.index')); ?>" 
                           class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                            <i class="fas fa-user-cog mr-3"></i>
                            <span>Usuários</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div id="mainContent" class="content-transition flex-1">
            <div class="container mx-auto px-4 py-6">
                <?php if(session('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <i class="fas fa-check-circle mr-2"></i>
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>

            <!-- Footer -->
            <footer class="bg-slate-800 mt-auto">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <p class="text-center text-sm text-gray-300">
                        &copy; <?php echo e(date('Y')); ?> Sistema de RH. Todos os direitos reservados.
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarIcon = sidebarToggle.querySelector('i');
            
            let isSidebarCollapsed = false;

            sidebarToggle.addEventListener('click', function() {
                if (isSidebarCollapsed) {
                    // Expandir sidebar
                    sidebar.classList.remove('w-16');
                    sidebar.classList.add('w-64');
                    mainContent.classList.remove('ml-16');
                    mainContent.classList.add('ml-64');
                    sidebarIcon.classList.remove('fa-bars');
                    sidebarIcon.classList.add('fa-bars');
                    
                    // Mostrar textos dos itens do menu
                    const menuItems = sidebar.querySelectorAll('li span');
                    menuItems.forEach(item => {
                        item.classList.remove('hidden');
                    });
                    
                    const menuHeaders = sidebar.querySelectorAll('h2');
                    menuHeaders.forEach(header => {
                        header.classList.remove('hidden');
                    });
                } else {
                    // Recolher sidebar
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-16');
                    mainContent.classList.remove('ml-64');
                    mainContent.classList.add('ml-16');
                    sidebarIcon.classList.remove('fa-bars');
                    sidebarIcon.classList.add('fa-bars');
                    
                    // Esconder textos dos itens do menu
                    const menuItems = sidebar.querySelectorAll('li span');
                    menuItems.forEach(item => {
                        item.classList.add('hidden');
                    });
                    
                    const menuHeaders = sidebar.querySelectorAll('h2');
                    menuHeaders.forEach(header => {
                        header.classList.add('hidden');
                    });
                }
                
                isSidebarCollapsed = !isSidebarCollapsed;
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH /opt/lampp/htdocs/sistema-rh-layouts/resources/views/layouts/app.blade.php ENDPATH**/ ?>