# GigMap 🎵

> 🇧🇷 [Português](#português) | 🇺🇸 [English](#english)

---

## Português

> Projeto de TCC — Desenvolvimento de Sistemas | ETEC Machado de Assis

GigMap é uma plataforma que conecta músicos e estabelecimentos, facilitando a descoberta de artistas locais e a contratação para apresentações ao vivo. O objetivo é fortalecer a economia criativa, gerar oportunidades para músicos independentes e incentivar a cultura local.

---

### ✨ Propósito

O GigMap cria oportunidades reais de trabalho para músicos e movimenta a economia dos estabelecimentos culturais. A plataforma estimula a economia criativa, promove inclusão social e dá visibilidade a artistas que muitas vezes não encontram espaço para se apresentar — contribuindo para manter a música local viva e as cidades mais vibrantes.

---

### 🚀 Tecnologias Utilizadas

| Camada | Tecnologia |
|---|---|
| Backend | PHP 8.2, Laravel 12 |
| Banco de Dados | PostgreSQL |
| Frontend | Blade Templates, TailwindCSS |
| Build de Assets | Vite |
| WebSockets | Laravel Reverb |
| E-mail | Mailtrap |

---

### ⚙️ Funcionalidades

- Cadastro e autenticação de usuários (músicos e estabelecimentos)
- Recuperação e redefinição de senha via modal
- Publicação de anúncios de eventos com controle de data
- Exibição de aviso de evento expirado ("Este evento já passou")
- Botão de contato direto com o autor do anúncio
- Chat em tempo real entre músicos e estabelecimentos (via Laravel Reverb)
- Mensagens com horário ajustado para o fuso de Brasília (UTC-3)
- Atualização automática do chat sem necessidade de recarregar a página

---

### 📦 Instalação

#### 1. Clonar o repositório

```bash
git clone https://github.com/tiesco789/gigmap.git
cd gigmap
```

#### 2. Instalar dependências PHP

```bash
composer install
```

#### 3. Instalar dependências do frontend

```bash
pnpm install
# ou: npm install
```

#### 4. Configurar variáveis de ambiente

**Linux/macOS:**
```bash
cp .env.example .env
```

**Windows:** Copie o arquivo `.env.example` e renomeie para `.env`.

Configure as variáveis do banco de dados:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=gigmap
DB_USERNAME=postgres
DB_PASSWORD=
```

Configure o Laravel Reverb (WebSockets):

```env
REVERB_APP_ID=
REVERB_APP_KEY=
REVERB_APP_SECRET=
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

#### 5. Gerar a chave da aplicação

```bash
php artisan key:generate
```

#### 6. Executar as migrations

```bash
php artisan migrate
```

#### 7. Iniciar os serviços

Em terminais separados:

```bash
# Servidor Laravel
php artisan serve

# Servidor WebSocket (Reverb)
php artisan reverb:start

# Assets (Vite)
pnpm dev
```

A aplicação estará disponível em `http://localhost:8000`.

---

### 🗂️ Estrutura do Projeto

```
app/
├── Models/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/

resources/
├── views/
├── css/
└── js/

database/
├── migrations/
└── seeders/
```

---

### 📄 Licença

Distribuído sob a licença MIT.

---
---

## English

> Final Course Project — Systems Development | ETEC Machado de Assis

GigMap is a platform that connects musicians and venues, making it easier to discover local artists and book them for live performances. The goal is to strengthen the creative economy, create opportunities for independent musicians, and promote local culture.

---

### ✨ Purpose

GigMap creates real job opportunities for musicians while boosting the economy of cultural venues. The platform encourages the creative economy, promotes social inclusion, and gives visibility to artists who often struggle to find performance spaces — helping keep local music alive and cities more vibrant.

---

### 🚀 Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.2, Laravel 12 |
| Database | PostgreSQL |
| Frontend | Blade Templates, TailwindCSS |
| Asset Bundler | Vite |
| WebSockets | Laravel Reverb |
| Email | Mailtrap |

---

### ⚙️ Features

- User registration and authentication (musicians and venues)
- Password recovery and reset via modal
- Event listing with date control
- Expired event notice ("This event has already passed")
- Direct contact button to the listing author
- Real-time chat between musicians and venues (via Laravel Reverb)
- Messages displayed in Brasília timezone (UTC-3)
- Automatic chat refresh — no need to reload the page manually

---

### 📦 Installation

#### 1. Clone the repository

```bash
git clone https://github.com/tiesco789/gigmap.git
cd gigmap
```

#### 2. Install PHP dependencies

```bash
composer install
```

#### 3. Install frontend dependencies

```bash
pnpm install
# or: npm install
```

#### 4. Set up environment variables

**Linux/macOS:**
```bash
cp .env.example .env
```

**Windows:** Copy `.env.example` and rename it to `.env`.

Set your database variables:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=gigmap
DB_USERNAME=postgres
DB_PASSWORD=
```

Set up Laravel Reverb (WebSockets):

```env
REVERB_APP_ID=
REVERB_APP_KEY=
REVERB_APP_SECRET=
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

#### 5. Generate the application key

```bash
php artisan key:generate
```

#### 6. Run database migrations

```bash
php artisan migrate
```

#### 7. Start the services

In separate terminals:

```bash
# Laravel server
php artisan serve

# WebSocket server (Reverb)
php artisan reverb:start

# Frontend assets (Vite)
pnpm dev
```

The application will be available at `http://localhost:8000`.

---

### 🗂️ Project Structure

```
app/
├── Models/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/

resources/
├── views/
├── css/
└── js/

database/
├── migrations/
└── seeders/
```

---

### 📄 License

Distributed under the MIT License.
