# FastFix 📱 – Plataforma Integral de Reparaciones y Venta Tecnológica

![Laravel](https://img.shields.io/badge/backend-Laravel%2010-red)
![Vue](https://img.shields.io/badge/frontend-Vue%203-brightgreen)
![MIT](https://img.shields.io/badge/license-MIT-blue)

> **Proyecto de Fin de Grado** – CFGS Desarrollo de Aplicaciones Web  
> **Desarrollado por:** Giovanni Barroso, Álvaro Rodríguez y Roberto Gómez  
> **Tutora:** Olga (olga3emes)

---

## 📌 Introducción

**FastFix** es una plataforma web creada para ofrecer servicios profesionales de **reparación de dispositivos electrónicos** y **venta de productos tecnológicos**, brindando una experiencia moderna, intuitiva y segura, tanto en dispositivos móviles como en ordenadores.

La aplicación permite a los usuarios:

- Solicitar reparaciones de **móviles, tablets, ordenadores y consolas**.
- Comprar productos tecnológicos como **auriculares, fundas, cargadores, altavoces**, entre otros.

### 🧩 Funcionalidades principales

- Solicitud y seguimiento de reparaciones.
- Gestión de pedidos, direcciones y facturas.
- Valoraciones y reseñas de productos y servicios.
- Carrito de compras y pago seguro con PayPal.
- Panel de administración con control de usuarios, stock, pedidos y métricas.

---

## 🎯 Objetivos del Proyecto

### ✅ Objetivo General

Desarrollar una plataforma web profesional para gestionar reparaciones y ventas tecnológicas, garantizando **usabilidad**, **seguridad** y **escalabilidad**.

### 🎯 Objetivos Específicos

- Solicitud ágil de reparaciones.
- Seguimiento en tiempo real del estado de cada reparación.
- Catálogo interactivo de productos tecnológicos.
- Gestión de pedidos y compras con pago seguro.
- Sistema de valoraciones y favoritos.
- Autenticación robusta (JWT, verificación de email, 2FA).
- Administración de usuarios, productos y pedidos.
- Infraestructura escalable para futuras integraciones.

---

## ✅ Requisitos Funcionales

| Código | Descripción |
|--------|-------------|
| RF01   | Registro y autenticación de usuarios |
| RF02   | Confirmación de email y recuperación de contraseña |
| RF03   | Visualización de productos por categoría y marca |
| RF04   | Carrito de compras con resumen antes del pago |
| RF05   | Proceso de pago mediante PayPal |
| RF06   | Solicitud y seguimiento de reparaciones |
| RF07   | Sistema de valoraciones y favoritos |
| RF08   | Gestión del perfil y direcciones del usuario |
| RF09   | Generación y visualización de facturas en PDF |
| RF10   | Administración de productos, usuarios y pedidos |
| RF11   | Panel de control con métricas y soporte técnico |

---

## 🔒 Requisitos No Funcionales

- **RNF01.** Usabilidad  
- **RNF02.** Seguridad  
- **RNF03.** Escalabilidad  
- **RNF04.** Rendimiento  
- **RNF05.** Privacidad  
- **RNF06.** Compatibilidad  
- **RNF07.** Accesibilidad  
- **RNF08.** Mantenibilidad  
- **RNF09.** Alta disponibilidad  

---

## 🛠️ Tecnologías Utilizadas

### 🔙 Backend
- **Laravel 10** (API REST)
- **JWT Auth** (`tymon/jwt-auth`)
- **Laravel Fortify** (verificación de email, 2FA)
- **MySQL 8**
- **Generación de PDFs**
- **Mail API** (Gmail SMTP)

### 🔜 Frontend
- **Vue.js 3 (SPA)**
- **Vue Router** + **Pinia**
- **Tailwind CSS**
- **AOS** (Animate On Scroll)
- **Axios** + toasts personalizados

### ⚙️ DevOps y Gestión
- **Git + GitHub** (Git Flow)
- **Postman**
- **Figma**
- **Trello** (Kanban)
- **Draw.io**
- **Visual Studio Code**

---

## 🧱 Arquitectura General

- **Frontend desacoplado (SPA)** conectado por API REST a Laravel.
- **Arquitectura MVC** adaptada en el backend.
- **Autenticación avanzada** con JWT y Fortify.
- **Integración de PayPal** para pagos seguros.
- **Generación automática de facturas en PDF.**
- **Seeders realistas** con datos de prueba.

---

## 👥 Organización del Equipo

| Nombre             | Rol                                                                 |
|--------------------|----------------------------------------------------------------------|
| Giovanni Barroso   | Fullstack Developer · Lead Dev · Arquitectura · Integración final · UX/UI |
| Álvaro Rodríguez   | Fullstack Developer · UX Designer · Funcionalidades de usuario       |
| Roberto Gómez      | Fullstack Developer · UX Designer · Funcionalidades administrativas  |
| Olga (Tutora)      | Supervisión Técnica                                                  |

---

## 📆 Planificación y Metodología

- Metodología **Kanban** mediante **Trello** para el control de tareas.
- Uso de **Google Drive** para compartir documentación y entregas.
- **Diagrama de Gantt** para planificación y control de hitos.

🔗 [Ver Diagrama de Gantt](https://www.notion.so/1c60faac9c3b80188e0cc02f5e923e80?v=1c60faac9c3b80ea8bc4000c6c3bcc50)

---

## 📁 Estructura del Proyecto

### 📦 Backend (`fastfix-backend/`)
```plaintext
fastfix-backend/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
├── database/
│   ├── migrations/
│   ├── seeders/
├── routes/
│   └── api.php
├── config/
├── .env
```

### 💻 Frontend (`fastfix-frontend/`)
```plaintext
fastfix-frontend/
├── src/
│   ├── views/
│   ├── components/
│   ├── store/
│   ├── router/
├── public/
├── assets/
├── tailwind.config.js
```

---

## 🔐 Seguridad

- Autenticación con **JWT** + **Fortify**.
- Middleware `auth:api` y `verified`.
- Rutas protegidas y uso de HTTPS.
- Validación de datos tanto en frontend como backend.

---

## 💳 Pasarela de Pago

- Desglose detallado del pedido antes del pago.
- Redirección a PayPal (modo sandbox/live).
- Confirmación del pago y actualización del pedido.
- Generación automática de factura en PDF.

---

## 📄 Facturación

- Una factura única por cada pedido.
- PDFs personalizados con logotipo y datos fiscales.
- Descarga disponible desde el panel del usuario.
- Enlaces seguros para acceder a las facturas.

---

## 🚀 Cómo ejecutar el proyecto localmente

### 1. Clonar el repositorio
```bash
git clone https://github.com/GiovanniBarroso/fastfix.git
cd fastfix
```

### 2. Backend – Laravel
```bash
cd backend
cp .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### 3. Frontend – Vue.js
```bash
cd frontend
npm install
npm run dev
```

> El backend se ejecuta en `http://localhost:8000`  
> El frontend se ejecuta en `http://localhost:5173`

---

## 📄 Licencia

Este proyecto está licenciado bajo la [Licencia MIT](LICENSE).

---