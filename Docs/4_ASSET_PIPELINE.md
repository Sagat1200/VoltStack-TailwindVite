# 04_ASSET_PIPELINE.md

# VoltStack TailwindVite — Asset Pipeline

---

# Introducción

El Asset Pipeline de VoltStack TailwindVite es el sistema encargado de gestionar todo el ciclo de vida de los assets frontend dentro de VoltStack.

El pipeline es responsable de:

* resolución de assets
* compilación frontend
* manifest loading
* hot reload
* environment switching
* css/js injection
* chunk resolution
* dynamic imports

---

# Filosofía del Pipeline

El sistema de assets está diseñado bajo los principios:

* desacoplamiento
* modularidad
* environment awareness
* frontend abstraction
* runtime safety
* future scalability

---

# Objetivos del Pipeline

## Objetivos principales

* Resolver assets automáticamente
* Separar desarrollo y producción
* Integrar Vite con Volt
* Resolver manifest dinámicamente
* Soportar HMR
* Permitir evolución futura hacia:

  * SSR
  * Hydration
  * Islands
  * Streaming

---

# Flujo General del Pipeline

```text id="q91p2j"
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
Environment Detection
    │
    ├── Development
    │       ▼
    │   HotReload Pipeline
    │
    └── Production
            ▼
        Manifest Pipeline
```

---

# Arquitectura del Pipeline

```text id="6ys8pv"
FrontendManager
│
├── EnvironmentDetector
├── AssetManager
├── ManifestManager
├── HotReloadManager
├── ViteManager
└── AssetRenderer
```

---

# Componentes del Pipeline

---

# EnvironmentDetector

## Responsabilidad

Determinar el entorno actual.

---

## Entornos soportados

```text id="w5m6aq"
development
production
```

---

## Responsabilidades

* detectar vite server
* detectar build mode
* detectar assets compilados
* resolver strategy

---

# AssetManager

## Responsabilidad

Resolver assets frontend.

---

## Responsabilidades

* css assets
* js assets
* asset paths
* asset urls
* imports
* chunk references

---

# ManifestManager

## Responsabilidad

Resolver assets compilados desde manifest.

---

## Responsabilidades

* cargar manifest
* parsear manifest
* resolver hashes
* resolver chunks
* resolver imports
* cache manifest

---

# HotReloadManager

## Responsabilidad

Gestionar assets en desarrollo.

---

## Responsabilidades

* detectar vite dev server
* generar urls HMR
* inyectar vite client
* resolver assets dinámicos

---

# AssetRenderer

## Responsabilidad

Generar HTML final de assets.

---

## Responsabilidades

* generar script tags
* generar link tags
* preload assets
* render css/js assets

---

# Pipeline en Desarrollo

---

# Flujo desarrollo

```text id="00d4i6"
Volt View
    │
    ▼
@frontend
    │
    ▼
FrontendManager
    │
    ▼
EnvironmentDetector
    │
    ▼
HotReloadManager
    │
    ▼
AssetRenderer
    │
    ▼
Generated HMR Assets
```

---

# Resultado generado

```html id="mnpcp8"
<script type="module" src="http://localhost:5173/@vite/client"></script>

<script type="module" src="http://localhost:5173/resources/js/app.js"></script>
```

---

# Características desarrollo

## HMR

* auto reload
* css hot swap
* instant rebuild
* runtime refresh

---

## Assets dinámicos

Los assets son servidos directamente por:

```text id="4l3jry"
Vite Dev Server
```

---

# Pipeline en Producción

---

# Flujo producción

```text id="pavihv"
Volt View
    │
    ▼
@frontend
    │
    ▼
FrontendManager
    │
    ▼
EnvironmentDetector
    │
    ▼
ManifestManager
    │
    ▼
AssetRenderer
    │
    ▼
Compiled Assets
```

---

# Resultado generado

```html id="yw7t6u"
<link rel="stylesheet" href="/build/assets/app.a82d.css">

<script type="module" src="/build/assets/app.92ks.js"></script>
```

---

# Manifest System

El manifest es el núcleo del pipeline en producción.

---

# Ubicación oficial

```text id="ff2vj6"
public/build/.vite/manifest.json
```

---

# Responsabilidades del manifest

* mapping assets
* versioning
* hashed files
* imports
* css dependencies
* dynamic chunks

---

# Ejemplo conceptual

```json id="3yj14q"
{
    "resources/js/app.js": {

        "file": "assets/app.92ks.js",

        "css": [
            "assets/app.a82d.css"
        ],

        "imports": [
            "assets/vendor.f82k.js"
        ]
    }
}
```

---

# Resolución de Assets

---

# Asset Request

```php id="sqrybs"
frontend()->asset('app.js');
```

---

# Pipeline interno

```text id="m9nkmu"
Asset Request
        │
        ▼
AssetManager
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

# Asset Rendering

---

# CSS Assets

## Desarrollo

```html id="wb7f7l"
<link rel="stylesheet" href="http://localhost:5173/resources/css/app.css">
```

---

## Producción

```html id="x0emlz"
<link rel="stylesheet" href="/build/assets/app.a82d.css">
```

---

# JS Assets

## Desarrollo

```html id="d27jpj"
<script type="module" src="http://localhost:5173/resources/js/app.js"></script>
```

---

## Producción

```html id="tbgjlwm"
<script type="module" src="/build/assets/app.92ks.js"></script>
```

---

# Chunk Resolution

El pipeline debe resolver automáticamente:

* vendor chunks
* dynamic imports
* lazy chunks
* css dependencies

---

# Flujo chunks

```text id="qsn5qo"
Manifest
    │
    ▼
Chunk Resolver
    │
    ▼
Dependency Graph
    │
    ▼
Generated Assets
```

---

# Dynamic Imports

El sistema debe soportar:

```js id="m0fj0j"
import('./dashboard.js');
```

---

# Responsabilidades

* resolver chunk dinámico
* resolver dependencias
* preload opcional
* lazy loading

---

# Asset Caching

---

# Manifest Cache

El manifest debe cachearse para evitar:

* filesystem overhead
* parsing repetitivo
* json decoding constante

---

# Estrategia

```text id="djlwm4"
manifest.json
        │
        ▼
Manifest Cache
        │
        ▼
Resolved Assets
```

---

# Asset Injection

La inyección ocurre mediante:

```volt id="9whzhw"
@frontend
```

o:

```volt id="0d3mu4"
<volt:frontend />
```

---

# Responsabilidades de inyección

* detectar entorno
* resolver assets
* generar tags
* generar preload
* inyectar HMR

---

# Volt Integration Pipeline

```text id="g2n6k7"
Volt Compiler
        │
        ▼
Frontend Directive
        │
        ▼
FrontendManager
        │
        ▼
Asset Pipeline
        │
        ▼
Generated HTML
```

---

# Pipeline de Build

---

# Desarrollo

```text id="p24ncz"
resources/
    │
    ▼
Vite Dev Server
    │
    ▼
Hot Assets
```

---

# Producción

```text id="r4w1pj"
resources/
    │
    ▼
Vite Build
    │
    ▼
Compiled Assets
    │
    ▼
manifest.json
```

---

# Build Directory

## Directorio oficial

```text id="0y65os"
public/build
```

---

# Entry Points Oficiales

```text id="bqudff"
resources/js/app.js
resources/css/app.css
```

---

# Future-ready Architecture

El pipeline está preparado para:

---

# SSR

```text id="b2wh6l"
SSR Manifest
SSR Chunks
SSR Assets
```

---

# Hydration

```text id="j5bj8j"
Hydration Scripts
Hydration Chunks
Hydration Runtime
```

---

# Islands

```text id="rrtfl8"
Island Chunks
Lazy Components
Selective Hydration
```

---

# Streaming

```text id="9buzx0"
Streaming Assets
Deferred Assets
Runtime Injection
```

---

# Restricciones Arquitectónicas

---

# 1. Volt Compiler NO resuelve assets

Toda resolución pertenece al:

```text id="p1jlwm"
FrontendManager
```

---

# 2. ManifestManager NO renderiza HTML

La renderización pertenece a:

```text id="j7yd93"
AssetRenderer
```

---

# 3. HotReloadManager NO conoce Volt

Debe permanecer desacoplado.

---

# 4. AssetRenderer NO conoce Vite

Debe trabajar con assets abstractos.

---

# Pipeline API

## Helper principal

```php id="4cg48m"
frontend()
```

---

# Métodos

```php id="a3rx6n"
frontend()->asset();

frontend()->render();

frontend()->manifest();

frontend()->isDevelopment();

frontend()->hotReload();
```

---

# Estado del Pipeline

```text id="2b98h0"
Status: Draft V1
Pipeline: Stable Foundation
Build Engine: Vite
CSS Engine: TailwindCSS
View Engine: Volt
```
