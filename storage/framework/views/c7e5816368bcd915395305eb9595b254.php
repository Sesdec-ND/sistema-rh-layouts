<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de RH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Sistema de RH</h1>
            <div class="flex items-center space-x-4">
                <?php if(auth()->guard()->check()): ?>
                    <span>Olá, <?php echo e(auth()->user()->name); ?></span>
                    <span class="bg-blue-500 px-2 py-1 rounded"><?php echo e(auth()->user()->perfil->nomePerfil); ?></span>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-red-500 px-3 py-1 rounded hover:bg-red-600">
                            Sair
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-6 p-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</body>
</html><?php /**PATH C:\Users\SESDEC - GETEC\sistema-rh\resources\views/layouts/app.blade.php ENDPATH**/ ?>