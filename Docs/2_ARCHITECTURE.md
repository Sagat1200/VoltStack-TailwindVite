# 02_ARCHITECTURE.md

# VoltStack TailwindVite Architecture

---

# Introducción

VoltStack TailwindVite es el sistema oficial de integración frontend para VoltStack encargado de proporcionar:

* integración TailwindCSS
* integración Vite
* asset pipeline
* hot reload
* manifest resolution
* frontend injection

El paquete funciona como una capa de infraestructura frontend desacoplada del runtime principal del framework.

---

# Filosofía Arquitectónica

La arquitectura del paquete sigue los principios fundamentales de VoltStack:

* modularidad
* desacoplamiento
* extensibilidad
* runtime agnostic
* frontend abstraction
* future-ready architecture

---

# Objetivo Arquitectónico

El objetivo principal es construir una infraestructura frontend que pueda evolucionar posteriormente hacia:

* SSR
* Hydration
* Streaming
* Islands Architecture
* SPA Runtime
* Native UI Engine

sin romper compatibilidad interna.

---

# Principios Arquitectónicos

## 1. Frontend desacoplado

El sistema frontend NO debe depender directamente del runtime VoltStack.

Debe funcionar como una capa independiente.

---

## 2. Infraestructura primero

TailwindVite NO es un framework frontend.

Es infraestructura frontend.

---

## 3. Asset Pipeline modular

Cada parte del sistema debe ser independiente:

* Vite
* Tailwind
* Manifest
* Assets
* Hot Reload
* Volt Integration

---

## 4. Integración nativa con Volt

El sistema se integra directamente con:

* Volt Compiler
* Volt Runtime
* Volt Directives
* Volt Render Pipeline

---

## 5. Future-ready

La arquitectura debe permitir:

* SSR
* Runtime streaming
* Hydration
* Reactive runtime
* Component islands

sin reescribir el sistema base.

---

# Arquitectura General

```text id="p7z0ff"
Volt Compiler
        │
        ▼
Frontend Integration Layer
        │
        ▼
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

# Capas Arquitectónicas

## Layer 1 — Volt Integration Layer

Responsable de integrar el paquete con el compilador Volt.

### Responsabilidades

* directivas Volt
* frontend tags
* compiler hooks
* render hooks
* asset injection

---

## Layer 2 — Frontend Core Layer

Núcleo principal del paquete.

### Responsabilidades

* coordinación interna
* resolución de assets
* manifest loading
* vite integration
* environment switching

---

## Layer 3 — Infrastructure Layer

Responsable de sistemas de infraestructura frontend.

### Responsabilidades

* filesystem
* manifest parsing
* hot reload
* build resolution
* environment detection

---

# Componentes Principales

---

# FrontendManager

## Responsabilidad

Es el núcleo central del sistema frontend.

Coordina todos los managers internos.

---

## Responsabilidades

* resolver assets
* resolver entorno
* cargar manifest
* coordinar hot reload
* cargar frontend runtime
* exponer API pública

---

## Ejemplo conceptual

```php id="8z2r48"
frontend()->asset('app.js');

frontend()->manifest();

frontend()->isDevelopment();
```

---

# ViteManager

## Responsabilidad

Gestionar toda la integración Vite.

---

## Responsabilidades

* vite config
* dev server
* production build
* hmr integration
* vite asset resolution

---

# TailwindManager

## Responsabilidad

Gestionar integración TailwindCSS.

---

## Responsabilidades

* configuración Tailwind
* app.css
* scan paths
* theme integration
* frontend css pipeline

---

# AssetManager

## Responsabilidad

Resolver assets frontend.

---

## Responsabilidades

* js assets
* css assets
* asset urls
* dynamic imports
* versioned assets

---

# ManifestManager

## Responsabilidad

Resolver manifest Vite.

---

## Responsabilidades

* leer manifest
* resolver chunks
* resolver hashes
* resolver imports
* cache manifest

---

# HotReloadManager

## Responsabilidad

Gestionar entorno de desarrollo.

---

## Responsabilidades

* detectar vite dev server
* hot reload
* hmr injection
* dev assets

---

# EnvironmentDetector

## Responsabilidad

Resolver el entorno actual.

---

## Responsabilidades

* detectar desarrollo
* detectar producción
* detectar build mode
* detectar dev server

---

# FrontendConfigRepository

## Responsabilidad

Gestionar configuración frontend.

---

## Responsabilidades

* cargar configuración
* defaults
* paths
* frontend settings

---

# Flujo Arquitectónico

# Desarrollo

```text id="lh93a5"
Volt View
    │
    ▼
Volt Compiler
    │
    ▼
@frontend
    │
    ▼
FrontendManager
    │
    ▼
HotReloadManager
    │
    ▼
Vite Dev Server
    │
    ▼
Frontend Assets
```

---

# Producción

```text id="km45a2"
Volt View
    │
    ▼
Volt Compiler
    │
    ▼
@frontend
    │
    ▼
FrontendManager
    │
    ▼
ManifestManager
    │
    ▼
manifest.json
    │
    ▼
Compiled Assets
```

---

# Integración con Volt Compiler

El paquete NO interactúa directamente con HTML plano.

Toda integración ocurre mediante:

* Volt directives
* Volt tags
* compiler hooks
* runtime hooks

---

# Directivas oficiales

## Directiva principal

```volt id="0w08jy"
@frontend
```

---

## Tag principal

```volt id="ybaw8q"
<volt:frontend />
```

---

# Responsabilidad de integración

La integración debe:

* detectar entorno
* resolver assets
* resolver manifest
* cargar HMR
* inyectar frontend runtime
* generar tags HTML finales

---

# API Pública

## Helper global

```php id="gvl1c0"
frontend()
```

---

## Métodos

```php id="4mjlwm"
frontend()->asset('app.js');

frontend()->manifest();

frontend()->hotReload();

frontend()->isDevelopment();

frontend()->isProduction();
```

---

# Estructura Interna

```text id="gsbyf1"
src/
│
├── Commands/
├── Config/
├── Contracts/
├── Frontend/
├── Directives/
├── Support/
├── Helpers/
├── Providers/
└── Stubs/
```

---

# Contratos

La arquitectura utiliza contratos para mantener desacoplamiento.

---

# Contratos principales

```text id="ev34n7"
FrontendManagerInterface
AssetResolverInterface
ManifestLoaderInterface
HotReloadInterface
EnvironmentDetectorInterface
```

---

# Pipeline de Assets

```text id="q04r0d"
Asset Request
        │
        ▼
FrontendManager
        │
        ▼
EnvironmentDetector
        │
        ├── Development
        │       ▼
        │   HotReloadManager
        │
        └── Production
                ▼
            ManifestManager
```

---

# Sistema de Manifest

El sistema manifest es responsable de:

* hashes
* chunks
* imports
* css dependencies
* dynamic imports

---

# Hot Reload System

El sistema HMR debe:

* detectar vite server
* resolver assets dev
* inyectar runtime vite
* soportar auto reload

---

# Decisiones Arquitectónicas

## 1. No acoplar Vite directamente al compiler

El compilador Volt solamente expone hooks.

La resolución frontend pertenece al FrontendManager.

---

## 2. No mezclar runtime SPA

El paquete únicamente maneja infraestructura frontend.

No maneja:

* SPA navigation
* hydration
* reactivity
* frontend state

---

## 3. No depender de framework JS

La arquitectura debe permanecer agnóstica.

---

# Escalabilidad futura

La arquitectura permitirá posteriormente:

```text id="vop24f"
Volt SSR
Volt Hydration
Volt Islands
Volt Streaming
Volt Native UI
Volt SPA Runtime
```

sin romper compatibilidad.

---

# Integraciones Futuras

## SSR

El sistema manifest será reutilizado por SSR.

---

## Hydration

Los assets serán reutilizados por el runtime hydration.

---

## Native UI

Volt Native UI utilizará el pipeline frontend existente.

---

# Estado Arquitectónico

```text id="u0k5mz"
Status: Draft V1
Architecture: Stable Foundation
Frontend Engine: TailwindCSS + Vite
View Engine: Volt
Rendering Engine: Volt Compiler
```
