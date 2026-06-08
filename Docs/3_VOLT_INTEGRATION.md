# 03_VOLT_INTEGRATION.md

# VoltStack TailwindVite — Volt Integration

---

# Introducción

VoltStack TailwindVite se integra directamente con el sistema de vistas y compilación de VoltStack mediante el compilador oficial:

```text id="6m0vq5"
Volt Compiler
```

La integración permite que las vistas Volt puedan:

* cargar assets frontend
* resolver manifest
* habilitar hot reload
* cargar Vite runtime
* resolver assets compilados
* integrar TailwindCSS automáticamente

sin acoplar el compilador directamente a Vite o Tailwind.

---

# Filosofía de Integración

La integración frontend debe seguir los principios arquitectónicos de VoltStack:

* desacoplamiento
* compilación declarativa
* runtime limpio
* frontend abstracto
* render pipeline modular

---

# Objetivo de la Integración

El objetivo principal es permitir que el compilador Volt pueda interactuar con el sistema frontend mediante:

* directivas
* tags
* compiler hooks
* runtime hooks

sin depender directamente de Vite.

---

# Arquitectura de Integración

```text id="0e0mfr"
Volt Views
    │
    ▼
Volt Compiler
    │
    ▼
Volt Frontend Directives
    │
    ▼
Frontend Integration Layer
    │
    ▼
FrontendManager
    │
    ▼
TailwindVite Infrastructure
```

---

# Integración por Directivas

La integración principal ocurre mediante directivas Volt.

---

# Directiva principal

```volt id="3u4cz8"
@frontend
```

---

# Responsabilidad de la directiva

La directiva:

```volt id="m3xskq"
@frontend
```

debe:

* detectar entorno
* resolver assets
* cargar HMR
* resolver manifest
* cargar assets compilados
* generar HTML final

---

# Ejemplo conceptual

## Volt Source

```volt id="e6rb5u"
<html>

<head>

    @frontend

</head>

<body>

    {{ $slot }}

</body>

</html>
```

---

# Resultado en desarrollo

```html id="0d0mzw"
<script type="module" src="http://localhost:5173/@vite/client"></script>

<script type="module" src="http://localhost:5173/resources/js/app.js"></script>
```

---

# Resultado en producción

```html id="dr7z9h"
<link rel="stylesheet" href="/build/assets/app.8x2d.css">

<script type="module" src="/build/assets/app.9d3f.js"></script>
```

---

# Integración mediante Tags

Volt también soportará integración mediante tags.

---

# Tag oficial

```volt id="lhyls4"
<volt:frontend />
```

---

# Objetivo del tag

El tag proporciona:

* sintaxis declarativa
* mejor integración visual
* soporte futuro para atributos
* extensibilidad SSR
* integración hydration

---

# Ejemplo futuro

```volt id="d3q0cv"
<volt:frontend
    hot-reload
    preload
    integrity
/>
```

---

# Integración con el Volt Compiler

La integración NO ocurre directamente en runtime.

Ocurre durante el proceso de compilación.

---

# Flujo de compilación

```text id="mww9mu"
Volt Template
        │
        ▼
Volt Parser
        │
        ▼
Directive Resolver
        │
        ▼
Frontend Compiler Hook
        │
        ▼
FrontendManager
        │
        ▼
Generated HTML
```

---

# Compiler Hooks

El compilador Volt expondrá hooks oficiales para integración frontend.

---

# Hook principal

```php id="5r0j1d"
Compiler::directive('frontend', FrontendDirective::class);
```

---

# Responsabilidades del Hook

El hook debe:

* interceptar directiva
* resolver entorno
* generar output frontend
* cargar assets apropiados

---

# Volt Frontend Directive

## Clase conceptual

```php id="v6if6w"
class FrontendDirective
{
    public function compile(): string
    {
        return frontend()->render();
    }
}
```

---

# Render Pipeline

La integración frontend utiliza el pipeline oficial Volt.

---

# Flujo

```text id="d60lbv"
Volt Template
        │
        ▼
Volt Compiler
        │
        ▼
Directive Compilation
        │
        ▼
Frontend Resolution
        │
        ▼
HTML Injection
        │
        ▼
Compiled View
```

---

# Frontend Resolution

El sistema frontend debe resolver automáticamente:

* entorno
* manifest
* hot reload
* css
* js
* imports
* chunks

---

# Desarrollo

## Flujo desarrollo

```text id="1svihw"
Volt View
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
```

---

# Producción

## Flujo producción

```text id="ajc6lf"
Volt View
    │
    ▼
@frontend
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

# Integración con Runtime Volt

El compilador Volt NO debe conocer detalles internos de:

* Vite
* Tailwind
* manifest
* HMR

Toda resolución pertenece al sistema frontend.

---

# Separación de responsabilidades

## Volt Compiler

Responsable de:

* parsear vistas
* compilar directivas
* renderizar templates

---

## TailwindVite Package

Responsable de:

* assets
* frontend runtime
* vite integration
* manifest
* hmr

---

# API Pública

## Helper

```php id="4udj5h"
frontend()
```

---

# Métodos principales

```php id="tw4qff"
frontend()->render();

frontend()->asset('app.js');

frontend()->manifest();

frontend()->isDevelopment();

frontend()->hotReload();
```

---

# Frontend Render

## Ejemplo conceptual

```php id="n5m1di"
frontend()->render();
```

---

# Responsabilidad

Debe generar automáticamente:

## Desarrollo

```html id="1w7yxt"
<script type="module" src="http://localhost:5173/@vite/client"></script>

<script type="module" src="http://localhost:5173/resources/js/app.js"></script>
```

---

## Producción

```html id="5w49jt"
<link rel="stylesheet" href="/build/assets/app.css">

<script type="module" src="/build/assets/app.js"></script>
```

---

# Integración con Volt Runtime

La integración futura permitirá:

* hydration
* runtime assets
* streaming assets
* island assets
* lazy assets

---

# Integración SSR futura

La arquitectura está preparada para:

```text id="8tbkg0"
Volt SSR
```

---

# Flujo SSR futuro

```text id="8z33t4"
SSR Renderer
        │
        ▼
FrontendManager
        │
        ▼
SSR Manifest
        │
        ▼
SSR Assets
```

---

# Integración futura con Native UI

El sistema Native UI reutilizará:

* asset pipeline
* manifest
* frontend runtime
* vite integration

---

# Integración futura con Hydration

El runtime hydration utilizará:

* frontend manifest
* runtime chunks
* lazy chunks
* hydration scripts

---

# Integración futura con Islands

Las islands reutilizarán:

* chunk resolver
* manifest loader
* asset injector

---

# Restricciones Arquitectónicas

---

# 1. Volt Compiler NO debe depender de Vite

El compilador únicamente expone hooks.

---

# 2. El sistema frontend NO debe modificar el compilador

Debe integrarse mediante APIs oficiales.

---

# 3. FrontendManager es el único punto de entrada

Toda resolución frontend debe pasar por:

```php id="e9a5o8"
FrontendManager
```

---

# 4. Las directivas Volt NO contienen lógica compleja

La lógica pertenece a:

```text id="8i0tr8"
FrontendManager
```

---

# Convenciones Oficiales

## Directiva principal

```volt id="slpv7t"
@frontend
```

---

## Tag principal

```volt id="z6ozx5"
<volt:frontend />
```

---

## Helper principal

```php id="k1usn4"
frontend()
```

---

# Estado de integración

```text id="rwwg5h"
Status: Draft V1
Integration Layer: Stable
Compiler: Volt
Frontend Engine: TailwindCSS + Vite
Rendering Pipeline: Volt Compiler
```
