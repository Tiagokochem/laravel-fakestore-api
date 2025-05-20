
# Laravel FakeStore API

[English](./README.en.md) | [Português](./README.pt.md)


Este projeto é um ambiente Laravel configurado com Sail e Vue.js para consumir a FakeStore API. 
Além da listagem de produtos, foi implementado um sistema de autenticação via Laravel Sanctum para proteger as rotas e um sistema completo de CRUD para os produtos.

## 📦 Funcionalidades Implementadas

- Autenticação JWT via Laravel Sanctum
- CRUD para produtos (Leitura, Atualização e Exclusão)
- Sincronização de produtos com a FakeStore API
- Paginação e Filtro por categorias
- Interceptadores Axios configurados para inclusão do token nas requisições
- Proteção das rotas utilizando middleware
- Interface de Login com feedback visual (SweetAlert)
- Componentização em Vue.js para organização do frontend
- Sistema de navegação entre listagem de produtos, detalhes do produto, adição e edição

## ✅ Requisitos

- Docker e Docker Compose instalados
- Node.js e npm instalados
- Git instalado

## 🚀 Instalação e Configuração

1. Clone o repositório:

```bash
git clone https://github.com/Tiagokochem/laravel-fakestore-api.git
cd laravel-fakestore-api
```

2. Copie o arquivo `.env.example` para `.env` e ajuste as configurações, se necessário:

```bash
cp .env.example .env
```

3. Instale as dependências do PHP e do Node.js:

```bash
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

4. Gere a chave da aplicação:

```bash
./vendor/bin/sail artisan key:generate
```

5. Execute as migrações do banco de dados:

```bash
./vendor/bin/sail artisan migrate
```

6. Compile os assets do Vue.js:

```bash
./vendor/bin/sail npm run dev
```

7. Inicie o servidor local:

```bash
./vendor/bin/sail up -d
```

8. Acesse a aplicação em: 

- Laravel: [http://localhost](http://localhost)

## 🔐 Autenticação

- A aplicação possui um sistema de autenticação utilizando Laravel Sanctum.
-Já possui um usuário criado como padrão para testes:
Login: admin@example.com
Senha: 123456


- Caso queira criar outro usuário de teste, utilize o comando:

```bash
./vendor/bin/sail artisan tinker
```

No Tinker, execute:

```php
$user = new App\Models\User();
$user->name = "Admin";
$user->email = "admin@example.com";
$user->password = bcrypt('123456');
$user->save();
```

- Acesse o sistema em `/login` utilizando:
  - Email: `admin@example.com`
  - Senha: `123456`

## 🛠️ Comandos Úteis

- Parar os containers:

```bash
./vendor/bin/sail down
```

- Reiniciar os containers:

```bash
./vendor/bin/sail up -d
```

- Acessar o container do Laravel:

```bash
./vendor/bin/sail shell
```

- Executar comandos Artisan:

```bash
./vendor/bin/sail artisan migrate
```


## 🔥 Próximos Passos e Melhorias

- Implementar um sistema de logout para limpar o token armazenado
- Implementar o cadastro de produtos
- Melhorar a interface de produtos utilizando Tailwind CSS
- Adicionar um sistema de permissões para controle de acesso
- Criar uma dashboard com gráficos utilizando Chart.js ou ApexCharts
- Implementar testes unitários e de integração

---

**Atenção:** Certifique-se de que a porta `3306` não esteja em uso, pois o MySQL utiliza essa porta.


---
