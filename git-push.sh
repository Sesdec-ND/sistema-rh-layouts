#!/bin/bash

# Script para fazer commit e push das mudanças
cd /opt/lampp/htdocs/sistema-rh-layouts

echo "=== Verificando status do Git ==="
git status

echo ""
echo "=== Adicionando todos os arquivos modificados ==="
git add -A

echo ""
echo "=== Status após adicionar arquivos ==="
git status --short

echo ""
echo "=== Fazendo commit ==="
git commit -m "fix: corrigir relacionamentos para usar ID do servidor ao invés de matrícula

- Ajustar métodos show, edit e print para buscar dados por ID ou matrícula (compatibilidade)
- Atualizar relacionamentos nos modelos Dependente, Ocorrencia, HistoricoPagamento e Ferias
- Adicionar migration para converter foreign keys de matrícula para ID"

echo ""
echo "=== Verificando branch atual ==="
git branch --show-current

echo ""
echo "=== Fazendo push para o repositório remoto ==="
git push origin main

echo ""
echo "=== Concluído! ==="

