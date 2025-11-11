#!/bin/bash

# Script para resolver branches divergentes e sincronizar
cd /opt/lampp/htdocs/sistema-rh-layouts

echo "=========================================="
echo "RESOLVENDO BRANCHES DIVERGENTES"
echo "=========================================="
echo ""

# 1. Verificar status
echo "1. Status atual:"
git status
echo ""

# 2. Adicionar todas as mudanças locais
echo "2. Adicionando mudanças locais..."
git add -A
echo ""

# 3. Fazer commit das mudanças locais (se houver)
echo "3. Fazendo commit das mudanças locais..."
if ! git diff --cached --quiet; then
    git commit -m "fix: corrigir relacionamentos para usar ID do servidor ao invés de matrícula

- Ajustar métodos show, edit e print para buscar dados por ID ou matrícula (compatibilidade)
- Atualizar relacionamentos nos modelos Dependente, Ocorrencia, HistoricoPagamento e Ferias
- Adicionar migration para converter foreign keys de matrícula para ID"
    echo "   ✓ Commit realizado"
else
    echo "   ✓ Nenhuma mudança para commitar"
fi
echo ""

# 4. Fazer pull com rebase (recomendado para histórico limpo)
echo "4. Fazendo pull com rebase..."
git pull origin main --rebase
echo ""

# 5. Se houver conflitos, informar
if [ $? -ne 0 ]; then
    echo "⚠️  CONFLITOS DETECTADOS!"
    echo "   Resolva os conflitos manualmente e depois execute:"
    echo "   git add ."
    echo "   git rebase --continue"
    echo "   git push origin main"
    exit 1
fi

# 6. Fazer push
echo "5. Fazendo push..."
git push origin main
echo ""

echo "=========================================="
echo "SINCRONIZAÇÃO CONCLUÍDA!"
echo "=========================================="

