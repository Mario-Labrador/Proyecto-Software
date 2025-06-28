# GESTOR EMPRESAS DE LIMPIEZA ♻️🗑️
Este proyecto consiste en desarrollar una aplicación que permita conectar empresas de limpieza con clientes interesados en contratar sus servicios.

## 🎯Requisitos previos

Antes de descargar el proyecto, asegúrate de tener los siguientes programas instalados:
- **Git**
- Editor de código para HTML y PHP
- **XAMPP** (activar el servicio de **Apache** y **MySQL**)

## ⚙️Instalación y configuración

1. Clona el repositorio utilizando GitBash:

```
https://github.com/Mario-Labrador/Proyecto-Software.git
```

2. Ubica la carpeta **CleanGestor** en:
```
"C:\xampp\htdocs"
```
3. Activa el servicio de **Apache** para poder procesar las páginas web en el XAMPP Control Panel.
4. Activa también el servicio **MySQL**.
Debe quedar así:

<p align="center">
  <img src="https://github.com/user-attachments/assets/a88d20ba-6312-41d4-845c-1713e98ad3b8" width="500">
</p>

5. Una vez activos, haz click en el boton **Admin** de **MySQL**. Accederás a **phpMyAdmin**.

6. Crea una nueva base de datos llamada "gestor" y en la pestaña importar, seleccionas la última versión del archivo **cleangestor.sql** del repositorio.


Una vez realizados estos pasos, ya estarás listo para utilizar la aplicación.
Para acceder al menú principal, copia esta URL en tu navegador:

```
http://localhost/CleanGestor/views/Index.php
```

También puedes acceder haciendo click aquí: [CleanGestor](http://localhost/CleanGestor/views/index.php)

7. Para que funcionen también la API de pago será necesario instalar composer en la carpeta del proyecto, lo cual nos permitirá después instalar Stripe.
   En el archivo autoload.php del proyecto será necesario poner la clave (ApiKey) que tenga tu cuenta para que los pagos se transfieran ahí.

## 🌐Contribución

1. Haz un fork del repositorio

2. Crea una nueva rama antes de hacer cambios

```
git checkout -b nombre-de-la-rama
```

3. Realiza tus cambios y haz commit

```
git add .
git commit -m "Descripción del cambio"
```

5. Sube tus cambios a GitHub

```
git push origin nombre-de-la-rama
```

## 👤Roles
#### ⏹️ALBERTO LACARTA - Desarrollador sénior de software (Senior Software Architect)

#### ⏹️MARIO LABRADOR - Encargado del Proyecto (Proyect Manager)

#### ⏹️MARIO RECIO - Administrador de las bases de datos (Database Manager)


## 🗓️Planificación del Proyecto - Diagrama de Gantt actualizado a 27/6/2025
![proyecto_software_gantt](https://github.com/user-attachments/assets/5b6191f5-66c7-4e3c-8b61-1808a87084f9)



## ⏳Fases del diagrama de Gantt
A continuación se muestra detalladamente cada fase del proyecto:

### ⏹️Fase 1: Planificación
![image](https://github.com/user-attachments/assets/b5d3661a-e5f1-4211-8575-068a5e99c92d)

### ⏹️Fase 2: Diseño
![image](https://github.com/user-attachments/assets/068abc6a-ae61-4238-a839-0c2d761fd13b)

### ⏹️Fase 3: Desarrollo
![image](https://github.com/user-attachments/assets/ace9d12b-87a2-425a-9851-d09a855f3e3b)

### ⏹️Fase 4: Pruebas
![image](https://github.com/user-attachments/assets/f41ad5c3-7b1d-4691-9d5d-527817fd83f1)

### ⏹️Fase 5: Entrega
![image](https://github.com/user-attachments/assets/9eebe1dc-69d3-493d-bc67-553e468f0b85)


