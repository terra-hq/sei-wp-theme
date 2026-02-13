# CLAUDE.md - Project Guide

## Project Overview
WordPress theme (sei-vite-theme) with Vite build system, Vue 3, GSAP animations, and Swup page transitions.

## Directory Structure
- `src/js/` - JavaScript source (handlers, modules, motion, services)
- `src/scss/` - SCSS styles (framework, global-components)
- `functions/default/` - Framework core classes (mostly unedited, mark changes with emoji)
- `functions/default/terraClasses/` - Reusable PHP classes (Custom_Post_Type, MailTo, Grammar, etc.)
- `functions/project/` - Project-specific PHP (post-types, taxonomies, enqueues, utilities)
- `functions/project/custom/acf/` - ACF custom field types and visual modules
- `functions/project/utilities/endpoints/` - REST API endpoints
- `components/` - WordPress theme components
- `flexible/` - Flexible content modules
- `config/` - Build/deploy configuration
- `dist/` - Production build output
- `public/` - Static assets (fonts, images)

## Build & Deploy
- `npm run virtual` - Vite dev server (port 9090 with HMR)
- `npm run local` - Local build
- `npm run build` - Production build
- `gulp ddist --dev|stage|production` - Deploy dist files via SFTP
- `gulp dfm --dev|stage|production` - Deploy flexible modules via SFTP

## PHP Conventions
- No namespaces - classes are global
- No PSR-4 autoloading - manual `require` in index files
- Classes instantiated with config objects: `new ClassName((object) array(...))`
- Default classes live in `functions/default/terraClasses/`
- Project customizations in `functions/project/`

## JS/CSS Stack
- **Vue 3** for interactive components
- **Swup** for AJAX page transitions
- **GSAP + Boostify** for animations
- **SCSS** with path aliases (`@scss`, `@scssFoundation`, `@scssComponents`)
- ES Modules, no TypeScript

## Environment
- `.env.local`, `.env.virtual`, `.env.production` for environment config
- `IS_VITE_DEVELOPMENT` and `DEV_IDENTIFIER` constants control dev/prod behavior

## Key Classes (terraClasses)
- `Grammar` - Grammar/spelling validation via Spling API, sends email reports on post publish
- `MailTo` - Sends HTML emails via `wp_mail()`
- `Custom_Post_Type` - Registers CPTs dynamically
- `Custom_Taxonomy` - Registers taxonomies dynamically
- `Custom_API_Endpoint` - REST API endpoint registration
- `TerraLighthouse` - Lighthouse performance monitoring
- `Cronjob` - Scheduled task management
