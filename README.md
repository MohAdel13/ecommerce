# 🛒 Modular E-Commerce RESTful API

[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Laravel Framework](https://img.shields.io/badge/Laravel-11%2F12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Architecture](https://img.shields.io/badge/Architecture-Modular%20Domain%20Monolith-blue?style=for-the-badge)](https://nwidart.com/laravel-modules)
[![Real-Time](https://img.shields.io/badge/Real--Time-Laravel%20Reverb-orange?style=for-the-badge&logo=socketdotio&logoColor=white)](https://reverb.laravel.com)
[![API Documentation](https://img.shields.io/badge/Docs-Dedoc%20Scramble-00D1B2?style=for-the-badge)](https://scramble.dedoc.co)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

A high-performance, enterprise-grade, modular E-Commerce backend API built with **Laravel**, **nwidart/laravel-modules**, **Laravel Sanctum**, **Laravel Reverb**, and **Firebase Cloud Messaging (FCM)**. 

Designed following clean code principles, the **Repository & Service Pattern**, **Data Transfer Objects (DTOs)**, pessimistic locking for inventory integrity, automated discount & tax calculation engines, and localized content delivery.

---

## 🌟 Key Highlights

- **🏗️ Domain-Driven Modular Monolith**: Divided into 16 decoupled modules (Products, Orders, Cart, Promotions, Payments, Tickets, etc.) for high cohesion and scalability.
- **⚡ Advanced Variant & EAV Architecture**: Dynamic product attribute system (Size, Color, Material, etc.) powering distinct product SKUs with independent stock and pricing.
- **🔒 Race-Condition Safe Checkout**: Transaction-wrapped order processing with `lockForUpdate` pessimistic database locks on product variants to prevent over-selling.
- **💰 Intelligent Pricing Engine**: Multi-tiered financial calculation handling base variant prices, active product discounts/offers, coupon codes (percentage or fixed with total & per-user usage limits), and accurate item-level tax apportionment.
- **📜 Historical Order Snapshotting**: Immutable order item persistence capturing localized product names, SKU, unit price, applied discounts, and variant attributes at the exact checkout moment.
- **💬 Real-Time Customer Support**: Live ticketing and messaging system broadcasting on private channels via **Laravel Reverb**.
- **🔔 Asynchronous Push Notifications**: Background queued jobs handling single-device and bulk multicast notifications via **Firebase Cloud Messaging (FCM)**.
- **🌐 Multilingual by Design**: Seamless English (`en`) and Arabic (`ar`) switching through localized JSON response resources and `Accept-Language` headers.
- **📑 Auto-Generated OpenAPI Docs**: Interactive API documentation generated dynamically via **Scramble**.

---

## 🏛️ System Architecture

The application adopts a **Layered Modular Architecture** ensuring strict separation of concerns:

```
HttpRequest
   │
   ▼
[ FormRequest Validation ]
   │
   ▼
[ Controller ] ──────► Instantiates Custom DTO (Data Transfer Object)
   │
   ▼
[ Service Layer ] ───► Executes Business Logic, Transactions & Events
   │
   ├──► [ Repository Layer ] ──► Eloquent Model Queries & DB Aggregations
   ├──► [ External Services ] ─► Firebase FCM, MediaLibrary, Cache
   └──► [ Events / Jobs ] ─────► Real-time Broadcasting & Async Queues
   │
   ▼
[ API Resource / Transformer ] ──► Standardized JSON Envelope
```

---

## 📦 Modules Breakdown

| Module | Description | Key Features & Responsibilities |
| :--- | :--- | :--- |
| **`Auth`** | Authentication & Identity | Sanctum token issuance, credential & social authentication (Google/Apple), FCM token sync, token revocation. |
| **`User`** | User Management | Admin user CRUD, customer lifecycle management, role-based access control (`Admin`, `Customer`). |
| **`Product`** | Catalog & Inventory | Product CRUD, multi-image media collections, EAV attributes & values, variant SKU tracking, reviews & ratings. |
| **`Category`** | Catalog Organization | Hierarchical parent-child category tree, category-product relations, banner attachments, media management. |
| **`Cart`** | Shopping Cart | Variant-based cart items, quantity modification, automatic pricing & tax recalculation, checkout preparation. |
| **`Promotion`** | Offers & Coupons | Date-bounded product offers, coupon verification (usage limits, user limits, min subtotals, percentage/fixed). |
| **`Order`** | Order Processing | Checkout workflow, variant inventory locking, status progression (`Pending` ➔ `Processing` ➔ `Shipped` ➔ `Delivered` / `Cancelled`). |
| **`Payment`** | Payment Tracking | Transaction tracking, payment method support (`COD`, etc.), status mapping (`Pending`, `Paid`, `Failed`, `Cancelled`). |
| **`Address`** | Shipping Addresses | Customer address book, default address selection, geolocation latitude/longitude coordinates. |
| **`Favourite`** | Wishlist System | Customer wishlist toggle, active favorite checking with eager-loaded product cards. |
| **`Ticket`** | Support Ticketing | Customer issue tickets, two-way ticket messaging, role-based private channel WebSocket events. |
| **`Notification`** | Push & In-App Alerts | Database notification tracking, asynchronous queued FCM push notifications (single and bulk multicast). |
| **`Home`** | Home Feed Aggregator | High-performance aggregated payload (banners, categories, top offers, best-sellers) backed by caching. |
| **`Banner`** | Promotional Media | Dynamic banner placements linked to categories or promotional campaigns. |
| **`Tax`** | Taxation Rules | Configurable percentage tax rates mapped directly to products and applied proportionally. |
| **`Profile`** | Customer Account | Profile detail updates, avatar upload via MediaLibrary, password changing, account deletion. |

---

## 🛠️ Tech Stack & Dependencies

- **Core Framework**: Laravel 11 / 12, PHP 8.3+
- **Modularity**: [`nwidart/laravel-modules`](https://github.com/nWidart/laravel-modules)
- **Authentication**: [`laravel/sanctum`](https://github.com/laravel/sanctum)
- **Real-Time WebSockets**: [`laravel/reverb`](https://github.com/laravel/reverb)
- **Push Notifications**: [`kreait/firebase-php`](https://github.com/kreait/firebase-php)
- **Media Management**: [`spatie/laravel-medialibrary`](https://github.com/spatie/laravel-medialibrary)
- **API Documentation**: [`dedoc/scramble`](https://github.com/dedoc/scramble)
- **Code Style & Testing**: [`laravel/pint`](https://github.com/laravel/pint), PHPUnit

---

## 🚀 Getting Started

### Prerequisites

- **PHP**: `^8.3` (with `pdo`, `mbstring`, `openssl`, `curl`, `gd` or `imagick` extensions)
- **Composer**: `^2.5`
- **Node.js & npm**: `^18.x` / `^20.x`
- **Database**: MySQL `8.0+`, or PostgreSQL `15+`

---

### Installation Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/ecommerce-api.git
   cd ecommerce-api
   ```

2. **Install PHP and Node dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database & Firebase in `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ecommerce_db
   DB_USERNAME=root
   DB_PASSWORD=secret

   QUEUE_CONNECTION=database
   BROADCAST_CONNECTION=reverb

   # Laravel Reverb
   REVERB_APP_ID=your-reverb-app-id
   REVERB_APP_KEY=your-reverb-app-key
   REVERB_APP_SECRET=your-reverb-app-secret
   REVERB_HOST="localhost"
   REVERB_PORT=8080
   REVERB_SCHEME=http

   # Firebase Service Account (JSON credentials)
   FIREBASE_CREDENTIALS=storage/app/firebase/firebase_credentials.json
   ```

5. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate --seed
   ```

6. **Create Storage Symbolic Link:**
   ```bash
   php artisan storage:link
   ```

---

### Running the Services

You can run the entire development stack concurrently using Composer scripts:

```bash
composer run dev
```

*Or launch individual services in separate terminal sessions:*

```bash
# 1. API Server
php artisan serve

# 2. Queue Worker (for FCM notifications & async tasks)
php artisan queue:listen --tries=3

# 3. Real-Time Reverb Server (for ticket messaging)
php artisan reverb:start
```

---

## 📖 API Documentation & Endpoints

Interactive API documentation is automatically accessible at:
```
http://localhost:8000/docs/api
```

### Core API Endpoints Overview

#### 🔑 Authentication (`/api/v1/auth`)
| Method | Endpoint | Description | Access |
| :--- | :--- | :--- | :--- |
| `POST` | `/auth/register` | Register a new customer account | Public |
| `POST` | `/auth/login` | Login with email and password | Public |
| `POST` | `/auth/social` | OAuth login with Google/Apple UUID | Public |
| `POST` | `/auth/logout` | Revoke active access token | Authenticated |
| `POST` | `/auth/update-fcm` | Register/Update user FCM push token | Authenticated |

#### 📦 Products & Catalog (`/api/v1/products`)
| Method | Endpoint | Description | Access |
| :--- | :--- | :--- | :--- |
| `GET` | `/products` | Filter, search & paginate products | Public |
| `GET` | `/products/{product}` | Get detailed product by ID | Public |
| `POST` | `/products/create` | Create base product & default variant | Admin |
| `PUT` | `/products/update/{product}` | Update product information & media | Admin |
| `POST` | `/products/{product}/variants` | Create and attach dynamic variants | Admin |
| `POST` | `/products/{product}/review` | Submit/Update customer review | Authenticated |

#### 🛒 Cart & Checkout (`/api/v1/cart`, `/api/v1/orders`)
| Method | Endpoint | Description | Access |
| :--- | :--- | :--- | :--- |
| `GET` | `/cart` | View cart with live calculations & tax | Authenticated |
| `POST` | `/cart/add` | Add variant SKU to shopping cart | Authenticated |
| `PUT` | `/cart/update` | Update item quantity in cart | Authenticated |
| `DELETE` | `/cart/remove-item` | Remove variant from cart | Authenticated |
| `POST` | `/orders/create` | Place order (Locks inventory & clears cart)| Authenticated |
| `GET` | `/orders/my-orders` | List logged-in user order history | Authenticated |
| `PUT` | `/orders/cancel/{order}` | Cancel order (before shipping) | Authenticated |
| `GET` | `/orders` | List all orders with filters | Admin |
| `PUT` | `/orders/update/{order}` | Update order fulfillment status | Admin |

#### 🎫 Real-Time Support Tickets (`/api/v1/tickets`)
| Method | Endpoint | Description | Access |
| :--- | :--- | :--- | :--- |
| `GET` | `/tickets/my-tickets` | List customer tickets | Authenticated |
| `POST` | `/tickets/create` | Open a new support ticket | Authenticated |
| `POST` | `/messages/create` | Send message (Broadcasts via WebSocket) | Authenticated |
| `GET` | `/tickets` | List all system tickets | Admin |

---

## 🌐 Localization & Response Format

All API responses follow a consistent, predictable JSON envelope:

### Successful Response:
```json
{
  "message": "Order created successfully",
  "data": {
    "id": 42,
    "transaction_id": "ORD_000042",
    "total_amount": 185.50,
    "status": "pending",
    "payment_method": "cod"
  }
}
```

### Error Response:
```json
{
  "message": "Insufficient stock for product variant",
  "error": "Insufficient stock for product variant"
}
```

Set language dynamically by providing the `Accept-Language` header:
- `Accept-Language: en` ➔ Returns English names & responses.
- `Accept-Language: ar` ➔ Returns Arabic names & responses.

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).
