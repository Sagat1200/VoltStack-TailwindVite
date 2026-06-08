# 04_ASSET_PIPELINE.md

# VoltStack TailwindVite Ã¢â‚¬â€ Asset Pipeline

---

# IntroducciÃƒÂ³n

El Asset Pipeline de VoltStack TailwindVite es el sistema encargado de gestionar todo el ciclo de vida de los assets frontend dentro de VoltStack.

El pipeline es responsable de:

* resoluciÃƒÂ³n de assets
* compilaciÃƒÂ³n frontend
* manifest loading
* hot reload
* environment switching
* css/js injection
* chunk resolution
* dynamic imports

---

# FilosofÃƒÂ­a del Pipeline

El sistema de assets estÃƒÂ¡ diseÃƒÂ±ado bajo los principios:

* desacoplamiento
* modularidad
* environment awareness
* frontend abstraction
* runtime safety
* future scalability

---

# Objetivos del Pipeline

## Objetivos principales

* Resolver assets automÃƒÂ¡ticamente
* Separar desarrollo y producciÃƒÂ³n
* Integrar Vite con Volt
* Resolver manifest dinÃƒÂ¡micamente
* Soportar HMR
* Permitir evoluciÃƒÂ³n futura hacia:

  * SSR
  * Hydration
  * Islands
  * Streaming

---

# Flujo General del Pipeline

```text id="q91p2j"
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
Environment Detection
    Ã¢â€â€š
    Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ Development
    Ã¢â€â€š       Ã¢â€“Â¼
    Ã¢â€â€š   HotReload Pipeline
    Ã¢â€â€š
    Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ Production
            Ã¢â€“Â¼
        Manifest Pipeline
```

---

# Arquitectura del Pipeline

```text id="6ys8pv"
FrontendManager
Ã¢â€â€š
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ EnvironmentDetector
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ AssetManager
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ ManifestManager
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ HotReloadManager
Ã¢â€Å“Ã¢â€â‚¬Ã¢â€â‚¬ ViteManager
Ã¢â€â€Ã¢â€â‚¬Ã¢â€â‚¬ AssetRenderer
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
* resolver assets dinÃƒÂ¡micos

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
    Ã¢â€â€š
    Ã¢â€“Â¼
@tailwind-vite
    Ã¢â€â€š
    Ã¢â€“Â¼
FrontendManager
    Ã¢â€â€š
    Ã¢â€“Â¼
EnvironmentDetector
    Ã¢â€â€š
    Ã¢â€“Â¼
HotReloadManager
    Ã¢â€â€š
    Ã¢â€“Â¼
AssetRenderer
    Ã¢â€â€š
    Ã¢â€“Â¼
Generated HMR Assets
```

---

# Resultado generado

```html id="mnpcp8"
<script type="module" src="http://localhost:5173/@vite/client"></script>

<script type="module" src="http://localhost:5173/resources/js/app.js"></script>
```

---

# CaracterÃƒÂ­sticas desarrollo

## HMR

* auto reload
* css hot swap
* instant rebuild
* runtime refresh

---

## Assets dinÃƒÂ¡micos

Los assets son servidos directamente por:

```text id="4l3jry"
Vite Dev Server
```

---

# Pipeline en ProducciÃƒÂ³n

---

# Flujo producciÃƒÂ³n

```text id="pavihv"
Volt View
    Ã¢â€â€š
    Ã¢â€“Â¼
@tailwind-vite
    Ã¢â€â€š
    Ã¢â€“Â¼
FrontendManager
    Ã¢â€â€š
    Ã¢â€“Â¼
EnvironmentDetector
    Ã¢â€â€š
    Ã¢â€“Â¼
ManifestManager
    Ã¢â€â€š
    Ã¢â€“Â¼
AssetRenderer
    Ã¢â€â€š
    Ã¢â€“Â¼
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

El manifest es el nÃƒÂºcleo del pipeline en producciÃƒÂ³n.

---

# UbicaciÃƒÂ³n oficial

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

# ResoluciÃƒÂ³n de Assets

---

# Asset Request

```php id="sqrybs"
tailwind_vite()->asset('app.js');
```

---

# Pipeline interno

```text id="m9nkmu"
Asset Request
        Ã¢â€â€š
        Ã¢â€“Â¼
AssetManager
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

# Asset Rendering

---

# CSS Assets

## Desarrollo

```html id="wb7f7l"
<link rel="stylesheet" href="http://localhost:5173/resources/css/app.css">
```

---

## ProducciÃƒÂ³n

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

## ProducciÃƒÂ³n

```html id="tbgjlwm"
<script type="module" src="/build/assets/app.92ks.js"></script>
```

---

# Chunk Resolution

El pipeline debe resolver automÃƒÂ¡ticamente:

* vendor chunks
* dynamic imports
* lazy chunks
* css dependencies

---

# Flujo chunks

```text id="qsn5qo"
Manifest
    Ã¢â€â€š
    Ã¢â€“Â¼
Chunk Resolver
    Ã¢â€â€š
    Ã¢â€“Â¼
Dependency Graph
    Ã¢â€â€š
    Ã¢â€“Â¼
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

* resolver chunk dinÃƒÂ¡mico
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
        Ã¢â€â€š
        Ã¢â€“Â¼
Manifest Cache
        Ã¢â€â€š
        Ã¢â€“Â¼
Resolved Assets
```

---

# Asset Injection

La inyecciÃƒÂ³n ocurre mediante:

```volt id="9whzhw"
@tailwind-vite
```

o:

```volt id="0d3mu4"
<volt:frontend />
```

---

# Responsabilidades de inyecciÃƒÂ³n

* detectar entorno
* resolver assets
* generar tags
* generar preload
* inyectar HMR

---

# Volt Integration Pipeline

```text id="g2n6k7"
Volt Compiler
        Ã¢â€â€š
        Ã¢â€“Â¼
Frontend Directive
        Ã¢â€â€š
        Ã¢â€“Â¼
FrontendManager
        Ã¢â€â€š
        Ã¢â€“Â¼
Asset Pipeline
        Ã¢â€â€š
        Ã¢â€“Â¼
Generated HTML
```

---

# Pipeline de Build

---

# Desarrollo

```text id="p24ncz"
resources/
    Ã¢â€â€š
    Ã¢â€“Â¼
Vite Dev Server
    Ã¢â€â€š
    Ã¢â€“Â¼
Hot Assets
```

---

# ProducciÃƒÂ³n

```text id="r4w1pj"
resources/
    Ã¢â€â€š
    Ã¢â€“Â¼
Vite Build
    Ã¢â€â€š
    Ã¢â€“Â¼
Compiled Assets
    Ã¢â€â€š
    Ã¢â€“Â¼
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

El pipeline estÃƒÂ¡ preparado para:

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

# Restricciones ArquitectÃƒÂ³nicas

---

# 1. Volt Compiler NO resuelve assets

Toda resoluciÃƒÂ³n pertenece al:

```text id="p1jlwm"
FrontendManager
```

---

# 2. ManifestManager NO renderiza HTML

La renderizaciÃƒÂ³n pertenece a:

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
tailwind_vite()
```

---

# MÃƒÂ©todos

```php id="a3rx6n"
tailwind_vite()->asset();

tailwind_vite()->render();

tailwind_vite()->manifest();

tailwind_vite()->isDevelopment();

tailwind_vite()->hotReload();
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
