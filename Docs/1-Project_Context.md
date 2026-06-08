# PROJECT_CONTEXT.md

# VoltStack TailwindVite

## Nombre del paquete

```text
voltstack/tailwind-vite
```

---

# DescripciÃƒÂ³n General

VoltStack TailwindVite es el paquete oficial encargado de integrar TailwindCSS y Vite dentro del ecosistema VoltStack.

El paquete proporciona una experiencia frontend moderna, ligera y desacoplada para aplicaciones VoltStack, permitiendo configurar automÃƒÂ¡ticamente:

* TailwindCSS
* Vite
* Hot Reload
* Asset Bundling
* Frontend Manifest
* Entry Points
* Asset Resolution
* Development Server Integration

El objetivo principal del paquete es ofrecer una integraciÃƒÂ³n frontend simple, rÃƒÂ¡pida y consistente sin depender directamente del nÃƒÂºcleo del framework.

---

# FilosofÃƒÂ­a del paquete

VoltStack TailwindVite NO es:

* un runtime SPA
* un sistema SSR
* un manejador de package managers
* un framework JavaScript
* un sistema reactivo

Su responsabilidad ÃƒÂºnica es:

> Proveer la infraestructura oficial de TailwindCSS + Vite para VoltStack.

---

# Objetivos

## Objetivos principales

* Integrar TailwindCSS oficialmente en VoltStack
* Integrar Vite como asset builder oficial
* Automatizar configuraciÃƒÂ³n frontend
* Proveer una experiencia DX moderna
* Mantener desacoplamiento del core
* Facilitar futura integraciÃƒÂ³n con:

  * Volt SPA Runtime
  * Volt SSR
  * Volt Hydration
  * Volt Native UI

---

# Objetivos tÃƒÂ©cnicos

* GeneraciÃƒÂ³n automÃƒÂ¡tica de:

  * vite.config.js
  * app.css
  * app.js
* Registro automÃƒÂ¡tico de assets
* Soporte para HMR
* ResoluciÃƒÂ³n automÃƒÂ¡tica de manifest
* Sistema de detecciÃƒÂ³n de entorno
* IntegraciÃƒÂ³n con Volt/Views
* Compatibilidad futura con SSR

---

# Alcance de la V1

## Incluye

* Instalador TailwindCSS
* ConfiguraciÃƒÂ³n automÃƒÂ¡tica Vite
* IntegraciÃƒÂ³n frontend VoltStack
* Directiva Volt
* Asset Resolver
* Manifest Loader
* Hot Reload Detection
* Build Helpers
* ConfiguraciÃƒÂ³n frontend
* PublicaciÃƒÂ³n de archivos base

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

Estos sistemas serÃƒÂ¡n manejados por paquetes independientes.

---

# Arquitectura General

```text
FrontendManager
Ã¢â€â€š
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ ViteManager
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ TailwindManager
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ AssetManager
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ ManifestManager
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ HotReloadManager
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ EnvironmentDetector
Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ FrontendConfigRepository
```

---

# Estructura del paquete

```text
src/
Ã¢â€â€š
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Commands/
Ã¢â€â€š   Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ FrontendInstallCommand.php
Ã¢â€â€š
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Config/
Ã¢â€â€š   Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ frontend.php
Ã¢â€â€š
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Contracts/
Ã¢â€â€š   Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ AssetResolverInterface.php
Ã¢â€â€š   Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ ManifestLoaderInterface.php
Ã¢â€â€š   Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ FrontendManagerInterface.php
Ã¢â€â€š
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Directives/
Ã¢â€â€š   Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ VoltFrontendDirective.php
Ã¢â€â€š
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Frontend/
Ã¢â€â€š   Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ FrontendManager.php
Ã¢â€â€š   Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ ViteManager.php
Ã¢â€â€š   Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ TailwindManager.php
Ã¢â€â€š   Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ AssetManager.php
Ã¢â€â€š   Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ ManifestManager.php
Ã¢â€â€š   Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ HotReloadManager.php
Ã¢â€â€š   Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ EnvironmentDetector.php
Ã¢â€â€š
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Helpers/
Ã¢â€â€š   Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ frontend.php
Ã¢â€â€š
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Providers/
Ã¢â€â€š   Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ TailwindViteServiceProvider.php
Ã¢â€â€š
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Stubs/
Ã¢â€â€š   Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ vite.config.stub
Ã¢â€â€š   Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ app.css.stub
Ã¢â€â€š   Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ app.js.stub
Ã¢â€â€š   Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ frontend.config.stub
Ã¢â€â€š
Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ Support/
    Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Manifest.php
    Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Asset.php
    Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ HotReload.php
```

---

# ConfiguraciÃƒÂ³n oficial

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

# API pÃƒÂºblica

## Facade

```php
Volt::tailwind_vite();
```

---

## Helper

```php
tailwind_vite();
```

---

# MÃƒÂ©todos principales

```php
tailwind_vite()->asset('app.js');

tailwind_vite()->asset('app.css');

tailwind_vite()->manifest();

tailwind_vite()->isDevelopment();

tailwind_vite()->isProduction();

tailwind_vite()->hotReload();
```

---

# Directiva Blade

```volt
@tailwind-vite
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
  Ã¢â€ â€œ
@tailwind-vite
  Ã¢â€ â€œ
HotReloadManager
  Ã¢â€ â€œ
Vite Dev Server
  Ã¢â€ â€œ
Assets HMR
```

---

## ProducciÃƒÂ³n

```text
View
  Ã¢â€ â€œ
@tailwind-vite
  Ã¢â€ â€œ
ManifestManager
  Ã¢â€ â€œ
manifest.json
  Ã¢â€ â€œ
Compiled Assets
```

---

# Sistema de Manifest

El paquete utilizarÃƒÂ¡ manifest Vite para:

* localizar assets compilados
* resolver hashes
* resolver chunks
* resolver CSS imports
* soportar builds versionados

---

# FilosofÃƒÂ­a arquitectÃƒÂ³nica

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

### 3. Preparado para evoluciÃƒÂ³n

La arquitectura debe permitir integrar posteriormente:

* SSR
* Streaming
* Hydration
* Islands Architecture
* Volt SPA Runtime

sin romper compatibilidad.

---

# IntegraciÃƒÂ³n futura

Este paquete serÃƒÂ¡ utilizado posteriormente por:

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
* Generar configuraciÃƒÂ³n
* Preparar estructura resources/
* Preparar estructura build/
* Configurar integraciÃƒÂ³n VoltStack

---

# Estructura esperada en proyecto final

```text
resources/
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ css/
Ã¢â€â€š   Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ app.css
Ã¢â€â€š
Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ js/
    Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ app.js

public/
Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ build/
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
