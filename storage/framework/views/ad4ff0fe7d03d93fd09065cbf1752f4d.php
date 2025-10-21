<?php $__env->startSection('title', 'Colaboradores - RH'); ?>

<?php $__env->startSection('content'); ?>




<div class="space-y-6">
    <!-- Header da Página -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gerenciar Colaboradores</h1>
            <p class="text-gray-600 mt-2">Visualize, cadastre e edite os servidores do sistema.</p>
        </div>
        
        <button onclick="abrirModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Cadastrar Novo Servidor
        </button>
    </div>

    <!-- Tabela de Servidores -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Servidor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">CPF</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Matrícula</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $servidores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servidor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0 overflow-hidden">
                                    <?php if($servidor->foto): ?>
                                        <img src="<?php echo e(Storage::url($servidor->foto)); ?>" alt="<?php echo e($servidor->nome_completo); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo e($servidor->cpf); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo e($servidor->matricula); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($servidor->status): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Ativo</span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg transition duration-200" title="Editar"><i class="fas fa-edit"></i></button>
                                <button class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200" title="Desativar"><i class="fas fa-ban"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500">
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
    
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-4/5 lg:w-3/4 xl:w-2/3 shadow-lg rounded-xl bg-white max-h-[90vh] overflow-y-auto">
        
        <!-- Header do Modal -->
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-2xl font-bold text-gray-800">Cadastrar Novo Servidor</h3>
            <button onclick="fecharModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Formulário -->
        <form id="formNovoServidor" action="<?php echo e(route('servidores.store')); ?>" method="POST" enctype="multipart/form-data" class="mt-4">
            <?php echo csrf_field(); ?>
            
            <!-- Abas -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 overflow-x-auto">
                    <button type="button" onclick="abrirAba('servidor')" class="aba py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 whitespace-nowrap">
                        <i class="fas fa-user mr-2"></i>Servidor
                    </button>
                    <button type="button" onclick="abrirAba('ocorrencias')" class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        <i class="fas fa-exclamation-circle mr-2"></i>Ocorrências
                    </button>
                    <button type="button" onclick="abrirAba('lotacao')" class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        <i class="fas fa-building mr-2"></i>Lotação
                    </button>
                    <button type="button" onclick="abrirAba('vinculo')" class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        <i class="fas fa-link mr-2"></i>Vínculo
                    </button>
                    <button type="button" onclick="abrirAba('dependentes')" class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        <i class="fas fa-users mr-2"></i>Dependentes
                    </button>
                    <button type="button" onclick="abrirAba('pagamento')" class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        <i class="fas fa-money-bill-wave mr-2"></i>Pagamento
                    </button>
                    <button type="button" onclick="abrirAba('ferias')" class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        <i class="fas fa-umbrella-beach mr-2"></i>Férias
                    </button>
                    <button type="button" onclick="abrirAba('formacao')" class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        <i class="fas fa-graduation-cap mr-2"></i>Formação
                    </button>
                    <button type="button" onclick="abrirAba('cursos')" class="aba py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
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
                                <div class="w-32 h-32 bg-gray-200 rounded-full mb-4 flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                                    <img id="fotoPreview" src="" alt="Preview" class="hidden w-full h-full object-cover">
                                    <i class="fas fa-camera text-gray-400 text-2xl" id="fotoIcone"></i>
                                </div>
                                <label class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg cursor-pointer transition duration-200">
                                    <i class="fas fa-upload mr-2"></i>Upload Foto
                                    <input type="file" name="foto" id="foto" class="hidden" accept="image/*" onchange="previewFoto(this)">
                                </label>
                                <p class="text-xs text-gray-500 mt-2">JPG, PNG max 2MB</p>
                            </div>
                        </div>

                        <!-- Coluna dos Dados -->
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2"><h4 class="text-lg font-semibold text-gray-800 mb-3">Dados Pessoais</h4></div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Matrícula *</label>
                                    <input type="text" name="matricula" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
                                    <input type="text" name="nome_completo" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">CPF *</label>
                                    <input type="text" name="cpf" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="000.000.000-00">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">RG *</label>
                                    <input type="text" name="rg" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Nascimento *</label>
                                    <input type="date" name="data_nascimento" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Gênero *</label>
                                    <select name="genero" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Selecione</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Feminino">Feminino</option>
                                        <option value="Outro">Outro</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado Civil</label>
                                    <select name="estado_civil" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Selecione</option>
                                        <option value="Solteiro">Solteiro</option>
                                        <option value="Casado">Casado</option>
                                        <option value="Divorciado">Divorciado</option>
                                        <option value="Viúvo">Viúvo</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                                    <input type="text" name="telefone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="(00) 00000-0000">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                                    <input type="text" name="endereco" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2 mt-4"><h4 class="text-lg font-semibold text-gray-800 mb-3">Dados Profissionais</h4></div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Sanguíneo</label>
                                    <select name="tipo_sanguineo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Selecione</option>
                                        <option value="A+">A+</option> <option value="A-">A-</option> <option value="B+">B+</option> <option value="B-">B-</option>
                                        <option value="AB+">AB+</option> <option value="AB-">AB-</option> <option value="O+">O+</option> <option value="O-">O-</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">PIS/PASEP</label>
                                    <input type="text" name="pispasep" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Nomeação</label>
                                    <input type="date" name="data_nomeacao" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                    <div class="mb-4"><button type="button" onclick="adicionarOcorrencia()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center"><i class="fas fa-plus mr-2"></i> Nova Ocorrência</button></div>
                    <div id="ocorrencias-container"></div>
                </div>

                <!-- Aba Lotação -->
                <div id="aba-lotacao" class="aba-conteudo hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lotação</label>
                            <select name="id_lotacao" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione a lotação</option>
                                <?php $__currentLoopData = $lotacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lotacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lotacao->id); ?>"><?php echo e($lotacao->nome); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Data Início</label>
                            <input type="date" name="data_inicio_lotacao" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Aba Vínculo -->
                <div id="aba-vinculo" class="aba-conteudo hidden">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Vínculo</label>
                            <select name="id_vinculo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione o vínculo</option>
                                <?php $__currentLoopData = $vinculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vinculo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vinculo->id); ?>"><?php echo e($vinculo->nome); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Aba Dependentes -->
                <div id="aba-dependentes" class="aba-conteudo hidden">
                    <div class="mb-4"><button type="button" onclick="adicionarDependente()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center"><i class="fas fa-plus mr-2"></i> Adicionar Dependente</button></div>
                    <div id="dependentes-container"></div>
                </div>

                <!-- Aba Pagamento -->
                <div id="aba-pagamento" class="aba-conteudo hidden">
                    <div class="mb-4"><button type="button" onclick="adicionarPagamento()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center"><i class="fas fa-plus mr-2"></i> Adicionar Histórico</button></div>
                    <div id="pagamentos-container"></div>
                </div>

                <!-- Aba Férias -->
                <div id="aba-ferias" class="aba-conteudo hidden">
                    <div class="mb-4"><button type="button" onclick="adicionarFerias()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center"><i class="fas fa-plus mr-2"></i> Adicionar Férias</button></div>
                    <div id="ferias-container"></div>
                </div>

                <!-- Aba Formação -->
                <div id="aba-formacao" class="aba-conteudo hidden">
                    <div class="mb-4"><button type="button" onclick="adicionarFormacao()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center"><i class="fas fa-plus mr-2"></i> Adicionar Formação</button></div>
                    <div id="formacoes-container"></div>
                </div>

                <!-- Aba Cursos -->
                <div id="aba-cursos" class="aba-conteudo hidden">
                    <div class="mb-4"><button type="button" onclick="adicionarCurso()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center"><i class="fas fa-plus mr-2"></i> Adicionar Curso</button></div>
                    <div id="cursos-container"></div>
                </div>

            </div>

            <!-- Footer do Modal -->
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button type="button" onclick="fecharModal()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Cancelar
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center">
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

// Funções do Modal
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
    document.querySelectorAll('.aba-conteudo').forEach(aba => aba.classList.add('hidden'));
    document.querySelectorAll('.aba').forEach(aba => {
        aba.classList.remove('border-blue-500', 'text-blue-600');
        aba.classList.add('border-transparent', 'text-gray-500');
    });
    document.getElementById('aba-' + abaNome).classList.remove('hidden');
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

// Funções para adicionar e remover campos dinâmicos
function adicionarOcorrencia() {
    ocorrenciaCount++;
    const html = `<div class="border border-gray-200 rounded-lg p-4 mb-4" id="ocorrencia-${ocorrenciaCount}"><div class="flex justify-between items-center mb-3"><h5 class="font-semibold text-gray-700">Ocorrência ${ocorrenciaCount}</h5><button type="button" onclick="removerItem('ocorrencia-${ocorrenciaCount}')" class="text-red-500 hover:text-red-700"><i class="fas fa-times"></i></button></div><div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label><input type="text" name="ocorrencias[${ocorrenciaCount}][tipo_ocorrencia]" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div><div><label class="block text-sm font-medium text-gray-700 mb-1">Data Início</label><input type="date" name="ocorrencias[${ocorrenciaCount}][data_inicio]" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div><div><label class="block text-sm font-medium text-gray-700 mb-1">Data Fim</label><input type="date" name="ocorrencias[${ocorrenciaCount}][data_fim]" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div><div><label class="block text-sm font-medium text-gray-700 mb-1">Responsável</label><input type="text" name="ocorrencias[${ocorrenciaCount}][responsavel]" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div><div class="md:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label><textarea name="ocorrencias[${ocorrenciaCount}][descricao]" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea></div></div></div>`;
    document.getElementById('ocorrencias-container').insertAdjacentHTML('beforeend', html);
}

function adicionarDependente() {
    dependenteCount++;
    const html = `<div class="border border-gray-200 rounded-lg p-4 mb-4" id="dependente-${dependenteCount}"><div class="flex justify-between items-center mb-3"><h5 class="font-semibold text-gray-700">Dependente ${dependenteCount}</h5><button type="button" onclick="removerItem('dependente-${dependenteCount}')" class="text-red-500 hover:text-red-700"><i class="fas fa-times"></i></button></div><div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="block text-sm font-medium text-gray-700 mb-1">Nome</label><input type="text" name="dependentes[${dependenteCount}][nome]" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div><div><label class="block text-sm font-medium text-gray-700 mb-1">Parentesco</label><select name="dependentes[${dependenteCount}][parentesco]" class="w-full px-3 py-2 border border-gray-300 rounded-lg"><option value="">Selecione</option><option value="Filho(a)">Filho(a)</option><option value="Cônjuge">Cônjuge</option><option value="Outro">Outro</option></select></div><div><label class="block text-sm font-medium text-gray-700 mb-1">Data Nascimento</label><input type="date" name="dependentes[${dependenteCount}][data_nascimento]" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div><div><label class="block text-sm font-medium text-gray-700 mb-1">CPF</label><input type="text" name="dependentes[${dependenteCount}][cpf]" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div></div></div>`;
    document.getElementById('dependentes-container').insertAdjacentHTML('beforeend', html);
}

// Adicione aqui as funções para adicionarPagamento, adicionarFerias, etc.

function removerItem(id) {
    document.getElementById(id).remove();
}

// Fechar modal com ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        fecharModal();
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/sistema-rh-layouts/resources/views/admin/colaborador.blade.php ENDPATH**/ ?>