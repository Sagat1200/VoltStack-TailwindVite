# 03_VOLT_INTEGRATION.md

# VoltStack TailwindVite Ã¢â‚¬â€ Volt Integration

---

# IntroducciÃƒÂ³n

VoltStack TailwindVite se integra directamente con el sistema de vistas y compilaciÃƒÂ³n de VoltStack mediante el compilador oficial:

```text id="6m0vq5"
Volt Compiler
```

La integraciÃƒÂ³n permite que las vistas Volt puedan:

* cargar assets frontend
* resolver manifest
* habilitar hot reload
* cargar Vite runtime
* resolver assets compilados
* integrar TailwindCSS automÃƒÂ¡ticamente

sin acoplar el compilador directamente a Vite o Tailwind.

---

# FilosofÃƒÂ­a de IntegraciÃƒÂ³n

La integraciÃƒÂ³n frontend debe seguir los principios arquitectÃƒÂ³nicos de VoltStack:

* desacoplamiento
* compilaciÃƒÂ³n declarativa
* runtime limpio
* frontend abstracto
* render pipeline modular

---

# Objetivo de la IntegraciÃƒÂ³n

El objetivo principal es permitir que el compilador Volt pueda interactuar con el sistema frontend mediante:

* directivas
* tags
* compiler hooks
* runtime hooks

sin depender directamente de Vite.

---

# Arquitectura de IntegraciÃƒÂ³n

```text id="0e0mfr"
Volt Views
    Ã¢â€â€š
    Ã¢â€“Â¼
Volt Compiler
    Ã¢â€â€š
    Ã¢â€“Â¼
Volt Frontend Directives
    Ã¢â€â€š
    Ã¢â€“Â¼
Frontend Integration Layer
    Ã¢â€â€š
    Ã¢â€“Â¼
FrontendManager
    Ã¢â€â€š
    Ã¢â€“Â¼
TailwindVite Infrastructure
```

---

# IntegraciÃƒÂ³n por Directivas

La integraciÃƒÂ³n principal ocurre mediante directivas Volt.

---

# Directiva principal

```volt id="3u4cz8"
@tailwind-vite
```

---

# Responsabilidad de la directiva

La directiva:

```volt id="m3xskq"
@tailwind-vite
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

    @tailwind-vite

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

# Resultado en producciÃƒÂ³n

```html id="dr7z9h"
<link rel="stylesheet" href="/build/assets/app.8x2d.css">

<script type="module" src="/build/assets/app.9d3f.js"></script>
```

---

# IntegraciÃƒÂ³n mediante Tags

Volt tambiÃƒÂ©n soportarÃƒÂ¡ integraciÃƒÂ³n mediante tags.

---

# Tag oficial

```volt id="lhyls4"
<volt:frontend />
```

---

# Objetivo del tag

El tag proporciona:

* sintaxis declarativa
* mejor integraciÃƒÂ³n visual
* soporte futuro para atributos
* extensibilidad SSR
* integraciÃƒÂ³n hydration

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

# IntegraciÃƒÂ³n con el Volt Compiler

La integraciÃƒÂ³n NO ocurre directamente en runtime.

Ocurre durante el proceso de compilaciÃƒÂ³n.

---

# Flujo de compilaciÃƒÂ³n

```text id="mww9mu"
Volt Template
        Ã¢â€â€š
        Ã¢â€“Â¼
Volt Parser
        Ã¢â€â€š
        Ã¢â€“Â¼
Directive Resolver
        Ã¢â€â€š
        Ã¢â€“Â¼
Frontend Compiler Hook
        Ã¢â€â€š
        Ã¢â€“Â¼
FrontendManager
        Ã¢â€â€š
        Ã¢â€“Â¼
Generated HTML
```

---

# Compiler Hooks

El compilador Volt expondrÃƒÂ¡ hooks oficiales para integraciÃƒÂ³n frontend.

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
        return tailwind_vite()->render();
    }
}
```

---

# Render Pipeline

La integraciÃƒÂ³n frontend utiliza el pipeline oficial Volt.

---

# Flujo

```text id="d60lbv"
Volt Template
        Ã¢â€â€š
        Ã¢â€“Â¼
Volt Compiler
        Ã¢â€â€š
        Ã¢â€“Â¼
Directive Compilation
        Ã¢â€â€š
        Ã¢â€“Â¼
Frontend Resolution
        Ã¢â€â€š
        Ã¢â€“Â¼
HTML Injection
        Ã¢â€â€š
        Ã¢â€“Â¼
Compiled View
```

---

# Frontend Resolution

El sistema frontend debe resolver automÃƒÂ¡ticamente:

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
```

---

# ProducciÃƒÂ³n

## Flujo producciÃƒÂ³n

```text id="ajc6lf"
Volt View
    Ã¢â€â€š
    Ã¢â€“Â¼
@tailwind-vite
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

# IntegraciÃƒÂ³n con Runtime Volt

El compilador Volt NO debe conocer detalles internos de:

* Vite
* Tailwind
* manifest
* HMR

Toda resoluciÃƒÂ³n pertenece al sistema frontend.

---

# SeparaciÃƒÂ³n de responsabilidades

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

# API PÃƒÂºblica

## Helper

```php id="4udj5h"
tailwind_vite()
```

---

# MÃƒÂ©todos principales

```php id="tw4qff"
tailwind_vite()->render();

tailwind_vite()->asset('app.js');

tailwind_vite()->manifest();

tailwind_vite()->isDevelopment();

tailwind_vite()->hotReload();
```

---

# Frontend Render

## Ejemplo conceptual

```php id="n5m1di"
tailwind_vite()->render();
```

---

# Responsabilidad

Debe generar automÃƒÂ¡ticamente:

## Desarrollo

```html id="1w7yxt"
<script type="module" src="http://localhost:5173/@vite/client"></script>

<script type="module" src="http://localhost:5173/resources/js/app.js"></script>
```

---

## ProducciÃƒÂ³n

```html id="5w49jt"
<link rel="stylesheet" href="/build/assets/app.css">

<script type="module" src="/build/assets/app.js"></script>
```

---

# IntegraciÃƒÂ³n con Volt Runtime

La integraciÃƒÂ³n futura permitirÃƒÂ¡:

* hydration
* runtime assets
* streaming assets
* island assets
* lazy assets

---

# IntegraciÃƒÂ³n SSR futura

La arquitectura estÃƒÂ¡ preparada para:

```text id="8tbkg0"
Volt SSR
```

---

# Flujo SSR futuro

```text id="8z33t4"
SSR Renderer
        Ã¢â€â€š
        Ã¢â€“Â¼
FrontendManager
        Ã¢â€â€š
        Ã¢â€“Â¼
SSR Manifest
        Ã¢â€â€š
        Ã¢â€“Â¼
SSR Assets
```

---

# IntegraciÃƒÂ³n futura con Native UI

El sistema Native UI reutilizarÃƒÂ¡:

* asset pipeline
* manifest
* frontend runtime
* vite integration

---

# IntegraciÃƒÂ³n futura con Hydration

El runtime hydration utilizarÃƒÂ¡:

* frontend manifest
* runtime chunks
* lazy chunks
* hydration scripts

---

# IntegraciÃƒÂ³n futura con Islands

Las islands reutilizarÃƒÂ¡n:

* chunk resolver
* manifest loader
* asset injector

---

# Restricciones ArquitectÃƒÂ³nicas

---

# 1. Volt Compiler NO debe depender de Vite

El compilador ÃƒÂºnicamente expone hooks.

---

# 2. El sistema frontend NO debe modificar el compilador

Debe integrarse mediante APIs oficiales.

---

# 3. FrontendManager es el ÃƒÂºnico punto de entrada

Toda resoluciÃƒÂ³n frontend debe pasar por:

```php id="e9a5o8"
FrontendManager
```

---

# 4. Las directivas Volt NO contienen lÃƒÂ³gica compleja

La lÃƒÂ³gica pertenece a:

```text id="8i0tr8"
FrontendManager
```

---

# Convenciones Oficiales

## Directiva principal

```volt id="slpv7t"
@tailwind-vite
```

---

## Tag principal

```volt id="z6ozx5"
<volt:frontend />
```

---

## Helper principal

```php id="k1usn4"
tailwind_vite()
```

---

# Estado de integraciÃƒÂ³n

```text id="rwwg5h"
Status: Draft V1
Integration Layer: Stable
Compiler: Volt
Frontend Engine: TailwindCSS + Vite
Rendering Pipeline: Volt Compiler
```
