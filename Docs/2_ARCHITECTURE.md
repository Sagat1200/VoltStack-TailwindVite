# 02_ARCHITECTURE.md

# VoltStack TailwindVite Architecture

---

# IntroducciÃƒÂ³n

VoltStack TailwindVite es el sistema oficial de integraciÃƒÂ³n frontend para VoltStack encargado de proporcionar:

* integraciÃƒÂ³n TailwindCSS
* integraciÃƒÂ³n Vite
* asset pipeline
* hot reload
* manifest resolution
* frontend injection

El paquete funciona como una capa de infraestructura frontend desacoplada del runtime principal del framework.

---

# FilosofÃƒÂ­a ArquitectÃƒÂ³nica

La arquitectura del paquete sigue los principios fundamentales de VoltStack:

* modularidad
* desacoplamiento
* extensibilidad
* runtime agnostic
* frontend abstraction
* future-ready architecture

---

# Objetivo ArquitectÃƒÂ³nico

El objetivo principal es construir una infraestructura frontend que pueda evolucionar posteriormente hacia:

* SSR
* Hydration
* Streaming
* Islands Architecture
* SPA Runtime
* Native UI Engine

sin romper compatibilidad interna.

---

# Principios ArquitectÃƒÂ³nicos

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

## 4. IntegraciÃƒÂ³n nativa con Volt

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
        Ã¢â€â€š
        Ã¢â€“Â¼
Frontend Integration Layer
        Ã¢â€â€š
        Ã¢â€“Â¼
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

# Capas ArquitectÃƒÂ³nicas

## Layer 1 Ã¢â‚¬â€ Volt Integration Layer

Responsable de integrar el paquete con el compilador Volt.

### Responsabilidades

* directivas Volt
* frontend tags
* compiler hooks
* render hooks
* asset injection

---

## Layer 2 Ã¢â‚¬â€ Frontend Core Layer

NÃƒÂºcleo principal del paquete.

### Responsabilidades

* coordinaciÃƒÂ³n interna
* resoluciÃƒÂ³n de assets
* manifest loading
* vite integration
* environment switching

---

## Layer 3 Ã¢â‚¬â€ Infrastructure Layer

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

Es el nÃƒÂºcleo central del sistema frontend.

Coordina todos los managers internos.

---

## Responsabilidades

* resolver assets
* resolver entorno
* cargar manifest
* coordinar hot reload
* cargar frontend runtime
* exponer API pÃƒÂºblica

---

## Ejemplo conceptual

```php id="8z2r48"
tailwind_vite()->asset('app.js');

tailwind_vite()->manifest();

tailwind_vite()->isDevelopment();
```

---

# ViteManager

## Responsabilidad

Gestionar toda la integraciÃƒÂ³n Vite.

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

Gestionar integraciÃƒÂ³n TailwindCSS.

---

## Responsabilidades

* configuraciÃƒÂ³n Tailwind
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
* detectar producciÃƒÂ³n
* detectar build mode
* detectar dev server

---

# FrontendConfigRepository

## Responsabilidad

Gestionar configuraciÃƒÂ³n frontend.

---

## Responsabilidades

* cargar configuraciÃƒÂ³n
* defaults
* paths
* frontend settings

---

# Flujo ArquitectÃƒÂ³nico

# Desarrollo

```text id="lh93a5"
Volt View
    Ã¢â€â€š
    Ã¢â€“Â¼
Volt Compiler
    Ã¢â€â€š
    Ã¢â€“Â¼
@tailwind-vite
    Ã¢â€â€š
    Ã¢â€“Â¼
FrontendManager
    Ã¢â€â€š
    Ã¢â€“Â¼
HotReloadManager
    Ã¢â€â€š
    Ã¢â€“Â¼
Vite Dev Server
    Ã¢â€â€š
    Ã¢â€“Â¼
Frontend Assets
```

---

# ProducciÃƒÂ³n

```text id="km45a2"
Volt View
    Ã¢â€â€š
    Ã¢â€“Â¼
Volt Compiler
    Ã¢â€â€š
    Ã¢â€“Â¼
@tailwind-vite
    Ã¢â€â€š
    Ã¢â€“Â¼
FrontendManager
    Ã¢â€â€š
    Ã¢â€“Â¼
ManifestManager
    Ã¢â€â€š
    Ã¢â€“Â¼
manifest.json
    Ã¢â€â€š
    Ã¢â€“Â¼
Compiled Assets
```

---

# IntegraciÃƒÂ³n con Volt Compiler

El paquete NO interactÃƒÂºa directamente con HTML plano.

Toda integraciÃƒÂ³n ocurre mediante:

* Volt directives
* Volt tags
* compiler hooks
* runtime hooks

---

# Directivas oficiales

## Directiva principal

```volt id="0w08jy"
@tailwind-vite
```

---

## Tag principal

```volt id="ybaw8q"
<volt:frontend />
```

---

# Responsabilidad de integraciÃƒÂ³n

La integraciÃƒÂ³n debe:

* detectar entorno
* resolver assets
* resolver manifest
* cargar HMR
* inyectar frontend runtime
* generar tags HTML finales

---

# API PÃƒÂºblica

## Helper global

```php id="gvl1c0"
tailwind_vite()
```

---

## MÃƒÂ©todos

```php id="4mjlwm"
tailwind_vite()->asset('app.js');

tailwind_vite()->manifest();

tailwind_vite()->hotReload();

tailwind_vite()->isDevelopment();

tailwind_vite()->isProduction();
```

---

# Estructura Interna

```text id="gsbyf1"
src/
Ã¢â€â€š
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Commands/
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Config/
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Contracts/
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Frontend/
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Directives/
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Support/
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Helpers/
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Providers/
Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ Stubs/
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
        Ã¢â€â€š
        Ã¢â€“Â¼
FrontendManager
        Ã¢â€â€š
        Ã¢â€“Â¼
EnvironmentDetector
        Ã¢â€â€š
        Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Development
        Ã¢â€â€š       Ã¢â€“Â¼
        Ã¢â€â€š   HotReloadManager
        Ã¢â€â€š
        Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ Production
                Ã¢â€“Â¼
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

# Decisiones ArquitectÃƒÂ³nicas

## 1. No acoplar Vite directamente al compiler

El compilador Volt solamente expone hooks.

La resoluciÃƒÂ³n frontend pertenece al FrontendManager.

---

## 2. No mezclar runtime SPA

El paquete ÃƒÂºnicamente maneja infraestructura frontend.

No maneja:

* SPA navigation
* hydration
* reactivity
* frontend state

---

## 3. No depender de framework JS

La arquitectura debe permanecer agnÃƒÂ³stica.

---

# Escalabilidad futura

La arquitectura permitirÃƒÂ¡ posteriormente:

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

El sistema manifest serÃƒÂ¡ reutilizado por SSR.

---

## Hydration

Los assets serÃƒÂ¡n reutilizados por el runtime hydration.

---

## Native UI

Volt Native UI utilizarÃƒÂ¡ el pipeline frontend existente.

---

# Estado ArquitectÃƒÂ³nico

```text id="u0k5mz"
Status: Draft V1
Architecture: Stable Foundation
Frontend Engine: TailwindCSS + Vite
View Engine: Volt
Rendering Engine: Volt Compiler
```
