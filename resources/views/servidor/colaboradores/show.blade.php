@extends('layouts.admin')

@section('title', 'Visualizar Servidor - RH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Visualizar Servidor</h1>
            <p class="text-gray-600 mt-2">Detalhes completos do servidor</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('servidores.edit', $servidor->id) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-edit mr-2"></i> Editar
            </a>
            <a href="{{ route('servidores.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Abas de Navegação -->
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
        <div class="p-6">
            
            <!-- Aba Servidor -->
            <div id="aba-servidor" class="aba-conteudo">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Coluna da Foto -->
                    <div class="md:col-span-1">
                        <div class="flex flex-col items-center">
                            <div class="w-48 h-48 bg-gray-200 rounded-full mb-4 flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                                @if($servidor->foto)
                                    <img src="{{ Storage::url($servidor->foto) }}" alt="{{ $servidor->nome_completo }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">
                                        <i class="fas fa-user text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 text-center">{{ $servidor->nome_completo }}</h2>
                            <p class="text-gray-600 text-center mt-2">{{ $servidor->matricula }}</p>
                            <div class="mt-4">
                                @if($servidor->status)
                                    <span class="px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">Ativo</span>
                                @else
                                    <span class="px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">Inativo</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Coluna dos Dados -->
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Dados Pessoais</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Matrícula</label>
                                <p class="text-gray-900 font-semibold">{{ $servidor->matricula }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                                <p class="text-gray-900">{{ $servidor->cpf }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">RG</label>
                                <p class="text-gray-900">{{ $servidor->rg }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Data Nascimento</label>
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($servidor->data_nascimento)->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gênero</label>
                                <p class="text-gray-900">{{ $servidor->genero }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado Civil</label>
                                <p class="text-gray-900">{{ $servidor->estado_civil ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                                <p class="text-gray-900">{{ $servidor->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                                <p class="text-gray-900">{{ $servidor->telefone ?? 'Não informado' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                                <p class="text-gray-900">{{ $servidor->endereco ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Sanguíneo</label>
                                <p class="text-gray-900">{{ $servidor->tipo_sanguineo ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">PIS/PASEP</label>
                                <p class="text-gray-900">{{ $servidor->pispasep ?? 'Não informado' }}</p>
                            </div>

                            <div class="md:col-span-2 mt-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Dados Profissionais</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Formação</label>
                                <p class="text-gray-900">{{ $servidor->formacao ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Data Nomeação</label>
                                <p class="text-gray-900">{{ $servidor->data_nomeacao ? \Carbon\Carbon::parse($servidor->data_nomeacao)->format('d/m/Y') : 'Não informado' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <p class="text-gray-900">
                                    @if($servidor->status)
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Ativo</span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Inativo</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aba Ocorrências -->
            <div id="aba-ocorrencias" class="aba-conteudo hidden">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ocorrências</h3>
                @if($servidor->ocorrencias && $servidor->ocorrencias->count() > 0)
                    <div class="space-y-4">
                        @foreach($servidor->ocorrencias as $ocorrencia)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $ocorrencia->tipo ?? 'Ocorrência' }}</h4>
                                    <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($ocorrencia->data)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <p class="text-gray-700">{{ $ocorrencia->descricao ?? 'Sem descrição' }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-exclamation-circle text-3xl mb-3"></i>
                        <p>Nenhuma ocorrência registrada</p>
                    </div>
                @endif
            </div>

            <!-- Aba Lotação -->
            <div id="aba-lotacao" class="aba-conteudo hidden">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Dados de Lotação</h3>
                @if($servidor->lotacao)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Órgão</label>
                            <p class="text-gray-900">{{ $servidor->lotacao->orgao ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                            <p class="text-gray-900">{{ $servidor->lotacao->departamento ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cargo</label>
                            <p class="text-gray-900">{{ $servidor->lotacao->cargo ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Data de Admissão</label>
                            <p class="text-gray-900">{{ $servidor->lotacao->data_admissao ? \Carbon\Carbon::parse($servidor->lotacao->data_admissao)->format('d/m/Y') : 'Não informado' }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-building text-3xl mb-3"></i>
                        <p>Nenhuma lotação registrada</p>
                    </div>
                @endif
            </div>

            <!-- Aba Vínculo -->
            <div id="aba-vinculo" class="aba-conteudo hidden">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Dados de Vínculo</h3>
                @if($servidor->vinculo)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Vínculo</label>
                            <p class="text-gray-900">{{ $servidor->vinculo->tipo ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Regime</label>
                            <p class="text-gray-900">{{ $servidor->vinculo->regime ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Carga Horária</label>
                            <p class="text-gray-900">{{ $servidor->vinculo->carga_horaria ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Salário Base</label>
                            <p class="text-gray-900">{{ $servidor->vinculo->salario_base ? 'R$ ' . number_format($servidor->vinculo->salario_base, 2, ',', '.') : 'Não informado' }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-link text-3xl mb-3"></i>
                        <p>Nenhum vínculo registrado</p>
                    </div>
                @endif
            </div>

            <!-- Aba Dependentes -->
            <div id="aba-dependentes" class="aba-conteudo hidden">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Dependentes</h3>
                @if($servidor->dependentes && $servidor->dependentes->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($servidor->dependentes as $dependente)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-semibold text-gray-800">{{ $dependente->nome }}</h4>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600">Parentesco</label>
                                    <p class="text-gray-900">{{ $dependente->parentesco ?? 'Não informado' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600">Data Nascimento</label>
                                    <p class="text-gray-900">{{ $dependente->data_nascimento ? \Carbon\Carbon::parse($dependente->data_nascimento)->format('d/m/Y') : 'Não informado' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600">CPF</label>
                                    <p class="text-gray-900">{{ $dependente->cpf ?? 'Não informado' }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-users text-3xl mb-3"></i>
                        <p>Nenhum dependente registrado</p>
                    </div>
                @endif
            </div>

            <!-- Aba Pagamento -->
            <div id="aba-pagamento" class="aba-conteudo hidden">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Histórico de Pagamento</h3>
                @if($servidor->historicosPagamento && $servidor->historicosPagamento->count() > 0)
                    <div class="space-y-4">
                        @foreach($servidor->historicosPagamento as $pagamento)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($pagamento->mes_ano)->format('m/Y') }}</h4>
                                    <p class="text-sm text-gray-600">{{ $pagamento->status }}</p>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $pagamento->status == 'Pago' ? 'bg-green-100 text-green-800' : 
                                       ($pagamento->status == 'Pendente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $pagamento->status }}
                                </span>
                            </div>
                            <p class="text-lg font-bold text-gray-900">
                                R$ {{ number_format($pagamento->valor, 2, ',', '.') }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-money-bill-wave text-3xl mb-3"></i>
                        <p>Nenhum pagamento registrado</p>
                    </div>
                @endif
            </div>

            <!-- Aba Férias -->
            <div id="aba-ferias" class="aba-conteudo hidden">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Histórico de Férias</h3>
                @if($servidor->ferias && $servidor->ferias->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($servidor->ferias as $feria)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-semibold text-gray-800">Período {{ $loop->iteration }}</h4>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600">Data Início</label>
                                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($feria->data_inicio)->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600">Data Fim</label>
                                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($feria->data_fim)->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600">Dias</label>
                                    <p class="text-gray-900">{{ $feria->dias }} dias</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-umbrella-beach text-3xl mb-3"></i>
                        <p>Nenhum período de férias registrado</p>
                    </div>
                @endif
            </div>

            <!-- Aba Formação -->
            <div id="aba-formacao" class="aba-conteudo hidden">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Formação Acadêmica</h3>
                @if($servidor->formacoes && $servidor->formacoes->count() > 0)
                    <div class="space-y-4">
                        @foreach($servidor->formacoes as $formacao)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $formacao->curso }}</h4>
                                    <p class="text-sm text-gray-600">{{ $formacao->instituicao }}</p>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-blue-100 text-blue-800">
                                    {{ $formacao->nivel }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-700">Concluído em: {{ $formacao->ano_conclusao }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-graduation-cap text-3xl mb-3"></i>
                        <p>Nenhuma formação registrada</p>
                    </div>
                @endif
            </div>

            <!-- Aba Cursos -->
            <div id="aba-cursos" class="aba-conteudo hidden">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Cursos e Capacitações</h3>
                @if($servidor->cursos && $servidor->cursos->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($servidor->cursos as $curso)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-semibold text-gray-800">{{ $curso->nome }}</h4>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600">Instituição</label>
                                    <p class="text-gray-900">{{ $curso->instituicao }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600">Carga Horária</label>
                                    <p class="text-gray-900">{{ $curso->carga_horaria }} horas</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600">Data Conclusão</label>
                                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($curso->data_conclusao)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-book text-3xl mb-3"></i>
                        <p>Nenhum curso registrado</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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

// Abre a aba servidor por padrão
document.addEventListener('DOMContentLoaded', function() {
    abrirAba('servidor');
});
</script>
@endpush