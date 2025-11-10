<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha do Servidor - {{ $servidor->nome_completo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            background: #fff;
            padding: 20px;
        }

        .print-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            padding: 20mm;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: #1e40af;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 14px;
            color: #666;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 8px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }

        .info-item {
            margin-bottom: 12px;
        }

        .info-label {
            font-weight: bold;
            color: #555;
            font-size: 11px;
            margin-bottom: 3px;
            text-transform: uppercase;
        }

        .info-value {
            color: #111;
            font-size: 12px;
            padding: 5px 0;
            border-bottom: 1px dotted #ddd;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .photo-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .photo-box {
            width: 150px;
            height: 150px;
            border: 2px solid #ddd;
            border-radius: 8px;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9fafb;
            overflow: hidden;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            font-size: 48px;
            color: #9ca3af;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        .table th {
            background-color: #f3f4f6;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            color: #374151;
        }

        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .no-data {
            text-align: center;
            color: #9ca3af;
            font-style: italic;
            padding: 20px;
        }

        @media print {
            body {
                padding: 0;
            }

            .print-container {
                padding: 15mm;
            }

            .no-print {
                display: none !important;
            }

            .section {
                page-break-inside: avoid;
            }

            .page-break {
                page-break-before: always;
            }

            @page {
                size: A4;
                margin: 15mm;
            }
        }

        .actions {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f3f4f6;
            border-radius: 8px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 5px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .btn-print {
            background: #059669;
        }

        .btn-print:hover {
            background: #047857;
        }
    </style>
</head>
<body>
    <div class="print-container">
        <!-- Botões de Ação (não aparecem na impressão) -->
        <div class="actions no-print">
            <button onclick="window.print()" class="btn btn-print">
                🖨️ Imprimir
            </button>
            <a href="{{ route('servidores.show', $servidor->matricula) }}" class="btn">
                ← Voltar
            </a>
        </div>

        <!-- Cabeçalho -->
        <div class="header">
            <h1>FICHA DO SERVIDOR</h1>
            <p class="subtitle">Sistema de Recursos Humanos</p>
            <p class="subtitle">Gerado em: {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Foto e Dados Básicos -->
        <div class="section">
            <div class="photo-section">
                <div class="photo-box">
                    @if($servidor->foto)
                        @php
                            $fotoPath = strpos($servidor->foto, 'http') === 0 
                                ? $servidor->foto 
                                : asset('storage/' . $servidor->foto);
                        @endphp
                        <img src="{{ $fotoPath }}" alt="{{ $servidor->nome_completo }}">
                    @else
                        <div class="photo-placeholder">👤</div>
                    @endif
                </div>
                <h2 style="font-size: 20px; font-weight: bold; margin-top: 10px;">{{ $servidor->nome_completo }}</h2>
                <p style="color: #666; margin-top: 5px;">Matrícula: {{ $servidor->matricula }}</p>
                <span class="status-badge {{ $servidor->status ? 'status-active' : 'status-inactive' }}">
                    {{ $servidor->status ? 'ATIVO' : 'INATIVO' }}
                </span>
            </div>
        </div>

        <!-- Dados Pessoais -->
        <div class="section">
            <h3 class="section-title">Dados Pessoais</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nome Completo</div>
                    <div class="info-value">{{ $servidor->nome_completo }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Matrícula</div>
                    <div class="info-value">{{ $servidor->matricula }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">CPF</div>
                    <div class="info-value">{{ $servidor->cpf }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">RG</div>
                    <div class="info-value">{{ $servidor->rg ?? 'Não informado' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Data de Nascimento</div>
                    <div class="info-value">
                        {{ $servidor->data_nascimento ? \Carbon\Carbon::parse($servidor->data_nascimento)->format('d/m/Y') : 'Não informado' }}
                        @if($servidor->data_nascimento)
                            ({{ $servidor->calcularIdade() }} anos)
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Gênero</div>
                    <div class="info-value">{{ $servidor->genero ?? 'Não informado' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Estado Civil</div>
                    <div class="info-value">{{ $servidor->estado_civil ?? 'Não informado' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Raça/Cor</div>
                    <div class="info-value">{{ $servidor->raca_cor ?? 'Não informado' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tipo Sanguíneo</div>
                    <div class="info-value">{{ $servidor->tipo_sanguineo ?? 'Não informado' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">PIS/PASEP</div>
                    <div class="info-value">{{ $servidor->pispasep ?? 'Não informado' }}</div>
                </div>
                <div class="info-item full-width">
                    <div class="info-label">E-mail</div>
                    <div class="info-value">{{ $servidor->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Telefone</div>
                    <div class="info-value">{{ $servidor->telefone ?? 'Não informado' }}</div>
                </div>
                <div class="info-item full-width">
                    <div class="info-label">Endereço</div>
                    <div class="info-value">{{ $servidor->endereco ?? 'Não informado' }}</div>
                </div>
            </div>
        </div>

        <!-- Dados Profissionais -->
        <div class="section">
            <h3 class="section-title">Dados Profissionais</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Data de Nomeação</div>
                    <div class="info-value">
                        {{ $servidor->data_nomeacao ? \Carbon\Carbon::parse($servidor->data_nomeacao)->format('d/m/Y') : 'Não informado' }}
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Formação</div>
                    <div class="info-value">{{ $servidor->formacao ?? 'Não informado' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="status-badge {{ $servidor->status ? 'status-active' : 'status-inactive' }}">
                            {{ $servidor->status ? 'ATIVO' : 'INATIVO' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lotação -->
        @if($servidor->lotacao)
        <div class="section">
            <h3 class="section-title">Lotação</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nome da Lotação</div>
                    <div class="info-value">{{ $servidor->lotacao->nome_lotacao }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Sigla</div>
                    <div class="info-value">{{ $servidor->lotacao->sigla ?? 'Não informado' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Departamento</div>
                    <div class="info-value">{{ $servidor->lotacao->departamento ?? 'Não informado' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Localização</div>
                    <div class="info-value">{{ $servidor->lotacao->localizacao ?? 'Não informado' }}</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Vínculo -->
        @if($servidor->vinculo)
        <div class="section">
            <h3 class="section-title">Vínculo</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nome do Vínculo</div>
                    <div class="info-value">{{ $servidor->vinculo->nome_vinculo }}</div>
                </div>
                <div class="info-item full-width">
                    <div class="info-label">Descrição</div>
                    <div class="info-value">{{ $servidor->vinculo->descricao ?? 'Não informado' }}</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Dependentes -->
        <div class="section page-break">
            <h3 class="section-title">Dependentes</h3>
            @if($servidor->dependentes && $servidor->dependentes->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Parentesco</th>
                            <th>Data Nascimento</th>
                            <th>CPF</th>
                            <th>Gênero</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servidor->dependentes as $dependente)
                        <tr>
                            <td>{{ $dependente->nome }}</td>
                            <td>{{ $dependente->parentesco ?? 'Não informado' }}</td>
                            <td>
                                {{ $dependente->data_nascimento ? \Carbon\Carbon::parse($dependente->data_nascimento)->format('d/m/Y') : 'Não informado' }}
                            </td>
                            <td>{{ $dependente->cpf ?? 'Não informado' }}</td>
                            <td>{{ $dependente->genero ?? 'Não informado' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">Nenhum dependente registrado</div>
            @endif
        </div>

        <!-- Histórico de Pagamentos -->
        <div class="section page-break">
            <h3 class="section-title">Histórico de Pagamentos</h3>
            @if($servidor->historicoPagamentos && $servidor->historicoPagamentos->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Competência</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Data Pagamento</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servidor->historicoPagamentos as $pagamento)
                        <tr>
                            <td>{{ $pagamento->mes_ano ? \Carbon\Carbon::parse($pagamento->mes_ano)->format('m/Y') : 'N/A' }}</td>
                            <td>R$ {{ number_format($pagamento->valor ?? 0, 2, ',', '.') }}</td>
                            <td>{{ $pagamento->status ?? 'N/A' }}</td>
                            <td>
                                {{ $pagamento->data_pagamento ? \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') : '-' }}
                            </td>
                            <td>{{ $pagamento->observacoes ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">Nenhum pagamento registrado</div>
            @endif
        </div>

        <!-- Férias -->
        <div class="section page-break">
            <h3 class="section-title">Histórico de Férias</h3>
            @if($servidor->ferias && $servidor->ferias->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Período</th>
                            <th>Data Início</th>
                            <th>Data Fim</th>
                            <th>Dias</th>
                            <th>Status</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servidor->ferias as $feria)
                        <tr>
                            <td>{{ $loop->iteration }}º</td>
                            <td>
                                {{ $feria->data_inicio ? \Carbon\Carbon::parse($feria->data_inicio)->format('d/m/Y') : 'Não informado' }}
                            </td>
                            <td>
                                {{ $feria->data_fim ? \Carbon\Carbon::parse($feria->data_fim)->format('d/m/Y') : 'Não informado' }}
                            </td>
                            <td>{{ $feria->dias ?? 'Não informado' }}</td>
                            <td>{{ $feria->status ?? 'Pendente' }}</td>
                            <td>{{ $feria->observacoes ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">Nenhum período de férias registrado</div>
            @endif
        </div>

        <!-- Ocorrências -->
        <div class="section page-break">
            <h3 class="section-title">Ocorrências</h3>
            @if($servidor->ocorrencias && $servidor->ocorrencias->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Data Ocorrência</th>
                            <th>Status</th>
                            <th>Descrição</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servidor->ocorrencias as $ocorrencia)
                        <tr>
                            <td>{{ $ocorrencia->tipo_ocorrencia }}</td>
                            <td>
                                {{ $ocorrencia->data_ocorrencia ? \Carbon\Carbon::parse($ocorrencia->data_ocorrencia)->format('d/m/Y') : '-' }}
                            </td>
                            <td>{{ $ocorrencia->status ?? '-' }}</td>
                            <td>{{ $ocorrencia->descricao ?? '-' }}</td>
                            <td>{{ $ocorrencia->observacoes ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">Nenhuma ocorrência registrada</div>
            @endif
        </div>

        <!-- Rodapé -->
        <div class="footer">
            <p>Documento gerado em {{ now()->format('d/m/Y \à\s H:i') }}</p>
            <p>Sistema de Recursos Humanos - {{ config('app.name', 'Laravel') }}</p>
        </div>
    </div>

    <script>
        // Auto-print quando a página carregar (opcional)
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>
</html>

