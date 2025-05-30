# FastFix 📱 – Plataforma Integral de Reparaciones y Venta Tecnológica

> Proyecto de Fin de Grado | CFGS Desarrollo Web  
> Desarrollado por: Giovanni Barroso, Álvaro Rodríguez y Roberto Gómez  
> Tutora: Olga (olga3emes)

---

## 📌 Introducción

**FastFix** es una plataforma web desarrollada con el objetivo de ofrecer servicios profesionales de **reparación de dispositivos electrónicos** y **venta de productos tecnológicos**. Está diseñada para proporcionar una **experiencia de usuario moderna, intuitiva y segura**, tanto en dispositivos móviles como de escritorio.

La aplicación permite a los usuarios solicitar reparaciones de **móviles, tablets, ordenadores y consolas**, así como adquirir accesorios tecnológicos como **auriculares, fundas, cargadores, altavoces, etc.**

Algunas características destacadas incluyen:

- Solicitud y seguimiento de reparaciones.
- Gestión de pedidos, direcciones y facturas.
- Valoraciones y reseñas de productos y servicios.
- Carrito de compras con resumen detallado y pago seguro con PayPal.
- Panel de administración completo con control de usuarios, stock, pedidos y más.

---

## 🎯 Objetivos del Proyecto

### Objetivo General

Desarrollar una plataforma web profesional para gestionar reparaciones tecnológicas y ventas de productos, garantizando usabilidad, seguridad y escalabilidad.

### Objetivos Específicos

- Solicitud rápida de reparaciones.
- Seguimiento en tiempo real del estado de cada reparación.
- Catálogo interactivo de productos tecnológicos.
- Gestión de pedidos y compras seguras.
- Sistema de valoraciones y favoritos.
- Autenticación JWT robusta con confirmación de email y 2FA.
- Administración completa de usuarios, productos y pedidos.
- Escalabilidad para integrar servicios adicionales.

---

## ✅ Requisitos Funcionales

| Código | Descripción |
|--------|-------------|
| RF01 | Registro y autenticación de usuarios |
| RF02 | Confirmación de email y recuperación de contraseña |
| RF03 | Visualización de productos por categoría y marca |
| RF04 | Carrito de compras y resumen previo al pago |
| RF05 | Proceso de pago con PayPal |
| RF06 | Sistema de solicitudes y seguimiento de reparaciones |
| RF07 | Sistema de valoraciones y favoritos |
| RF08 | Gestión del perfil del usuario y direcciones |
| RF09 | Visualización de facturas en PDF tras el pago |
| RF10 | Administración de productos, usuarios y pedidos |
| RF11 | Panel de control para seguimiento de métricas y soporte |

---

## 🔒 Requisitos No Funcionales

- **RNF01. Usabilidad**
- **RNF02. Seguridad**
- **RNF03. Escalabilidad**
- **RNF04. Rendimiento**
- **RNF05. Privacidad**
- **RNF06. Compatibilidad**
- **RNF07. Accesibilidad**
- **RNF08. Mantenibilidad**
- **RNF09. Disponibilidad**

---

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 10** (API REST)
- **JWT Auth (tymon/jwt-auth)**
- **Laravel Fortify** (verificación email, 2FA)
- **MySQL 8**
- **PDF Generator**
- **Mail API (Gmail SMTP)**

### Frontend
- **Vue.js 3 (SPA)**
- **Vue Router + Pinia**
- **Tailwind CSS**
- **AOS (Animate on Scroll)**
- **Axios + Toasts personalizados**

### DevOps & Gestión
- **Git + GitHub (Git Flow)**
- **Postman**
- **Figma**
- **Trello (Kanban)**
- **Draw.io**
- **Visual Studio Code**

---

## 🧱 Arquitectura General

- **Frontend desacoplado (SPA)** conectado vía API con Laravel.
- **Modelo Vista Controlador (MVC)** adaptado en backend.
- **Autenticación robusta** con JWT y Fortify.
- **Sistema de pago con PayPal** funcional.
- **Facturas en PDF automáticas.**
- **Seeders con datos de prueba realistas.**

---

## 🧩 Estructura de Ramas (Git Flow)

| Rama                     | Propósito                                                |
|--------------------------|-----------------------------------------------------------|
| `main`                   | Versión estable y lista para producción                  |
| `develop`                | Desarrollo activo y pruebas funcionales                  |
| `feature/auth`           | JWT + Fortify (login, registro, email, 2FA)              |
| `feature/contacto`       | Formulario de contacto y atención al cliente             |
| `feature/admin-panel`    | Gestión de usuarios, productos, pedidos, reparaciones    |
| `feature/pagos`          | Pasarela de pago PayPal y generación de facturas         |
| `feature/favoritos`      | Añadir y eliminar favoritos                              |
| `feature/frontend-home`  | Página de inicio con animaciones y diseño moderno        |
| `feature/cart`           | Carrito funcional con desglose y resumen                 |
| `feature/orders`         | Histórico de pedidos + detalles completos                |
| `feature/invoices`       | Listado y descarga de facturas PDF                       |
| `release/vX.X.X`         | Preparación de versiones estables                        |
| `hotfix/*`               | Corrección urgente en producción                         |

---

## 👥 Organización del Equipo

| Nombre               | Rol                           |
|----------------------|--------------------------------|
| Giovanni Barroso     | Fullstack Developer · Lead Dev · Arquitectura del Repositorio · I+D · Integración final · UX/UI |
| Álvaro Rodríguez     | FullStack Developer, UX, and User |
| Roberto Gómez        | FullStack Developer, UX, and Admin |
| Tutora: Olga         | Supervisión Técnica            |

---

## 📆 Planificación y Metodología

- **Kanban** en Trello para control visual de tareas.
- **Google Drive** para documentación y versiones.
- **Diagrama de Gantt** con planificación y entregas.

🔗 [Diagrama de Gantt](https://www.notion.so/1c60faac9c3b80188e0cc02f5e923e80?v=1c60faac9c3b80ea8bc4000c6c3bcc50)

---

## 📁 Estructura del Proyecto

### 🌱 Backend (`fastfix-backend/`)
fastfix-backend/
├── app/
│ ├── Http/Controllers/
│ ├── Models/
├── database/
│ ├── migrations/
│ ├── seeders/
├── routes/
│ ├── api.php
├── config/
├── .env

### 💻 Frontend (`fastfix-frontend/`)
fastfix-frontend/
├── src/
│ ├── views/
│ ├── components/
│ ├── store/
│ ├── router/
├── public/
├── assets/
├── tailwind.config.js

---

## 🔐 Seguridad

- JWT + Fortify para autenticación y sesiones.
- Middleware `auth:api`, `verified`.
- HTTPS y protección de rutas y datos.
- Validaciones frontend + backend.

---

## 💳 Pasarela de Pago

- Checkout con desglose del pedido.
- Redirección a PayPal (sandbox/live).
- Captura de pago y cambio de estado.
- Generación de factura en PDF.

---

## 📄 Facturación

- Facturas únicas por pedido.
- PDF profesional con logo y datos legales.
- Acceso desde el panel del usuario.
- Enlace seguro de descarga.

---

## 🌐 Repositorio GitHub

🔗 [https://github.com/GiovanniBarroso/FastFix](https://github.com/GiovanniBarroso/FastFix)

---
