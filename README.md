# IP MANAGEMENT SYSTEM - Laravel + Vue Project

## About

This project is built using Laravel for the backend and Vue.js with Inertia for the frontend.
The whole application is containerized using Docker, including the frontend (Node.js), backend (PHP), and database.

---

## Requirements

Make sure you have:

* Docker App

---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/vircalimlim/ip-management.git
cd ip-management
```

2. Copy the environment file:

```bash
cp .env.example .env
```

3. Start the containers:

```bash
docker-compose up -d --build
```

4. Generate app key:

```bash
docker-compose exec app php artisan key:generate
```

5. Run migrations:

```bash
docker-compose exec app php artisan migrate --seed
```

6. Open on browser:

```bash
http://localhost:8000
```

---

## Frontend (Vue + Vite)

The frontend runs inside a Node container.

To start it:

```bash
npm install
npm run dev
```
---
