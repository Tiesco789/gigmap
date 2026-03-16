# GigMap 🎵

> Projeto de TCC do curso Desenvolvimento de Sistemas na instituição ETEC Machado de Assis.

GigMap é uma plataforma que conecta músicos e estabelecimentos, facilitando a descoberta de artistas locais e a contratação para apresentações ao vivo. O objetivo é fortalecer a economia criativa, gerar oportunidades para músicos e incentivar a cultura local.


## Propósito ✨

O GigMap cria oportunidades de trabalho para músicos e movimenta a economia dos estabelecimentos.
A plataforma estimula a economia criativa, incentivando a cultura como um motor econômico.

Além disso, promove inclusão social e cultural, dando visibilidade a artistas que muitas vezes não encontram espaço para se apresentar. Dessa forma, contribui para manter a música local viva e tornar as cidades mais culturais, vibrantes e inclusivas.

## Tecnologias Utilizadas 🚀

Este projeto foi desenvolvido utilizando as seguintes tecnologias:
- PHP
- Laravel
- PostgreSQL
- TailwindCSS
- Blade Templates
- Vite

## Instalação 📦

### 1️⃣ Clonar o repositório
```bash
git clone https://github.com/seu-usuario/gigmap.git
cd gigmap
```

### 2️⃣ Instalar dependências do PHP
```bash
composer install
```

### 3️⃣ Instalar dependências do frontend
```bash
npm install
# or
pnpm i
# or
yarn
```

### 4️⃣ Configurar variáveis de ambiente
> linux
```bash
cp .env.example .env
```

> windows

Copie e cole o arquivo `.env.example` e renomei para apenas `.env`


#### Configure as variáveis do banco PostgreSQL:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=gigmap
DB_USERNAME=postgres
DB_PASSWORD=
```

### 5️⃣ Gerar chave da aplicação
```bash
php artisan key:generate
```

### 6️⃣ Executar as migrations
```bash
php artisan migrate
```

### 7️⃣ Rodar o servidor
```bash
php artisan serve
```

### Rodar o Vite para assets:

```bash
npm run dev
# or
pnpm dev
```

A aplicação estará disponível em:
`http://localhost:8000`


### Estrutura do Projeto
```
app/
 ├── Models
 ├── Http
 │   ├── Controllers
 │   ├── Middleware
 │   └── Requests

resources/
 ├── views
 ├── css
 └── js

database/
 ├── migrations
 └── seeders
```

## 🎯 Funcionalidades (Planejadas)
- Cadastro de músicos
- Cadastro de estabelecimentos
- Perfil público de artistas
- Mapa de gigs e eventos
- Sistema de mensagens entre músicos e estabelecimentos
- Sistema de avaliação
- Agenda de apresentações

---

### 📄 Licença
Este projeto está sob a licença MIT.

---
