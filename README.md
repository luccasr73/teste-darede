# Teste Darede
### Requisitos
 - PHP >= 7.2.5
 - Node >= 8.11.0
 - Composer
 - NPM
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
6. Execute o comando `php -S localhost:8000 -t public` para executar a aplicacão na porta 8000
7. Para executar os testes unitários use o comando `phpunit` ou `vendor\bin\phpunit` caso o primeiro não funcione
#### Rotas
| Verbo | Caminho| Descrição| Parâmetros|
|--|--|--|--|
| GET | /api/versao |Mostra a versão da api|-|
|POST|/api/login|Retorna token JWT|{email, password}|
| POST| /api/cadastrar |Cadastro de usuario|{email, password, confirm_password}|
| GET | /api/buscar/usuarios  |Busca todos os usuarios|-|
| GET | /api/buscar/usuario/email/{email} |Busca um usuário pelo email|-|
| GET | /api/buscar/usuario/id/{id} |Busca um usuário pelo id|-|
### App
 1. Vá para o diretório `app`
 2. Execute o comando `npm i` para instalar as dependências
 3. Copie o arquivo `.env.example` e renomeie para `.env`
 4. Altere as variáveis de ambiente referentes ao nome da key onde o token JWT irá ficar guardado e a url base da `api`
```
VUE_APP_API= 'http://localhost:8000/api'
VUE_APP_TOKEN_KEY= 'TOKEN'
```
5. Execute o comando `npm run build` para buildar a aplicação vue
6. Execute o comando `npm run http-server` para executar a aplicacão na porta 8080

