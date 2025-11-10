# Guia de Instalação - Sistema RH

Este guia descreve os passos necessários para instalar e configurar o Sistema RH em uma máquina Linux.

## Pré-requisitos

- PHP >= 8.1
- Composer
- Node.js e NPM
- Banco de dados MySQL/MariaDB
- Servidor web (Apache/Nginx)

## Passos de Instalação

### 1. Clonar o Repositório

```bash
git clone https://github.com/Sesdec-ND/sistema-rh-layouts.git
cd sistema-rh-layouts
```

### 2. Instalar Dependências do PHP

```bash
composer install
```

### 3. Configurar o Ambiente

Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

Edite o arquivo `.env` e configure as seguintes variáveis:

```env
APP_NAME="Sistema RH"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Gerar Chave de Aplicação

```bash
php artisan key:generate
```

### 5. Criar o Banco de Dados

Crie o banco de dados no MySQL/MariaDB:

```bash
mysql -u root -p
CREATE DATABASE nome_do_banco CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 6. Executar as Migrations

```bash
php artisan migrate
```

### 7. Executar os Seeders

**IMPORTANTE**: Execute os seeders para popular as tabelas de Vínculos e Lotações, que são obrigatórias para o cadastro de servidores:

```bash
php artisan db:seed
```

Ou execute seeders específicos:

```bash
php artisan db:seed --class=VinculoSeeder
php artisan db:seed --class=LotacaoSeeder
php artisan db:seed --class=PerfisSeeder
php artisan db:seed --class=UsersSeeder
```

### 8. Configurar Permissões

Configure as permissões dos diretórios `storage` e `bootstrap/cache`:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

Ou se estiver usando seu usuário:

```bash
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 9. Criar Link Simbólico do Storage

```bash
php artisan storage:link
```

### 10. Instalar Dependências do Node.js (Opcional)

Se houver assets front-end para compilar:

```bash
npm install
npm run build
```

### 11. Configurar o Servidor Web

#### Apache

Certifique-se de que o `mod_rewrite` está habilitado e configure o VirtualHost apontando para o diretório `public`:

```apache
<VirtualHost *:80>
    ServerName sistema-rh.local
    DocumentRoot /caminho/para/sistema-rh-layouts/public
    
    <Directory /caminho/para/sistema-rh-layouts/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Nginx

```nginx
server {
    listen 80;
    server_name sistema-rh.local;
    root /caminho/para/sistema-rh-layouts/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 12. Verificar Logs

Se houver problemas, verifique os logs:

```bash
tail -f storage/logs/laravel.log
```

## Problemas Comuns

### Erro: "Não é possível cadastrar servidor"

**Causa**: Tabelas de Vínculos ou Lotações estão vazias.

**Solução**: Execute os seeders:

```bash
php artisan db:seed --class=VinculoSeeder
php artisan db:seed --class=LotacaoSeeder
```

### Erro: "Storage link não encontrado"

**Solução**: Crie o link simbólico:

```bash
php artisan storage:link
```

### Erro: "Permissão negada em storage"

**Solução**: Configure as permissões:

```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Erro: "APP_KEY não definida"

**Solução**: Gere a chave de aplicação:

```bash
php artisan key:generate
```

### Erro: "Tabela não existe"

**Solução**: Execute as migrations:

```bash
php artisan migrate
```

### Erro: "Class not found"

**Solução**: Limpe o cache e reinstale as dependências:

```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## Verificação Final

Após a instalação, verifique se:

1. ✅ O banco de dados foi criado
2. ✅ As migrations foram executadas
3. ✅ Os seeders foram executados (verifique se há registros nas tabelas `vinculos` e `lotacoes`)
4. ✅ As permissões estão corretas
5. ✅ O link simbólico do storage foi criado
6. ✅ O arquivo `.env` está configurado corretamente
7. ✅ A aplicação está acessível no navegador

## Dados de Teste

Após executar os seeders, você terá:

### Vínculos
- Efetivo
- Comissionado
- Voluntário
- PVSA
- Temporário
- Estagiário

### Lotações
- Polícia Militar (PM)
- Polícia Civil (PC)
- Polícia Técnica (POLITEC)
- Corpo de Bombeiros (CBM)
- Administração Central (ADM)
- Recursos Humanos (RH)

## Suporte

Se ainda encontrar problemas, verifique:
- Os logs em `storage/logs/laravel.log`
- As permissões dos diretórios
- A configuração do banco de dados no `.env`
- Se todas as migrations foram executadas com sucesso

