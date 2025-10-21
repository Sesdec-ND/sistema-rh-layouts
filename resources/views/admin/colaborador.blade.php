@extends('layouts.admin')

@section('title', 'Colaboradores - RH')

@section('content')

<!-- Modal Novo Servidor -->
<div id="modalNovoServidor" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-4/5 lg:w-3/4 xl:w-2/3 shadow-lg rounded-xl bg-white max-h-[90vh] overflow-y-auto">
        
        <!-- Header do Modal -->
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-2xl font-bold text-gray-800">Cadastrar Novo Servidor</h3>
            <button onclick="fecharModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Formulário -->
        <form id="formNovoServidor" action="{{ route('servidores.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            
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
                                <!-- Preview da Foto -->
                                <div class="w-32 h-32 bg-gray-200 rounded-full mb-4 flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                                    <img id="fotoPreview" src="" alt="Preview" class="hidden w-full h-full object-cover">
                                    <i class="fas fa-camera text-gray-400 text-2xl" id="fotoIcone"></i>
                                </div>
                                
                                <!-- Upload da Foto -->
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
                                <!-- Dados Pessoais -->
                                <div class="md:col-span-2">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Dados Pessoais</h4>
                                </div>
                                
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

                                <!-- Dados Profissionais -->
                                <div class="md:col-span-2 mt-4">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Dados Profissionais</h4>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Sanguíneo</label>
                                    <select name="tipo_sanguineo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                    <div class="mb-4">
                        <button type="button" onclick="adicionarOcorrencia()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Nova Ocorrência
                        </button>
                    </div>
                    
                    <div id="ocorrencias-container">
                        <!-- Ocorrências serão adicionadas aqui dinamicamente -->
                    </div>
                </div>

                <!-- Aba Lotação -->
                <div id="aba-lotacao" class="aba-conteudo hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lotação</label>
                            <select name="id_lotacao" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione a lotação</option>
                                @foreach($lotacoes as $lotacao)
                                    <option value="{{ $lotacao->idLotacao }}">{{ $lotacao->nomeLotacao }}</option>
                                @endforeach
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
                                @foreach($vinculos as $vinculo)
                                    <option value="{{ $vinculo->idVinculo }}">{{ $vinculo->nomeVinculo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Aba Dependentes -->
                <div id="aba-dependentes" class="aba-conteudo hidden">
                    <div class="mb-4">
                        <button type="button" onclick="adicionarDependente()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Adicionar Dependente
                        </button>
                    </div>
                    
                    <div id="dependentes-container">
                        <!-- Dependentes serão adicionados aqui dinamicamente -->
                    </div>
                </div>

                <!-- Aba Pagamento -->
                <div id="aba-pagamento" class="aba-conteudo hidden">
                    <div class="mb-4">
                        <button type="button" onclick="adicionarPagamento()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Adicionar Histórico
                        </button>
                    </div>
                    
                    <div id="pagamentos-container">
                        <!-- Históricos de pagamento serão adicionados aqui -->
                    </div>
                </div>

                <!-- Aba Férias -->
                <div id="aba-ferias" class="aba-conteudo hidden">
                    <div class="mb-4">
                        <button type="button" onclick="adicionarFerias()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Adicionar Férias
                        </button>
                    </div>
                    
                    <div id="ferias-container">
                        <!-- Férias serão adicionadas aqui -->
                    </div>
                </div>

                <!-- Aba Formação -->
                <div id="aba-formacao" class="aba-conteudo hidden">
                    <div class="mb-4">
                        <button type="button" onclick="adicionarFormacao()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Adicionar Formação
                        </button>
                    </div>
                    
                    <div id="formacoes-container">
                        <!-- Formações serão adicionadas aqui -->
                    </div>
                </div>

                <!-- Aba Cursos -->
                <div id="aba-cursos" class="aba-conteudo hidden">
                    <div class="mb-4">
                        <button type="button" onclick="adicionarCurso()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Adicionar Curso
                        </button>
                    </div>
                    
                    <div id="cursos-container">
                        <!-- Cursos serão adicionadas aqui -->
                    </div>
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
 @endsection
<!-- JavaScript -->
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
    document.querySelector(`[onclick="abrirAba('${abaNome}')"]`).classList.add('border-blue-500', 'text-blue-600');
    document.querySelector(`[onclick="abrirAba('${abaNome}')"]`).classList.remove('border-transparent', 'text-gray-500');
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

// Funções para adicionar campos dinâmicos
function adicionarOcorrencia() {
    ocorrenciaCount++;
    const html = `
        <div class="border border-gray-200 rounded-lg p-4 mb-4 ocorrencia-item">
            <div class="flex justify-between items-center mb-3">
                <h5 class="font-semibold text-gray-700">Ocorrência ${ocorrenciaCount}</h5>
                <button type="button" onclick="removerOcorrencia(this)" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Ocorrência</label>
                    <input type="text" name="ocorrencias[${ocorrenciaCount}][tipo_ocorrencia]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Início</label>
                    <input type="date" name="ocorrencias[${ocorrenciaCount}][data_inicio]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Fim</label>
                    <input type="date" name="ocorrencias[${ocorrenciaCount}][data_fim]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Responsável</label>
                    <input type="text" name="ocorrencias[${ocorrenciaCount}][responsavel]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                    <textarea name="ocorrencias[${ocorrenciaCount}][descricao]" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
            </div>
        </div>
    `;
    document.getElementById('ocorrencias-container').insertAdjacentHTML('beforeend', html);
}

function removerOcorrencia(button) {
    button.closest('.ocorrencia-item').remove();
}

function adicionarDependente() {
    dependenteCount++;
    const html = `
        <div class="border border-gray-200 rounded-lg p-4 mb-4 dependente-item">
            <div class="flex justify-between items-center mb-3">
                <h5 class="font-semibold text-gray-700">Dependente ${dependenteCount}</h5>
                <button type="button" onclick="removerDependente(this)" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                    <input type="text" name="dependentes[${dependenteCount}][nome]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parentesco</label>
                    <select name="dependentes[${dependenteCount}][parentesco]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Selecione</option>
                        <option value="Filho(a)">Filho(a)</option>
                        <option value="Cônjuge">Cônjuge</option>
                        <option value="Pai">Pai</option>
                        <option value="Mãe">Mãe</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Nascimento</label>
                    <input type="date" name="dependentes[${dependenteCount}][data_nascimento]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                    <input type="text" name="dependentes[${dependenteCount}][cpf]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gênero</label>
                    <select name="dependentes[${dependenteCount}][genero]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Selecione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    document.getElementById('dependentes-container').insertAdjacentHTML('beforeend', html);
}

function removerDependente(button) {
    button.closest('.dependente-item').remove();
}

// Adicione funções similares para pagamento, férias, formação e cursos...

// Fechar modal com ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        fecharModal();
    }
});
</script>