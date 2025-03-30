
# FastFix - Documentación Inicial del Proyecto

## Introducción

**FastFix** es una plataforma enfocada en la reparación de dispositivos electrónicos y la venta de productos tecnológicos, como accesorios y componentes. La idea principal de esta aplicación web es ofrecer a los usuarios una experiencia sencilla, rápida y segura a la hora de gestionar reparaciones o adquirir productos relacionados con la tecnología.

El usuario podrá solicitar reparaciones para dispositivos como móviles, ordenadores, tablets o consolas, además de comprar accesorios como auriculares, cargadores, fundas o protectores de pantalla. La plataforma no será solo un simple escaparate de productos, sino que contará con funcionalidades pensadas para mejorar la confianza y satisfacción de los usuarios, como el sistema de valoraciones o el seguimiento detallado de reparaciones.

Una de las características principales que queremos destacar es la facilidad de uso tanto para usuarios habituales como para aquellos menos familiarizados con este tipo de plataformas. Además, hemos puesto especial atención en la seguridad, protegiendo los datos personales de los usuarios mediante cifrado SSL y cumpliendo con la normativa vigente de protección de datos.

Desarrollaremos **FastFix** con el framework Express.js para el backend, utilizando MongoDB como base de datos, mientras que para el frontend utilizaremos Vue.js, junto a HTML5, CSS3 y Tailwind CSS para el diseño y la maquetación de la interfaz. Aplicaremos el modelo vista controlador (MVC) adaptado a Express.js para estructurar el proyecto de manera eficiente. El entorno de desarrollo será Visual Studio Code, un editor que integra todas las herramientas necesarias para una programación ágil y organizada.

En cuanto a los recursos, el desarrollo de la plataforma no requiere hardware de altas prestaciones, ya que el enfoque principal es la accesibilidad y la compatibilidad con la mayoría de dispositivos actuales, tanto en ordenadores como en tablets o móviles.

---

## Objetivos

Actualmente existe una creciente demanda de plataformas que ofrezcan servicios de reparación de dispositivos electrónicos y venta de productos tecnológicos de manera cómoda, rápida y segura. Muchos usuarios se enfrentan a procesos complicados o poco claros cuando buscan reparar sus dispositivos o adquirir accesorios fiables. **FastFix** nace para cubrir esta necesidad, ofreciendo una plataforma intuitiva y accesible.

La plataforma está pensada para personas que buscan soluciones rápidas a problemas cotidianos relacionados con sus dispositivos electrónicos, así como para quienes desean adquirir accesorios tecnológicos sin complicaciones.

Además, **FastFix** representa una oportunidad de negocio interesante, ya que el sector de la reparación y venta de tecnología sigue en expansión. Nuestra intención es no solo crear una solución funcional, sino también un modelo escalable que pueda ofrecer valor tanto a usuarios particulares como a profesionales del sector tecnológico.

### Objetivo General

Desarrollar una plataforma web intuitiva y eficiente que ofrezca servicios de reparación de dispositivos electrónicos y venta de productos tecnológicos, garantizando una experiencia de usuario segura, sencilla y confiable.

### Objetivos Específicos

- Ofrecer un sistema de solicitud de reparaciones claro, rápido y accesible.
- Implementar una tienda online funcional y segura.
- Facilitar un sistema de seguimiento de reparaciones en tiempo real.
- Incorporar un sistema de valoraciones para fomentar la confianza.
- Diseñar una interfaz adaptativa, accesible y simple.
- Asegurar la protección de datos personales con cifrado y normativa legal.
- Crear un sistema de soporte ágil y eficaz.
- Escalar la plataforma con alianzas profesionales del sector.

---

## Requisitos Funcionales

- RF01. Registro de usuarios.
- RF02. Inicio de sesión y autenticación.
- RF03. Recuperación de contraseña.
- RF04. Navegación por los servicios de reparación.
- RF05. Solicitud de reparación.
- RF06. Seguimiento del estado de la reparación.
- RF07. Gestión de productos en la tienda online.
- RF08. Proceso de compra de productos.
- RF09. Sistema de valoraciones y reseñas.
- RF10. Gestión de usuarios por parte del administrador.
- RF11. Gestión de pedidos y reparaciones por parte del administrador.
- RF12. Contacto y atención al cliente.

## Requisitos No Funcionales

- RNF01. Usabilidad
- RNF02. Rendimiento
- RNF03. Compatibilidad
- RNF04. Seguridad
- RNF05. Privacidad
- RNF06. Escalabilidad
- RNF07. Mantenibilidad
- RNF08. Disponibilidad
- RNF09. Accesibilidad

---

## Tecnologías a Usar (Estado del Arte)

**Backend:** Laravel (?) + MySQL o MS SQL Server  
**Frontend:** Vue.js, Bootstrap, HTML5, CSS3, JavaScript ES6  
**Control de versiones:** Git, GitHub  
**Herramientas de desarrollo:** Visual Studio Code, Postman, Trello, Draw.io, Canva, Figma  
**Metodología:** Kanban con Trello + Git Flow

---

## Organización y Metodología

El equipo está conformado por:

- Giovanni Barroso
- Álvaro Rodríguez
- Roberto Gómez
- Tutora: Olga (olga3emes)

Seguimos la metodología ágil **Kanban** mediante Trello. Usamos **Git Flow** como estrategia de control de versiones y colaboramos usando GitHub.

Se implementará un **diagrama de Gantt** para planificar las tareas y una carpeta compartida de Google Drive donde se almacenarán las entregas y avances.

🔗 [Diagrama de Gantt](https://www.notion.so/1c60faac9c3b80188e0cc02f5e923e80?v=1c60faac9c3b80ea8bc4000c6c3bcc50)

---

## Git Flow - Estructura de Ramas

| Rama                     | Propósito                                                |
| ------------------------ | -------------------------------------------------------- |
| `main`                   | Versión estable y lista para producción                  |
| `develop`                | Rama de desarrollo donde se integran todos los cambios   |
| `feature/auth`           | Autenticación de usuarios (login, registro, etc.)        |
| `feature/contacto`       | Sección de contacto y formulario                         |
| `feature/crud-productos` | Gestión CRUD de productos                                |
| `feature/frontend-home`  | Desarrollo de la página principal                        |
| `feature/pagos`          | Integración de pasarela de pagos (PayPal)                |
| `feature/soporte`        | Módulo de soporte técnico y atención al cliente          |
| `feature/valoraciones`   | Sistema de reseñas y valoraciones de productos/servicios |
| `release/vX.X.X`         | Rama para preparar versiones estables                    |
| `hotfix/*`               | Correcciones urgentes sobre `main`                       |

---

## Enlace del Repositorio GitHub

🔗 [Repositorio FastFix en GitHub](https://github.com/GiovanniBarroso/FastFix)

---
