# 🏗️ **Chat live Using laravel and livewire**

Aplicacion de chat tiempo real utilizando laravel , livewire y pusher alpine.js

## 💈 requisitos🏗️ 💈

Composer , postgresql ,node.js

## ⚙️ Tecnologias Usadas

![LARAVEL 11](https://img.shields.io/badge/laravel-%23323330.svg?style=for-the-badge&logo=laravel&logoColor=%23F7DF1E)
![livewire](https://img.shields.io/badge/livewire-007ACC?style=for-the-badge&logo=livewire&logoColor=yellow)
![tailwind](https://img.shields.io/badge/tailwind-76448A?style=for-the-badge&logo=tailwind&logoColor=white)
Laravel 11 ,livewire, tailwind,alpine.js ,pusher, postgresql

## 🚀 **Instalacion**

# 📄 clonar el repositorio

```bash
git clone https://github.com/juanpablo72/chat-live-laravel.git
```

# 💻 entrar al directorio

```bash
cd chat-live-laravel
```

# 🧰 instalar dependencias de composer

```bash
composer install
```

# 🧰 instalar dependencias de node

```bash
npm install
```

# ⚙️ crear y configurar .env "usar de base .env.example"

```
APP_TIMEZONE=America/Caracas

#db de postgresql
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=name
DB_USERNAME=postgres
DB_PASSWORD=pass

#pushe
BROADCAST_DRIVER=pusher
BROADCAST_CONNECTION=pusher



```

# 💾 correr migraciones y seeders

```bash
php artisan make migrate --seed
```

# 🎞️ archivos necesarios para livewire

```bash
php artisan livewire:publish --assets

```

## 🚀 CORRER PROYECTO

# levantar servidor de laravel

```bash
php artisan serve

```

# 🚀 levantar servidor de node

```bash
npm run dev

```

# ⭕ escuchar Queue

```bash
php artisan queue:work
```

```bash
##LISTO  PROYECTO EN http://localhost:8000/
```

```bash
#http://localhost:8000/contacts  //usuarios registrados en el sistema en que se pueden chatear
```

```bash
#http://localhost:8000/chat/ chat del usuario logeado
```
