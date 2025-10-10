<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de RH - <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-users text-xl"></i>
                    <h1 class="text-xl font-bold">Sistema de RH</h1>
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

    <!-- Main Content -->
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
    <footer class="bg-gray-800 text-white py-4 mt-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Sistema de RH. Todos os direitos reservados.</p>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\SESDEC - GETEC\sistema-rh\resources\views/layouts/app.blade.php ENDPATH**/ ?>