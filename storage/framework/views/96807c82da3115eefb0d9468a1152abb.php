<?php $__env->startSection('title', 'Colaboradores - RH'); ?>

<?php $__env->startSection('content'); ?>

    
    
    
    <div class="space-y-6">
        <!-- Header da Página -->
        <div class="flex space-x-3">
            

            <button type="button" onclick="abrirModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Novo Colaborador
            </button>
        </div>

        <!-- Mensagens de Sucesso/Erro -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo e(session('error')); ?></span>
            </div>
        <?php endif; ?>

        <!-- Tabela de Servidores -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Servidor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                E-mail</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">CPF
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Matrícula</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $servidores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servidor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0 overflow-hidden">
                                            <?php if($servidor->foto): ?>
                                                <img src="<?php echo e(Storage::url($servidor->foto)); ?>"
                                                    alt="<?php echo e($servidor->nome_completo); ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div
                                                    class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-semibold text-gray-900"><?php echo e($servidor->nome_completo); ?></div>
                                            <div class="text-sm text-gray-500">RG: <?php echo e($servidor->rg); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo e($servidor->email); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo e($servidor->cpf); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo e($servidor->matricula); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($servidor->status): ?>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Ativo</span>
                                    <?php else: ?>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Inativo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <!-- Botão Visualizar -->
                                        <a href="<?php echo e(route('servidores.show', $servidor->id)); ?>"
                                            

                                            <button onclick="abrirModalServidor(<?php echo e($servidor->id); ?>)"
                                                class="bg-green-100 hover:bg-green-200 text-green-600 p-2 rounded-lg transition duration-200">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </a>


                                        <!-- Botão Editar -->
                                        <a href="<?php echo e(route('servidores.edit', $servidor->id)); ?>"
                                            class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg transition duration-200"
                                            title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Botão Deletar -->
                                        <form action="<?php echo e(route('servidores.destroy', $servidor->id)); ?>" method="POST"
                                            class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200"
                                                title="Deletar"
                                                onclick="return confirm('Tem certeza que deseja deletar este servidor?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-10 text-gray-500">
                                    Nenhum servidor encontrado. Clique em "Cadastrar Novo Servidor" para começar.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    
    
    <div id="modalNovoServidor" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div
            class="relative top-10 mx-auto p-5 border w-11/12 md:w-4/5 lg:w-3/4 xl:w-2/3 shadow-lg rounded-xl bg-white max-h-[90vh] overflow-y-auto">

            <!-- Header do Modal -->
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-2xl font-bold text-gray-800">Cadastrar Novo Servidor</h3>
                <button onclick="fecharModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <!-- Formulário -->
            <form id="formNovoServidor" action="<?php echo e(route('servidores.store')); ?>" method="POST"
                enctype="multipart/form-data" class="mt-4">
                <?php echo csrf_field(); ?>

                <!-- Abas -->
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 overflow-x-auto">
                        <button type="button" onclick="abrirAba('servidor')"
                            class="aba py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 whitespace-nowrap">
                            <i class="fas fa-user mr-2"></i>Servidor
                        </button>
                        <button type="button" onclick="abrirAba('ocorrencias')"
                            class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-exclamation-circle mr-2"></i>Ocorrências
                        </button>
                        <button type="button" onclick="abrirAba('lotacao')"
                            class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-building mr-2"></i>Lotação
                        </button>
                        <button type="button" onclick="abrirAba('vinculo')"
                            class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-link mr-2"></i>Vínculo
                        </button>
                        <button type="button" onclick="abrirAba('dependentes')"
                            class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-users mr-2"></i>Dependentes
                        </button>
                        <button type="button" onclick="abrirAba('pagamento')"
                            class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-money-bill-wave mr-2"></i>Pagamento
                        </button>
                        <button type="button" onclick="abrirAba('ferias')"
                            class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-umbrella-beach mr-2"></i>Férias
                        </button>
                        <button type="button" onclick="abrirAba('formacao')"
                            class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-graduation-cap mr-2"></i>Formação
                        </button>
                        <button type="button" onclick="abrirAba('cursos')"
                            class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            <i class="fas fa-book mr-2"></i>Cursos
                        </button>
                    </nav>
                </div>

                <!-- Conteúdo das Abas -->
                <div class="py-6">

                    <!-- Aba Servidor -->
                    <div id="aba-servidor" class="aba-conteudo">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Coluna da Foto -->
                            <div class="md:col-span-1">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-32 h-32 bg-gray-200 rounded-full mb-4 flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                                        <img id="fotoPreview" src="" alt="Preview"
                                            class="hidden w-full h-full object-cover">
                                        <i class="fas fa-camera text-gray-400 text-2xl" id="fotoIcone"></i>
                                    </div>
                                    <label
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg cursor-pointer transition duration-200">
                                        <i class="fas fa-upload mr-2"></i>Upload Foto
                                        <input type="file" name="foto" id="foto" class="hidden"
                                            accept="image/*" onchange="previewFoto(this)">
                                    </label>
                                    <p class="text-xs text-gray-500 mt-2">JPG, PNG max 2MB</p>
                                </div>
                            </div>

                            <!-- Coluna dos Dados -->
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-3">Dados Pessoais</h4>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Matrícula *</label>
                                        <input type="text" name="matricula" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
                                        <input type="text" name="nome_completo" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">CPF *</label>
                                        <input type="text" name="cpf" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="000.000.000-00">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">RG *</label>
                                        <input type="text" name="rg" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">E-mail *</label>
                                        <input type="email" name="email" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="exemplo@dominio.com">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Data Nascimento
                                            *</label>
                                        <input type="date" name="data_nascimento" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Gênero *</label>
                                        <select name="genero" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Selecione</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Feminino">Feminino</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado Civil</label>
                                        <select name="estado_civil"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Selecione</option>
                                            <option value="Solteiro">Solteiro</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Viúvo">Viúvo</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                                        <input type="text" name="telefone"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="(00) 00000-0000">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                                        <input type="text" name="endereco"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Sanguíneo</label>
                                        <select name="tipo_sanguineo"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Selecione</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">PIS/PASEP</label>
                                        <input type="text" name="pispasep"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2 mt-4">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-3">Dados Profissionais</h4>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Data Nomeação</label>
                                        <input type="date" name="data_nomeacao"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select name="status"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="1">Ativo</option>
                                            <option value="0">Inativo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aba Ocorrências -->
                    <div id="aba-ocorrencias" class="aba-conteudo hidden">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold text-gray-800">Ocorrências</h4>
                            <button type="button" onclick="adicionarOcorrencia()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                                <i class="fas fa-plus mr-2"></i> Nova Ocorrência
                            </button>
                        </div>
                        <div id="ocorrencias-container" class="space-y-4">
                            <!-- Ocorrências serão adicionadas aqui -->
                        </div>
                    </div>

                    <!-- Aba Lotação -->
                    <div id="aba-lotacao" class="aba-conteudo hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Órgão</label>
                                <input type="text" name="lotacao_orgao"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                                <input type="text" name="lotacao_departamento"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cargo</label>
                                <input type="text" name="lotacao_cargo"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Data de Admissão</label>
                                <input type="date" name="lotacao_data_admissao"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Aba Vínculo -->
                    <div id="aba-vinculo" class="aba-conteudo hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Vínculo</label>
                                <select name="vinculo_tipo"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Selecione</option>
                                    <option value="Efetivo">EFETIVO</option>
                                    <option value="Comissionado">COMISSIONADO</option>
                                    <option value="Temporário">TEMPORÁRIO</option>
                                    <option value="Estagiário">ESTAGIÁRIO</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Regime</label>
                                <select name="vinculo_regime"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Selecione</option>
                                    <option value="Estatutário">ESTATUTÁRIO</option>
                                    <option value="Autônomo">VOLUNTÁRIO</option>
                                    <option value="Autônomo">COMISSIONADO</option>
                                    <option value="Autônomo">PVSA</option>


                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Carga Horária</label>
                                <input type="text" name="vinculo_carga_horaria"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ex: 40h semanais">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Salário Base</label>
                                <input type="text" name="vinculo_salario_base"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="R$ 0,00">
                            </div>
                        </div>
                    </div>

                    <!-- Aba Dependentes -->
                    <div id="aba-dependentes" class="aba-conteudo hidden">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold text-gray-800">Dependentes</h4>
                            <button type="button" onclick="adicionarDependente()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                                <i class="fas fa-plus mr-2"></i> Novo Dependente
                            </button>
                        </div>
                        <div id="dependentes-container" class="space-y-4">
                            <!-- Dependentes serão adicionados aqui -->
                        </div>
                    </div>

                    <!-- Aba Pagamento -->
                    <div id="aba-pagamento" class="aba-conteudo hidden">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold text-gray-800">Histórico de Pagamento</h4>
                            <button type="button" onclick="adicionarPagamento()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                                <i class="fas fa-plus mr-2"></i> Novo Pagamento
                            </button>
                        </div>
                        <div id="pagamentos-container" class="space-y-4">
                            <!-- Pagamentos serão adicionados aqui -->
                        </div>
                    </div>

                    <!-- Aba Férias -->
                    <div id="aba-ferias" class="aba-conteudo hidden">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold text-gray-800">Histórico de Férias</h4>
                            <button type="button" onclick="adicionarFerias()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                                <i class="fas fa-plus mr-2"></i> Novo Período
                            </button>
                        </div>
                        <div id="ferias-container" class="space-y-4">
                            <!-- Férias serão adicionadas aqui -->
                        </div>
                    </div>

                    <!-- Aba Formação -->
                    <div id="aba-formacao" class="aba-conteudo hidden">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold text-gray-800">Formação Acadêmica</h4>
                            <button type="button" onclick="adicionarFormacao()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                                <i class="fas fa-plus mr-2"></i> Nova Formação
                            </button>
                        </div>
                        <div id="formacoes-container" class="space-y-4">
                            <!-- Formações serão adicionadas aqui -->
                        </div>
                    </div>

                    <!-- Aba Cursos -->
                    <div id="aba-cursos" class="aba-conteudo hidden">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold text-gray-800">Cursos e Capacitações</h4>
                            <button type="button" onclick="adicionarCurso()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                                <i class="fas fa-plus mr-2"></i> Novo Curso
                            </button>
                        </div>
                        <div id="cursos-container" class="space-y-4">
                            <!-- Cursos serão adicionados aqui -->
                        </div>
                    </div>

                </div>

                <!-- Footer do Modal -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="fecharModal()"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i> Salvar Servidor
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Contadores para campos dinâmicos
        let ocorrenciaCount = 0;
        let dependenteCount = 0;
        let pagamentoCount = 0;
        let feriasCount = 0;
        let formacaoCount = 0;
        let cursoCount = 0;

        // =============================================
        // FUNÇÕES PRINCIPAIS DO MODAL
        // =============================================

        function abrirModal() {
            document.getElementById('modalNovoServidor').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            abrirAba('servidor');
        }

        function fecharModal() {
            document.getElementById('modalNovoServidor').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function abrirAba(abaNome) {
            // Esconde todas as abas
            document.querySelectorAll('.aba-conteudo').forEach(aba => {
                aba.classList.add('hidden');
            });

            // Remove estilo ativo de todas as abas
            document.querySelectorAll('.aba').forEach(aba => {
                aba.classList.remove('border-blue-500', 'text-blue-600');
                aba.classList.add('border-transparent', 'text-gray-500');
            });

            // Mostra aba selecionada
            document.getElementById('aba-' + abaNome).classList.remove('hidden');

            // Ativa estilo da aba selecionada
            const abaButton = document.querySelector(`[onclick="abrirAba('${abaNome}')"]`);
            abaButton.classList.add('border-blue-500', 'text-blue-600');
            abaButton.classList.remove('border-transparent', 'text-gray-500');
        }

        // Preview da Foto
        function previewFoto(input) {
            const preview = document.getElementById('fotoPreview');
            const icon = document.getElementById('fotoIcone');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    icon.classList.add('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // =============================================
        // FUNÇÕES PARA CAMPOS DINÂMICOS
        // =============================================

        // Ocorrências
        function adicionarOcorrencia() {
            ocorrenciaCount++;
            const html = `
        <div class="ocorrencia-item border border-gray-200 rounded-lg p-4 bg-gray-50">
            <div class="flex justify-between items-center mb-3">
                <h5 class="font-semibold text-gray-800">Ocorrência ${ocorrenciaCount}</h5>
                <button type="button" onclick="removerOcorrencia(this)" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data</label>
                    <input type="date" name="ocorrencias[${ocorrenciaCount-1}][data]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                    <select name="ocorrencias[${ocorrenciaCount-1}][tipo]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Selecione</option>
                        <option value="Advertência">Advertência</option>
                        <option value="Suspensão">Suspensão</option>
                        <option value="Elogio">Elogio</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                    <textarea name="ocorrencias[${ocorrenciaCount-1}][descricao]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
            </div>
        </div>
    `;
            document.getElementById('ocorrencias-container').insertAdjacentHTML('beforeend', html);
        }

        function removerOcorrencia(button) {
            button.closest('.ocorrencia-item').remove();
            atualizarContadores('.ocorrencia-item', 'Ocorrência');
        }

        // Dependentes
        function adicionarDependente() {
            dependenteCount++;
            const html = `
        <div class="dependente-item border border-gray-200 rounded-lg p-4 bg-gray-50">
            <div class="flex justify-between items-center mb-3">
                <h5 class="font-semibold text-gray-800">Dependente ${dependenteCount}</h5>
                <button type="button" onclick="removerDependente(this)" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                    <input type="text" name="dependentes[${dependenteCount-1}][nome]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parentesco</label>
                    <select name="dependentes[${dependenteCount-1}][parentesco]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Selecione</option>
                        <option value="Filho(a)">Filho(a)</option>
                        <option value="Cônjuge">Cônjuge</option>
                        <option value="Pai/Mãe">Pai/Mãe</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Nascimento</label>
                    <input type="date" name="dependentes[${dependenteCount-1}][data_nascimento]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                    <input type="text" name="dependentes[${dependenteCount-1}][cpf]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
        </div>
    `;
            document.getElementById('dependentes-container').insertAdjacentHTML('beforeend', html);
        }

        function removerDependente(button) {
            button.closest('.dependente-item').remove();
            atualizarContadores('.dependente-item', 'Dependente');
        }

        // Pagamentos
        function adicionarPagamento() {
            pagamentoCount++;
            const html = `
        <div class="pagamento-item border border-gray-200 rounded-lg p-4 bg-gray-50">
            <div class="flex justify-between items-center mb-3">
                <h5 class="font-semibold text-gray-800">Pagamento ${pagamentoCount}</h5>
                <button type="button" onclick="removerPagamento(this)" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mês/Ano</label>
                    <input type="month" name="pagamentos[${pagamentoCount-1}][mes_ano]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                    <input type="text" name="pagamentos[${pagamentoCount-1}][valor]" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="R$ 0,00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="pagamentos[${pagamentoCount-1}][status]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="Pago">Pago</option>
                        <option value="Pendente">Pendente</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>
            </div>
        </div>
    `;
            document.getElementById('pagamentos-container').insertAdjacentHTML('beforeend', html);
        }

        function removerPagamento(button) {
            button.closest('.pagamento-item').remove();
            atualizarContadores('.pagamento-item', 'Pagamento');
        }

        // Férias
        function adicionarFerias() {
            feriasCount++;
            const html = `
        <div class="ferias-item border border-gray-200 rounded-lg p-4 bg-gray-50">
            <div class="flex justify-between items-center mb-3">
                <h5 class="font-semibold text-gray-800">Férias ${feriasCount}</h5>
                <button type="button" onclick="removerFerias(this)" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Início</label>
                    <input type="date" name="ferias[${feriasCount-1}][data_inicio]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Fim</label>
                    <input type="date" name="ferias[${feriasCount-1}][data_fim]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dias</label>
                    <input type="number" name="ferias[${feriasCount-1}][dias]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
        </div>
    `;
            document.getElementById('ferias-container').insertAdjacentHTML('beforeend', html);
        }

        function removerFerias(button) {
            button.closest('.ferias-item').remove();
            atualizarContadores('.ferias-item', 'Férias');
        }

        // Formação
        function adicionarFormacao() {
            formacaoCount++;
            const html = `
        <div class="formacao-item border border-gray-200 rounded-lg p-4 bg-gray-50">
            <div class="flex justify-between items-center mb-3">
                <h5 class="font-semibold text-gray-800">Formação ${formacaoCount}</h5>
                <button type="button" onclick="removerFormacao(this)" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Curso</label>
                    <input type="text" name="formacoes[${formacaoCount-1}][curso]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instituição</label>
                    <input type="text" name="formacoes[${formacaoCount-1}][instituicao]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nível</label>
                    <select name="formacoes[${formacaoCount-1}][nivel]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Selecione</option>
                        <option value="Graduação">Graduação</option>
                        <option value="Pós-Graduação">Pós-Graduação</option>
                        <option value="Mestrado">Mestrado</option>
                        <option value="Doutorado">Doutorado</option>
                        <option value="Técnico">Técnico</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ano Conclusão</label>
                    <input type="number" name="formacoes[${formacaoCount-1}][ano_conclusao]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
        </div>
    `;
            document.getElementById('formacoes-container').insertAdjacentHTML('beforeend', html);
        }

        function removerFormacao(button) {
            button.closest('.formacao-item').remove();
            atualizarContadores('.formacao-item', 'Formação');
        }

        // Cursos
        function adicionarCurso() {
            cursoCount++;
            const html = `
        <div class="curso-item border border-gray-200 rounded-lg p-4 bg-gray-50">
            <div class="flex justify-between items-center mb-3">
                <h5 class="font-semibold text-gray-800">Curso ${cursoCount}</h5>
                <button type="button" onclick="removerCurso(this)" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome do Curso</label>
                    <input type="text" name="cursos[${cursoCount-1}][nome]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instituição</label>
                    <input type="text" name="cursos[${cursoCount-1}][instituicao]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Carga Horária</label>
                    <input type="number" name="cursos[${cursoCount-1}][carga_horaria]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Conclusão</label>
                    <input type="date" name="cursos[${cursoCount-1}][data_conclusao]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
        </div>
    `;
            document.getElementById('cursos-container').insertAdjacentHTML('beforeend', html);
        }

        function removerCurso(button) {
            button.closest('.curso-item').remove();
            atualizarContadores('.curso-item', 'Curso');
        }

        // Função auxiliar para atualizar contadores
        function atualizarContadores(seletor, prefixo) {
            const itens = document.querySelectorAll(seletor);
            itens.forEach((item, index) => {
                const titulo = item.querySelector('h5');
                if (titulo) {
                    titulo.textContent = `${prefixo} ${index + 1}`;
                }
            });
        }

        // Função para confirmar deleção
        function confirmarDelecao(nome) {
            return confirm(`Tem certeza que deseja deletar o servidor "${nome}"? Esta ação não pode ser desfeita.`);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SESDEC - GETEC\sistema-rh\resources\views/admin/colaborador.blade.php ENDPATH**/ ?>