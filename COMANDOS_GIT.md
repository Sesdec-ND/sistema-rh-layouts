# Comandos Git para Subir as Mudanças

Execute os seguintes comandos no seu terminal, um por vez:

## 1. Verificar o status atual
```bash
cd /opt/lampp/htdocs/sistema-rh-layouts
git status
```

## 2. Adicionar todos os arquivos modificados
```bash
git add -A
```

## 3. Verificar quais arquivos foram adicionados
```bash
git status --short
```

## 4. Fazer o commit
```bash
git commit -m "fix: corrigir relacionamentos para usar ID do servidor ao invés de matrícula

- Ajustar métodos show, edit e print para buscar dados por ID ou matrícula (compatibilidade)
- Atualizar relacionamentos nos modelos Dependente, Ocorrencia, HistoricoPagamento e Ferias
- Adicionar migration para converter foreign keys de matrícula para ID"
```

## 5. Verificar a branch atual
```bash
git branch --show-current
```

## 6. Fazer o push (subir para o repositório remoto)
```bash
git push origin main
```

**OU se a branch for diferente (ex: master):**
```bash
git push origin master
```

## Arquivos que serão commitados:
- `app/Http/Controllers/ServidorController.php`
- `app/Models/Dependente.php`
- `app/Models/Ocorrencia.php`
- `app/Models/HistoricoPagamento.php`
- `app/Models/Ferias.php`
- `database/migrations/2025_11_10_160000_fix_foreign_keys_to_use_id_instead_of_matricula.php`

## Se pedir autenticação:
- **Usuário:** Seu username do GitHub/GitLab
- **Senha:** Use um **Personal Access Token** (não sua senha normal)

## Alternativa: Executar o script
Você também pode executar o script que foi criado:
```bash
cd /opt/lampp/htdocs/sistema-rh-layouts
bash git-push.sh
```

