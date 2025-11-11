#!/bin/bash

# Script para sincronizar com o repositório Git
cd /opt/lampp/htdocs/sistema-rh-layouts

echo "=========================================="
echo "SINCRONIZAÇÃO COM REPOSITÓRIO GIT"
echo "=========================================="
echo ""

# 1. Verificar status
echo "1. Verificando status do repositório..."
git status
echo ""

# 2. Verificar branch atual
echo "2. Branch atual:"
BRANCH=$(git branch --show-current)
echo "   Branch: $BRANCH"
echo ""

# 3. Verificar repositório remoto
echo "3. Repositório remoto:"
git remote -v
echo ""

# 4. Adicionar todas as mudanças
echo "4. Adicionando todas as mudanças..."
git add -A
echo "   ✓ Arquivos adicionados"
echo ""

# 5. Verificar o que será commitado
echo "5. Arquivos que serão commitados:"
git status --short
echo ""

# 6. Fazer commit
echo "6. Fazendo commit..."
git commit -m "fix: corrigir relacionamentos para usar ID do servidor ao invés de matrícula

- Ajustar métodos show, edit e print para buscar dados por ID ou matrícula (compatibilidade)
- Atualizar relacionamentos nos modelos Dependente, Ocorrencia, HistoricoPagamento e Ferias
- Adicionar migration para converter foreign keys de matrícula para ID"
echo ""

# 7. Fazer pull primeiro (baixar mudanças remotas)
echo "7. Fazendo pull (baixando mudanças do remoto)..."
git pull origin $BRANCH --no-edit || git pull origin $BRANCH
echo ""

# 8. Fazer push (enviar mudanças locais)
echo "8. Fazendo push (enviando mudanças para o remoto)..."
git push origin $BRANCH
echo ""

echo "=========================================="
echo "SINCRONIZAÇÃO CONCLUÍDA!"
echo "=========================================="

