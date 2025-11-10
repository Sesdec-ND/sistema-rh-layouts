# Sistema RH - Gestão de Recursos Humanos

Sistema de gestão de recursos humanos desenvolvido em Laravel para gerenciamento de colaboradores, vínculos, lotações e informações relacionadas.

## 📋 Pré-requisitos

- PHP >= 8.1
- Composer
- Node.js e NPM
- MySQL/MariaDB
- Servidor web (Apache/Nginx)

## 🚀 Instalação

Para instruções detalhadas de instalação, consulte o arquivo [INSTALACAO.md](INSTALACAO.md).

### Passos Rápidos

1. Clone o repositório
2. Instale as dependências: `composer install`
3. Configure o arquivo `.env`
4. Gere a chave: `php artisan key:generate`
5. Execute as migrations: `php artisan migrate`
6. **Execute os seeders** (importante!): `php artisan db:seed`
7. Configure as permissões: `chmod -R 775 storage bootstrap/cache`
8. Crie o link simbólico: `php artisan storage:link`

## ⚠️ Importante

**Não é possível cadastrar servidores sem executar os seeders!** Os seeders populam as tabelas de Vínculos e Lotações, que são obrigatórias para o cadastro.

Execute: `php artisan db:seed` ou seeders específicos:
- `php artisan db:seed --class=VinculoSeeder`
- `php artisan db:seed --class=LotacaoSeeder`
- `php artisan db:seed --class=PerfisSeeder`
- `php artisan db:seed --class=UsersSeeder`

## 📚 Documentação

Consulte [INSTALACAO.md](INSTALACAO.md) para:
- Guia completo de instalação
- Solução de problemas comuns
- Configuração do servidor web
- Verificação de instalação

## 🔧 Tecnologias

- Laravel
- PHP
- MySQL/MariaDB
- Tailwind CSS
- JavaScript

## 📝 Licença

Este projeto está sob a licença MIT.
