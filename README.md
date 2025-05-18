# Laravel FakeStore API

Este projeto é um ambiente Laravel configurado com Sail e Vue.js para consumir a FakeStore API.

## Requisitos

- Docker e Docker Compose instalados
- Git instalado

## Instalação e Configuração

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

5. Execute as migrações e seeds do banco de dados:

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

- Backend Laravel: [http://localhost](http://localhost)
- Frontend Vite (Vue.js): [http://localhost:5173](http://localhost:5173)

## Comandos Úteis

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

- Executar testes:

```bash
./vendor/bin/sail test
```

---

**Atenção:** Certifique-se de que a porta `3306` não esteja em uso, pois o MySQL utiliza essa porta.

Se precisar de mais algum ajuste ou passo adicional, me avise! ✅✅✅🙂
