<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Colaboradores</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 20px;
            line-height: 1.4;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 2px solid #333; 
            padding-bottom: 10px; 
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        .table th, .table td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        .table th { 
            background-color: #f5f5f5; 
            font-weight: bold; 
        }
        .status-ativo { 
            background-color: #d4edda; 
            color: #155724; 
            padding: 2px 6px; 
            border-radius: 3px; 
            font-size: 10px;
        }
        .status-inativo { 
            background-color: #f8d7da; 
            color: #721c24; 
            padding: 2px 6px; 
            border-radius: 3px; 
            font-size: 10px;
        }
        .info-box { 
            background-color: #f8f9fa; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 30px; 
            text-align: center; 
            font-size: 10px; 
            border-top: 1px solid #ddd; 
            padding-top: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; color: #333;">{{ $titulo ?? 'Relatório de Colaboradores' }}</h1>
        <p style="margin: 5px 0; color: #666;">Gerado em: {{ $data_geracao ?? now()->format('d/m/Y H:i') }}</p>
        <p style="margin: 5px 0; color: #666;">Por: {{ $usuario_gerador ?? 'Sistema' }}</p>
    </div>

    <div class="info-box">
        <strong>Total de Colaboradores:</strong> {{ $total_colaboradores ?? 0 }} |
        <strong>Data:</strong> {{ $data_geracao ?? now()->format('d/m/Y H:i') }}
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Matrícula</th>
                <th>Lotação</th>
                <th>Vínculo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($colaboradores) && $colaboradores->count() > 0)
                @foreach($colaboradores as $colaborador)
                <tr>
                    <td>{{ $colaborador->nome ?? 'N/A' }}</td>
                    <td>{{ $colaborador->matricula ?? 'N/A' }}</td>
                    <td>{{ $colaborador->lotacao->nome ?? 'N/A' }}</td>
                    <td>{{ $colaborador->vinculo->nome ?? 'N/A' }}</td>
                    <td>
                        <span class="{{ ($colaborador->status ?? false) ? 'status-ativo' : 'status-inativo' }}">
                            {{ ($colaborador->status ?? false) ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">
                        Nenhum colaborador encontrado
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Sistema de RH - {{ $data_geracao ?? now()->format('d/m/Y H:i') }} - Página 1 de 1
    </div>
</body>
</html>