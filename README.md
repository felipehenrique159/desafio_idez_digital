# Desafio Idez Digital

## Sobre a aplicação

Este projeto consiste em uma aplicação para consulta de cidades brasileiras por estado (UF), com busca por nome, paginação e documentação interativa da API. O backend foi desenvolvido em **Laravel** e o frontend em **React**.

---

## Instruções para rodar a aplicação com Docker

1. Na pasta `api`, crie uma cópia do arquivo **.env.example** com o nome **.env**.
2. No .env já tem as default url dos 2 providers definidos para o desafio (**URL_BRASIL_API** e **URL_IBGE_API**) a escolha do provider é definido na variável **CITIES_PROVIDER**
3. Na raiz do projeto, execute o comando abaixo para subir todos os containers (API, Nginx, Redis, SPA):

   ```
   docker-compose up --build
   ```

   Isso irá disponibilizar a API e o frontend

---

## Endereços principais

- **Frontend (SPA):** [http://localhost](http://localhost)
- **API:** [http://localhost:8000/api](http://localhost:8000/api)
- **Documentação Swagger:** [http://localhost:8000/api/docs](http://localhost:8000/api/docs)

---

## Principais rotas da API

### GET `/api/cities/{uf}`

- Lista cidades de um estado (UF).
- Suporta busca por nome, paginação e quantidade de itens por página.

**Parâmetros:**

- `uf` (obrigatório): Sigla do estado (ex: `MG`, `SP`, `RJ`)
- `search` (opcional): Filtro por nome da cidade
- `page` (opcional): Número da página (default: 1)
- `per_page` (opcional): Itens por página (default: 10)

**Exemplo de requisição:**

```
GET /api/cities/MG?search=Uber&page=1&per_page=10
```

**Exemplo de resposta:**

```json
{
  "data": [
    {
      "name": "Uberaba",
      "ibge_code": "3170107"
    },
    {
      "name": "Uberlândia",
      "ibge_code": "3170206"
    }
  ],
  "current_page": 1,
  "last_page": 1,
  "total": 2
}
```

---

## Documentação da API (Swagger)

Acesse [http://localhost:8000/api/docs](http://localhost:8000/api/docs) para visualizar e testar todos os endpoints da API de forma interativa.

---

## Tecnologias e bibliotecas utilizadas

- **Backend:** Laravel, PHP, Redis, L5 Swagger
- **Frontend:** React, Typescript, Bootstrap
- **Infra:** Docker, Docker Compose, Nginx

---

## Detalhes do Projeto

### Arquitetura

O backend foi desenvolvido em Laravel, seguindo o padrão de Service Providers para integração com múltiplas APIs externas. O provider utilizado pode ser facilmente alterado via variável de ambiente (`CITIES_PROVIDER`), facilitando a manutenção e expansão para novos provedores no futuro.

- **Providers:** Camada responsável por consumir APIs externas (BrasilAPI, IBGE, etc).
- **Services:** Camada intermediária que orquestra providers, cache e regras de negócio.
- **Controllers:** Responsáveis por receber as requisições HTTP e retornar as respostas no formato esperado.
- **Cache:** Implementado para otimizar consultas repetidas e reduzir chamadas externas.
- **Testes:** Cobrem unidades e integração dos principais fluxos.

### Expansão

O projeto está preparado para receber novos endpoints e integrações, bastando criar novos Providers e Services conforme necessário. A documentação da API está disponível via Swagger em `/api/docs`.

### Convenções

- Commits atômicos e descritivos.
- Código seguindo PSR e boas práticas do Laravel.
- Testes automatizados para garantir qualidade e facilitar refatorações futuras.

---

## Observações

- O frontend consome a API diretamente e permite selecionar o estado, buscar cidades por nome, navegar por páginas e escolher a quantidade de itens exibidos.
- O projeto já está pronto para desenvolvimento local via Docker, sem necessidade de instalar dependências manualmente.

---

## Integração Contínua (CI)

O projeto utiliza **GitHub Actions** para rodar automaticamente os testes a cada push ou pull request na branch principal (master).
O workflow está configurado em `.github/workflows/ci.yml` e executa todos os testes da API em um ambiente com PHP 8.3, igual ao ambiente de Docker.

Esse processo é fundamental para garantir que, em um eventual deploy, nenhuma alteração com erro seja enviada para produção, aumentando a confiabilidade e a qualidade do projeto.

Você pode acompanhar as execuções e resultados dos testes na aba **Actions** do repositório no GitHub.

---

## Scripts úteis

### Rodar apenas o frontend localmente (fora do Docker)

1. Entre na pasta `spa`:

   ```
   cd spa
   ```
2. Instale as dependências:

   ```
   npm install
   ```
3. Inicie o servidor de desenvolvimento:

   ```
   npm start
   ```

   O frontend estará disponível em [http://localhost:3000](http://localhost:3000).

---

### Rodar apenas a API localmente (fora do Docker)

1. Entre na pasta `api`:

   ```
   cd api
   ```
2. Instale as dependências do PHP:

   ```
   composer install
   ```
3. Copie o arquivo de ambiente:

   ```
   cp .env.example .env
   ```
4. Gere a chave da aplicação:

   ```
   php artisan key:generate
   ```
5. Inicie o servidor:

   ```
   php artisan serve
   ```
   A API estará disponível em [http://localhost:8000](http://localhost:8000).


### Rodar os testes (unitários e integração)

Para executar todos os testes da API:
```bash
cd api
php artisan test
```

Os testes cobrem os principais fluxos da aplicação, incluindo integração com os providers externos, cache e tratamento de exceções.
