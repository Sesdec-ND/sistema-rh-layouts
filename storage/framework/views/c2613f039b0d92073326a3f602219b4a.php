

<?php $__env->startSection('title', 'Relatório de Colaboradores - RH'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Relatório de Colaboradores</h1>
                <p class="text-gray-600 mt-2">Relatório detalhado dos colaboradores do sistema</p>
            </div>
            <div class="flex space-x-3">
                <a href="<?php echo e(route('admin.relatorios.colaboradores')); ?>?download=1"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    Baixar PDF
                </a>
                <a href="<?php echo e(route('admin.relatorios')); ?>"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>
            </div>
        </div>

        <!-- Informações do Relatório -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-blue-600 font-semibold">Total de Colaboradores</div>
                    <div class="text-2xl font-bold text-gray-800"><?php echo e($total_colaboradores); ?></div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-green-600 font-semibold">Data de Geração</div>
                    <div class="text-lg font-semibold text-gray-800"><?php echo e($data_geracao); ?></div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="text-purple-600 font-semibold">Gerado por</div>
                    <div class="text-lg font-semibold text-gray-800"><?php echo e($usuario_gerador); ?></div>
                </div>
                <div class="bg-orange-50 p-4 rounded-lg">
                    <div class="text-orange-600 font-semibold">Status</div>
                    <div class="text-lg font-semibold text-gray-800">Ativos</div>
                </div>
            </div>

            <!-- Filtros Aplicados -->
            <?php if(!empty(array_filter($filtros_aplicados))): ?>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Filtros Aplicados</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $filtros_aplicados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filtro => $valor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($valor): ?>
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                    <?php echo e($filtro); ?>: <?php echo e($valor); ?>

                                </span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tabela de Colaboradores -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nome</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Matrícula</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Lotação</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Vínculo</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $colaboradores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colaborador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($colaborador->nome); ?></td>
                                <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($colaborador->matricula); ?></td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <?php echo e($colaborador->lotacao->nome ?? ($colaborador->lotacao->nome_completo ?? 'N/A')); ?>

                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <?php echo e($colaborador->vinculo->nome ?? ($colaborador->vinculo->nome_completo ?? 'N/A')); ?>

                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full <?php echo e($colaborador->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo e($colaborador->status ? 'Ativo' : 'Inativo'); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                    Nenhum colaborador encontrado com os filtros aplicados.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Rodapé do Relatório -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center text-sm text-gray-500">
                    <div>
                        <strong>Sistema de RH</strong> - Relatório gerado automaticamente
                    </div>
                    <div>
                        Página 1 de 1 - <?php echo e($data_geracao); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SESDEC - GETEC\sistema-rh\resources\views/admin/relatorios/colaboradores.blade.php ENDPATH**/ ?>