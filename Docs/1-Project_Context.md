# PROJECT_CONTEXT.md

# VoltStack TailwindVite

## Nombre del paquete

```text
voltstack/tailwind-vite
```

---

# Descripción General

VoltStack TailwindVite es el paquete oficial encargado de integrar TailwindCSS y Vite dentro del ecosistema VoltStack.

El paquete proporciona una experiencia frontend moderna, ligera y desacoplada para aplicaciones VoltStack, permitiendo configurar automáticamente:

* TailwindCSS
* Vite
* Hot Reload
* Asset Bundling
* Frontend Manifest
* Entry Points
* Asset Resolution
* Development Server Integration

El objetivo principal del paquete es ofrecer una integración frontend simple, rápida y consistente sin depender directamente del núcleo del framework.

---

# Filosofía del paquete

VoltStack TailwindVite NO es:

* un runtime SPA
* un sistema SSR
* un manejador de package managers
* un framework JavaScript
* un sistema reactivo

Su responsabilidad única es:

> Proveer la infraestructura oficial de TailwindCSS + Vite para VoltStack.

---

# Objetivos

## Objetivos principales

* Integrar TailwindCSS oficialmente en VoltStack
* Integrar Vite como asset builder oficial
* Automatizar configuración frontend
* Proveer una experiencia DX moderna
* Mantener desacoplamiento del core
* Facilitar futura integración con:

  * Volt SPA Runtime
  * Volt SSR
  * Volt Hydration
  * Volt Native UI

---

# Objetivos técnicos

* Generación automática de:

  * vite.config.js
  * app.css
  * app.js
* Registro automático de assets
* Soporte para HMR
* Resolución automática de manifest
* Sistema de detección de entorno
* Integración con Volt/Views
* Compatibilidad futura con SSR

---

# Alcance de la V1

## Incluye

* Instalador TailwindCSS
* Configuración automática Vite
* Integración frontend VoltStack
* Directiva Volt
* Asset Resolver
* Manifest Loader
* Hot Reload Detection
* Build Helpers
* Configuración frontend
* Publicación de archivos base

---

## No incluye

* Bun integration
* npm integration avanzada
* pnpm integration
* SPA runtime
* SSR runtime
* React/Vue/Svelte adapters
* Component hydration
* Frontend routing
* Frontend state management
* Frontend reactivity
* Native UI Engine
* Tailwind plugins manager

Estos sistemas serán manejados por paquetes independientes.

---

# Arquitectura General

```text
FrontendManager
│
├── ViteManager
├── TailwindManager
├── AssetManager
├── ManifestManager
├── HotReloadManager
├── EnvironmentDetector
└── FrontendConfigRepository
```

---

# Estructura del paquete

```text
src/
│
├── Commands/
│   └── FrontendInstallCommand.php
│
├── Config/
│   └── frontend.php
│
├── Contracts/
│   ├── AssetResolverInterface.php
│   ├── ManifestLoaderInterface.php
│   └── FrontendManagerInterface.php
│
├── Directives/
│   └── VoltFrontendDirective.php
│
├── Frontend/
│   ├── FrontendManager.php
│   ├── ViteManager.php
│   ├── TailwindManager.php
│   ├── AssetManager.php
│   ├── ManifestManager.php
│   ├── HotReloadManager.php
│   └── EnvironmentDetector.php
│
├── Helpers/
│   └── frontend.php
│
├── Providers/
│   └── TailwindViteServiceProvider.php
│
├── Stubs/
│   ├── vite.config.stub
│   ├── app.css.stub
│   ├── app.js.stub
│   └── frontend.config.stub
│
└── Support/
    ├── Manifest.php
    ├── Asset.php
    └── HotReload.php
```

---

# Configuración oficial

## frontend.php

```php
return [

    'builder' => 'vite',

    'css' => 'tailwind',

    'input' => [

        'css' => 'resources/css/app.css',

        'js' => 'resources/js/app.js',

    ],

    'build_directory' => 'public/build',

    'hot_reload' => true,

    'manifest' => 'public/build/.vite/manifest.json',

];
```

---

# API pública

## Facade

```php
Volt::frontend();
```

---

## Helper

```php
frontend();
```

---

# Métodos principales

```php
frontend()->asset('app.js');

frontend()->asset('app.css');

frontend()->manifest();

frontend()->isDevelopment();

frontend()->isProduction();

frontend()->hotReload();
```

---

# Directiva Blade

```volt
@voltFrontend
```

---

# Responsabilidad de la directiva

La directiva debe:

* detectar entorno
* resolver assets
* resolver manifest
* inyectar Vite HMR
* cargar assets compilados

---

# Flujo de funcionamiento

## Desarrollo

```text
View
  ↓
@voltFrontend
  ↓
HotReloadManager
  ↓
Vite Dev Server
  ↓
Assets HMR
```

---

## Producción

```text
View
  ↓
@voltFrontend
  ↓
ManifestManager
  ↓
manifest.json
  ↓
Compiled Assets
```

---

# Sistema de Manifest

El paquete utilizará manifest Vite para:

* localizar assets compilados
* resolver hashes
* resolver chunks
* resolver CSS imports
* soportar builds versionados

---

# Filosofía arquitectónica

## Principios

### 1. Frontend desacoplado

El paquete no debe depender directamente del runtime VoltStack.

---

### 2. Asset Pipeline modular

Cada sistema debe ser independiente:

* manifest
* vite
* tailwind
* assets
* hot reload

---

### 3. Preparado para evolución

La arquitectura debe permitir integrar posteriormente:

* SSR
* Streaming
* Hydration
* Islands Architecture
* Volt SPA Runtime

sin romper compatibilidad.

---

# Integración futura

Este paquete será utilizado posteriormente por:

* voltstack/spa-runtime
* voltstack/hydration
* voltstack/native-ui
* voltstack/ssr
* voltstack/islands
* voltstack/assets-cdn

---

# Comando oficial

```bash
php volt frontend:install
```

---

# Responsabilidades del comando

* Publicar archivos frontend
* Generar configuración
* Preparar estructura resources/
* Preparar estructura build/
* Configurar integración VoltStack

---

# Estructura esperada en proyecto final

```text
resources/
├── css/
│   └── app.css
│
└── js/
    └── app.js

public/
└── build/
```

---

# Convenciones

## Assets

```text
resources/css/app.css
resources/js/app.js
```

---

## Build

```text
public/build
```

---

## Manifest

```text
public/build/.vite/manifest.json
```

---

# Metas futuras

## V2

* Multiple entry points
* Dynamic assets
* Volt asset macros
* Frontend plugins

---

## V3

* SSR bridge
* SPA runtime integration
* Streaming support
* Islands support

---

## V4

* Native UI integration
* Volt reactive runtime bridge
* Volt component hydration

---

# Estado actual

```text
Version: V1 Planning
Status: Architecture Phase
Frontend Engine: TailwindCSS + Vite
```
