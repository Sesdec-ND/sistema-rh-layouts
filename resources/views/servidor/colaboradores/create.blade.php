@extends('layouts.app')

@section('title', 'Servidores')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users"></i>
                        Gerenciamento de Servidores
                    </h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createServidorModal">
                        <i class="fas fa-user-plus"></i>
                        Novo Servidor
                    </button>
                </div>
                <div class="card-body">
                    <!-- Tabela de servidores -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="servidores-table">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nome</th>
                                    <th>Matrícula</th>
                                    <th>CPF</th>
                                    <th>Lotacao</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servidores as $servidor)
                                <tr>
                                    <td>
                                        <img src="{{ $servidor->foto_url }}" alt="Foto" 
                                             class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    </td>
                                    <td>{{ $servidor->nome_completo }}</td>
                                    <td>{{ $servidor->matricula }}</td>
                                    <td>{{ $servidor->formatted_cpf }}</td>
                                    <td>{{ $servidor->lotacao->sigla ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $servidor->status ? 'success' : 'danger' }}">
                                            {{ $servidor->status ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('servidores.show', $servidor->id) }}" 
                                               class="btn btn-sm btn-info" title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('servidores.edit', $servidor->id) }}" 
                                               class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('servidores.destroy', $servidor->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        title="Excluir" onclick="return confirm('Tem certeza?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cadastro -->
<div class="modal fade" id="createServidorModal" tabindex="-1" aria-labelledby="createServidorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createServidorModalLabel">
                    <i class="fas fa-user-plus"></i>
                    Cadastrar Novo Servidor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createServidorForm" action="{{ route('servidores.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Dados Pessoais -->
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-id-card"></i>
                                        Dados Pessoais
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Foto -->
                                    <div class="form-group mb-3 text-center">
                                        <label for="foto" class="form-label">Foto</label>
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="mb-2">
                                                <img id="fotoPreview" src="{{ asset('images/default-avatar.png') }}" 
                                                     class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                            </div>
                                            <input type="file" class="form-control form-control-sm @error('foto') is-invalid @enderror" 
                                                   id="foto" name="foto" accept="image/*">
                                            @error('foto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="nome_completo" class="form-label">Nome Completo *</label>
                                        <input type="text" class="form-control form-control-sm @error('nome_completo') is-invalid @enderror" 
                                               id="nome_completo" name="nome_completo" 
                                               value="{{ old('nome_completo') }}" required>
                                        @error('nome_completo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="email" class="form-label">Email *</label>
                                                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" 
                                                       id="email" name="email" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="matricula" class="form-label">Matrícula *</label>
                                                <input type="text" class="form-control form-control-sm @error('matricula') is-invalid @enderror" 
                                                       id="matricula" name="matricula" value="{{ old('matricula') }}" required>
                                                @error('matricula')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="cpf" class="form-label">CPF *</label>
                                                <input type="text" class="form-control form-control-sm cpf @error('cpf') is-invalid @enderror" 
                                                       id="cpf" name="cpf" value="{{ old('cpf') }}" required>
                                                @error('cpf')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="rg" class="form-label">RG</label>
                                                <input type="text" class="form-control form-control-sm @error('rg') is-invalid @enderror" 
                                                       id="rg" name="rg" value="{{ old('rg') }}">
                                                @error('rg')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="data_nascimento" class="form-label">Data Nasc. *</label>
                                                <input type="date" class="form-control form-control-sm @error('data_nascimento') is-invalid @enderror" 
                                                       id="data_nascimento" name="data_nascimento" 
                                                       value="{{ old('data_nascimento') }}" required>
                                                @error('data_nascimento')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="genero" class="form-label">Gênero *</label>
                                                <select class="form-select form-select-sm @error('genero') is-invalid @enderror" 
                                                        id="genero" name="genero" required>
                                                    <option value="">Selecione...</option>
                                                    <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                    <option value="Feminino" {{ old('genero') == 'Feminino' ? 'selected' : '' }}>Feminino</option>
                                                </select>
                                                @error('genero')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="estado_civil" class="form-label">Estado Civil *</label>
                                                <select class="form-select form-select-sm @error('estado_civil') is-invalid @enderror" 
                                                        id="estado_civil" name="estado_civil" required>
                                                    <option value="">Selecione...</option>
                                                    <option value="Solteiro(a)" {{ old('estado_civil') == 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
                                                    <option value="Casado(a)" {{ old('estado_civil') == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                                    <option value="Divorciado(a)" {{ old('estado_civil') == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                                    <option value="Viúvo(a)" {{ old('estado_civil') == 'Viúvo(a)' ? 'selected' : '' }}>Viúvo(a)</option>
                                                    <option value="União Estável" {{ old('estado_civil') == 'União Estável' ? 'selected' : '' }}>União Estável</option>
                                                </select>
                                                @error('estado_civil')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="raca_cor" class="form-label">Raça/Cor *</label>
                                                <select class="form-select form-select-sm @error('raca_cor') is-invalid @enderror" 
                                                        id="raca_cor" name="raca_cor" required>
                                                    <option value="">Selecione...</option>
                                                    <option value="Branca" {{ old('raca_cor') == 'Branca' ? 'selected' : '' }}>Branca</option>
                                                    <option value="Preta" {{ old('raca_cor') == 'Preta' ? 'selected' : '' }}>Preta</option>
                                                    <option value="Parda" {{ old('raca_cor') == 'Parda' ? 'selected' : '' }}>Parda</option>
                                                    <option value="Amarela" {{ old('raca_cor') == 'Amarela' ? 'selected' : '' }}>Amarela</option>
                                                    <option value="Indígena" {{ old('raca_cor') == 'Indígena' ? 'selected' : '' }}>Indígena</option>
                                                </select>
                                                @error('raca_cor')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo *</label>
                                                <select class="form-select form-select-sm @error('tipo_sanguineo') is-invalid @enderror" 
                                                        id="tipo_sanguineo" name="tipo_sanguineo" required>
                                                    <option value="">Selecione...</option>
                                                    <option value="A+" {{ old('tipo_sanguineo') == 'A+' ? 'selected' : '' }}>A+</option>
                                                    <option value="A-" {{ old('tipo_sanguineo') == 'A-' ? 'selected' : '' }}>A-</option>
                                                    <option value="B+" {{ old('tipo_sanguineo') == 'B+' ? 'selected' : '' }}>B+</option>
                                                    <option value="B-" {{ old('tipo_sanguineo') == 'B-' ? 'selected' : '' }}>B-</option>
                                                    <option value="AB+" {{ old('tipo_sanguineo') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                    <option value="AB-" {{ old('tipo_sanguineo') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                    <option value="O+" {{ old('tipo_sanguineo') == 'O+' ? 'selected' : '' }}>O+</option>
                                                    <option value="O-" {{ old('tipo_sanguineo') == 'O-' ? 'selected' : '' }}>O-</option>
                                                </select>
                                                @error('tipo_sanguineo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="pispasep" class="form-label">PIS/PASEP</label>
                                                <input type="text" class="form-control form-control-sm @error('pispasep') is-invalid @enderror" 
                                                       id="pispasep" name="pispasep" value="{{ old('pispasep') }}">
                                                @error('pispasep')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dados Profissionais e Contato -->
                        <div class="col-md-6">
                            <!-- Dados Profissionais -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-briefcase"></i>
                                        Dados Profissionais
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="id_vinculo" class="form-label">Vínculo *</label>
                                                <select class="form-select form-select-sm @error('id_vinculo') is-invalid @enderror" 
                                                        id="id_vinculo" name="id_vinculo" required>
                                                    <option value="">Selecione...</option>
                                                    @foreach($vinculos as $vinculo)
                                                        <option value="{{ $vinculo->id_vinculo }}" {{ old('id_vinculo') == $vinculo->id_vinculo ? 'selected' : '' }}>
                                                            {{ $vinculo->nome_vinculo }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_vinculo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="id_lotacao" class="form-label">Lotação *</label>
                                                <select class="form-select form-select-sm @error('id_lotacao') is-invalid @enderror" 
                                                        id="id_lotacao" name="id_lotacao" required>
                                                    <option value="">Selecione...</option>
                                                    @foreach($lotacoes as $lotacao)
                                                        <option value="{{ $lotacao->id_lotacao }}" {{ old('id_lotacao') == $lotacao->id_lotacao ? 'selected' : '' }}>
                                                            {{ $lotacao->sigla }} - {{ $lotacao->nome_lotacao }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_lotacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="data_nomeacao" class="form-label">Data Nomeação</label>
                                                <input type="date" class="form-control form-control-sm @error('data_nomeacao') is-invalid @enderror" 
                                                       id="data_nomeacao" name="data_nomeacao" 
                                                       value="{{ old('data_nomeacao') }}">
                                                @error('data_nomeacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="formacao" class="form-label">Formação</label>
                                                <input type="text" class="form-control form-control-sm @error('formacao') is-invalid @enderror" 
                                                       id="formacao" name="formacao" value="{{ old('formacao') }}">
                                                @error('formacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" 
                                                   id="status" name="status" value="1" checked>
                                            <label class="form-check-label" for="status">
                                                Servidor Ativo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contato -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-phone"></i>
                                        Contato
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-2">
                                        <label for="telefone" class="form-label">Telefone</label>
                                        <input type="text" class="form-control form-control-sm telefone @error('telefone') is-invalid @enderror" 
                                               id="telefone" name="telefone" value="{{ old('telefone') }}">
                                        @error('telefone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="endereco" class="form-label">Endereço</label>
                                        <textarea class="form-control form-control-sm @error('endereco') is-invalid @enderror" 
                                                  id="endereco" name="endereco" rows="2">{{ old('endereco') }}</textarea>
                                        @error('endereco')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Cadastrar Servidor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview da foto
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('fotoPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Máscaras
    $(document).ready(function() {
        $('.cpf').mask('000.000.000-00', {reverse: true});
        $('.telefone').mask('(00) 00000-0000');
        
        // Limpar modal quando fechar
        $('#createServidorModal').on('hidden.bs.modal', function () {
            document.getElementById('createServidorForm').reset();
            document.getElementById('fotoPreview').src = "{{ asset('images/default-avatar.png') }}";
        });
    });
</script>
@endpush