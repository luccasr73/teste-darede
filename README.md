# Teste Darede

## Instruções para execução do projeto
### Api
 1. Vá para o diretório `api`
 2. Execute o comando `composer install` para instalar as dependências
 3. Copie o arquivo `.env.example` e renomeie para `.env`
 4. Altere as variáveis de ambiente referentes ao banco de dados e ao token JWT
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
JWT_SECRET=
```
5. Após fazer as modificações do passo anterior, execute as `migrations` com o comando `php artisan migrate` para que as tabelas do banco sejam criadas
6. Execute o comando `php -S localhost:8000 -t public` para executar o servidor na porta 8000
