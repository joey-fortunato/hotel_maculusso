# Maculusso Hotel

Website institucional e sistema de reservas do **Maculusso Hotel** — um refúgio boutique no coração de Luanda, Angola — com um **CMS personalizado** para gerir todo o conteúdo do site e um **site bilingue (Português / Inglês)**.

---

## Índice

- [Funcionalidades](#funcionalidades)
- [Stack tecnológica](#stack-tecnológica)
- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Acesso ao painel de gestão](#acesso-ao-painel-de-gestão)
- [Comandos úteis](#comandos-úteis)
- [Estrutura do projeto](#estrutura-do-projeto)
- [Idiomas](#idiomas)
- [Notas de produção](#notas-de-produção)

---

## Funcionalidades

### Site público
- **Página inicial** com hero central e *booking bar* (calendário e seletor de hóspedes próprios, alinhados ao design system).
- **Quartos** — listagem e página de detalhe com galeria de fotos, comodidades e tarifas (individual/duplo).
- **Modal de reserva** — cálculo de preço por noite + total, disponibilidade por número de hóspedes; os pedidos são gravados na base de dados.
- **Serviços**, **Restaurante** (layout zig-zag), **Galeria** (com *lightbox*), **Quem Somos**, **Contactos** (formulário gravado no CMS) e **páginas legais**.
- **Header fixo** transparente que fica sólido ao scrollar, com **seletor de idioma** que mantém a página atual.
- **Modo de manutenção** — os visitantes veem uma página de aviso; o administrador autenticado continua a ver o site normalmente.

### CMS (`/painel`)
Painel de administração próprio, no design system do site (tipografia Inter):
- **Autenticação** e *middleware* de acesso; **dashboard** com KPIs e gráfico de reservas.
- **Reservas** e **Mensagens de contacto** com *badges* de não lidos/pendentes.
- **Páginas** — editor com separadores por página para editar todos os textos e imagens.
- **Quartos** — CRUD completo com *upload* de imagens e galeria por quarto.
- **Serviços, Comodidades, Testemunhos, Restaurante, Galeria, Menu** — CRUD guiado por esquema.
- **Definições do site** e gestão do **modo de manutenção**.

### Bilingue (PT / EN)
- Todo o conteúdo do CMS tem **campos PT e EN** (com *fallback* automático para PT quando o EN está vazio).
- As rotas públicas existem em `/pt` e `/en`; as *strings* de interface usam ficheiros de tradução (`lang/`).

---

## Stack tecnológica

| Camada | Tecnologia |
| --- | --- |
| Framework | Laravel 12 (PHP 8.4) |
| Base de dados | MySQL |
| Front-end | Blade, Tailwind CSS v4, Alpine.js |
| Build | Vite |

---

## Requisitos

- PHP **8.4+** (extensões habituais do Laravel: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, …)
- Composer 2
- Node.js 18+ e npm
- MySQL 8 (ou MariaDB compatível)

---

## Instalação

```bash
# 1. Clonar o repositório
git clone https://github.com/joey-fortunato/hotel_maculusso.git
cd hotel_maculusso

# 2. Instalar dependências
composer install
npm install

# 3. Configurar o ambiente
cp .env.example .env
php artisan key:generate
```

Edite o `.env` com os dados da sua base de dados:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_maculusso
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# 4. Criar as tabelas e o conteúdo inicial (inclui utilizador admin)
php artisan migrate --seed

# 5. Criar o link de storage (necessário para uploads de imagens)
php artisan storage:link

# 6. Compilar os assets
npm run build      # produção
# ou, em desenvolvimento:
npm run dev

# 7. Servir a aplicação
php artisan serve
```

O site fica disponível em `http://127.0.0.1:8000` (redireciona para `/pt`).

---

## Acesso ao painel de gestão

O `seeder` cria um administrador por defeito:

| | |
| --- | --- |
| URL | `/painel/login` |
| Email | `admin@hotelmaculusso.com` |
| Palavra-passe | `password` |

> ⚠️ **Altere estas credenciais antes de ir para produção.**

---

## Comandos úteis

```bash
php artisan migrate:fresh --seed   # recriar a base de dados com dados iniciais
php artisan optimize:clear         # limpar caches (config, rotas, vistas)
php artisan storage:link           # (re)criar o link público de storage
npm run dev                        # Vite em modo desenvolvimento (hot reload)
npm run build                      # compilar assets para produção
```

---

## Estrutura do projeto

```
app/
├─ Http/Controllers/
│  ├─ Public/        # site público (Home, Pages, Reservation, ContactMessage)
│  └─ Admin/         # CMS (Dashboard, Pages, Rooms, Reservations, Messages, …)
├─ Http/Middleware/  # EnsureAdmin, EnsureSiteAvailable (manutenção)
├─ Models/           # Room, Service, Amenity, Testimonial, Reservation, … + Setting
│  └─ Concerns/HasTranslations.php   # método tr() para conteúdo PT/EN
└─ Support/helpers.php               # helpers setting() e img_src()

resources/views/
├─ public/           # páginas do site
├─ admin/            # painel de gestão
└─ components/       # header, footer, booking-modal, layouts, …

database/
├─ migrations/       # esquema (settings, conteúdo, reservas, mensagens, traduções)
└─ seeders/          # CmsSeeder (conteúdo inicial) + admin

lang/                # traduções de interface (pt / en)
config/hotel.php     # valores por defeito da marca (sobrepostos pelo CMS)
```

---

## Idiomas

| Idioma | Prefixo |
| --- | --- |
| Português (padrão) | `/pt/...` |
| Inglês | `/en/...` |

O conteúdo é gerido no CMS com campos PT e EN; as etiquetas de interface vivem em `lang/pt.json` e `lang/en.json`.

---

## Notas de produção

- Definir `APP_ENV=production` e `APP_DEBUG=false` no `.env`.
- Alterar as credenciais do administrador.
- Executar `php artisan config:cache route:cache view:cache` após o deploy.
- Garantir que a pasta `storage/` e o link `public/storage` são graváveis/existentes.
- Os `uploads` de imagens ficam em `storage/app/public` (servidos via `public/storage`).
