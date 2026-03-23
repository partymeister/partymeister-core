# Partymeister — V2 API Implementation Plan

## Overview

Go fully headless: migrate from motor-backend to motor-admin, then expose all business
logic through a V2 API following motor-admin V2 patterns. Old backend Blade code stays
in place as reference but will no longer be functional.

### Target architecture

```
/api/v2/                  — RESTful resources (auth:sanctum + V2ErrorHandler)
/api/v2/auth/             — Visitor auth (mixed auth)
/api/v2/public/           — Unauthenticated read-only
/api/v2/rpc/              — Non-RESTful operations (auth:sanctum + V2ErrorHandler)
```

### V2 pattern (per resource)

- **Controller** extends `Motor\Core\Http\Controllers\Api\V2\ApiController`
- **Resource** extends `Motor\Core\Http\Resources\V2\BaseResource`
- **Collection** extends `Motor\Core\Http\Resources\V2\BaseCollection`
- **Form Requests**: separate Get/Post/Patch per resource
- **Service**: reuse existing services (adapt to motor-admin BaseService)
- **Routes**: kebab-case, `apiResource()`, `auth:sanctum` + `V2ErrorHandler`

### Response envelope

```json
// Success (single)
{ "data": { ... }, "meta": { "api_version": "v2", "message": "..." } }

// Success (collection)
{ "data": [...], "links": { ... }, "meta": { "api_version": "v2", ... } }

// Error
{ "error": { "code": "...", "message": "...", "details": { ... } }, "meta": { "api_version": "v2" } }
```

### Dependency chain (feature branches)

```
motor-core (feature/EN-1812)     — V2 base classes, Sanctum, Scramble, Meilisearch
  └─ motor-admin (feature/EN-1812) — replaces motor-backend, API-only, no forms/grids
       └─ motor-media (feature/EN-1812) — depends on motor-admin, not motor-backend
```

All three must switch together. motor-backend is dropped entirely.

---

## Prerequisites

- [ ] Copy `/Users/dfox/Development/partymeister-template` to isolated working directory
- [ ] Create `v2-api` branches on all partymeister packages (off `2026`)
- [ ] Switch motor submodules to feature branches:
  - `motor-core` → `feature/EN-1812-api-v2-versioning`
  - `motor-media` → `feature/EN-1812-api-v2-versioning`
- [ ] Replace `motor-backend` submodule with `motor-admin` (`feature/EN-1812-api-v2-versioning`)
- [ ] Update `motor-cms` — check compatibility or switch branch
- [ ] Run `composer update` to verify dependency resolution
- [ ] Confirm Docker dev environment boots

---

## Phase 0: motor-backend → motor-admin namespace migration

### Scope

632 files across all packages reference `Motor\Admin` or `motor-backend`:

| Package | Files affected |
|---|---|
| partymeister-core | 130 |
| partymeister-competitions | 159 |
| partymeister-accounting | 88 |
| partymeister-slides | 87 |
| motor-revision | 88 |
| motor-cms | 48 |
| motor-core | 18 (handled by feature branch) |
| motor-media | 11 (handled by feature branch) |
| partymeister-frontend | 3 |

motor-core and motor-media are handled by their feature branches. Remaining: ~596 files
across 7 packages need migration.

### 0.1 Namespace find/replace (mechanical)

For each partymeister/motor package:

```
Motor\Admin\    → Motor\Admin\
motor-backend::   → motor-admin::        (view/translation references)
motor-backend.    → motor-admin.          (config references)
motor-cms/motor-backend → motor-cms/motor-admin  (composer.json)
```

Reference categories in partymeister-core (representative):

| Reference type | Count | Action |
|---|---|---|
| `@param \Motor\Admin\Models\User` (PHPDoc) | 56 | Find/replace |
| `use Motor\Admin\Models\User` | 11 | Find/replace |
| `use Motor\Admin\Http\Resources\BaseResource` | 11 | Find/replace |
| `use Motor\Admin\Http\Controllers\Controller` | 11 | Find/replace |
| `use Motor\Admin\Http\Resources\BaseCollection` | 9 | Find/replace |
| `use Motor\Admin\Http\Controllers\ApiController` | 9 | Find/replace |
| `use Motor\Admin\Services\BaseService` | 7 | Find/replace |
| `use Motor\Admin\Http\Requests\Request` | 7 | Find/replace |
| `use Motor\Admin\Grid\Grid` | 7 | Find/replace (dead code) |
| `trans('motor-backend::...')` | ~15 | Find/replace |
| `config('motor-backend...')` | ~3 | Find/replace |

### 0.2 Breaking changes to handle

**a) BaseService: Form methods removed**

Backend controllers use `createWithForm()` / `updateWithForm()`. These methods no longer
exist in motor-admin's BaseService. Backend code is kept as reference (non-functional),
so these calls will just be dead code. No action needed.

For V2 controllers: use `Service::create($request)` / `Service::update($model, $request)`
which works identically in both versions.

**b) BaseService: setRequest signature changed**

Old: `setRequest(Request $request, $form = null)`
New: `setRequest(Request|array $request)`

Services that override this or pass a form will break in backend code. V2 code uses
the new signature. No action needed for dead backend code.

**c) File upload payload format**

Old: `$data[$identifier]` contains base64
New: `$data[$identifier.'.dataUrl']` contains base64, `$data[$identifier.'.name']` for filename

Any service with `uploadFile()` calls needs checking. In partymeister-core this
primarily affects media/slide uploads (partymeister-slides package).

**d) Search: Searchable trait → Scout**

User and Client models switch from `Motor\Core\Traits\Searchable` to `Laravel\Scout\Searchable`.
This changes how search queries work. For V2, Scout is the target anyway. Backend code
using the old search will be dead.

### 0.3 Backend code disposition

All backend code (Forms/, Grids/, Backend controllers, Blade views) stays in place:
- Namespace references updated to `Motor\Admin\*` for consistency
- Code won't actually run (motor-admin has no Form/Grid base classes)
- Serves as reference when building V2 equivalents
- Will be cleaned up after Nuxt admin frontend is complete

---

## Phase 1: Testing Infrastructure

### 1.1 Install Pest 3
- Add `pestphp/pest`, `pestphp/pest-plugin-laravel` to root `composer.json` dev deps
- Run `pest --init`

### 1.2 Base TestCase (`tests/TestCase.php`)
- `admin()` / `asAdmin()` — backend User with Sanctum
- `visitor()` / `asVisitor()` — Visitor model with Sanctum
- `withJsonHeaders()` helper

### 1.3 Global test helpers (`tests/Pest.php`)

Port from energis:
- `assertV2ResponseEnvelope($response)`
- `assertV2CrudIndex(endpoint, expectedCount, fields)`
- `assertV2CrudShow(endpoint, fields)`
- `assertV2CrudCreate(endpoint, data, modelClass)`
- `assertV2CrudUpdate(endpoint, data, checkField, checkValue)`
- `assertV2CrudDelete(endpoint, modelClass)` — 204
- `assertV2CrudValidation(endpoint, data)` — 422
- `assertV2PermissionsDenied(endpoint, recordId)` — 403

Wire `beforeAll` with `migrate:fresh --seed`.

### 1.4 Update `phpunit.xml`
- Add `packages/partymeister-core/tests/Feature` suite
- Configure test database

### 1.5 Seeders
- Verify existing seeders + factories cover test needs
- May need `PartymeisterCoreTestSeeder` for admin user + permissions + sample data

---

## Phase 2: Proof-of-concept (EventTypes)

Simplest resource — no relations, no business logic in service. Proves full V2 stack.

### 2.1 Register V2 route group in `routes/api.php`
```php
Route::prefix('v2')
    ->name('v2.')
    ->middleware(['auth:sanctum', V2ErrorHandler::class])
    ->group(function () {
        Route::apiResource('event-types', V2\EventTypesController::class);
    });
```

### 2.2 Scaffold EventTypes
- `Http/Controllers/Api/V2/EventTypesController.php`
- `Http/Resources/V2/EventTypeResource.php` (id, name, web_color, slide_color, timestamps)
- `Http/Resources/V2/EventTypeCollection.php`
- `Http/Requests/Api/V2/EventTypeGetRequest.php`
- `Http/Requests/Api/V2/EventTypePostRequest.php`
- `Http/Requests/Api/V2/EventTypePatchRequest.php`

### 2.3 Test: `tests/Feature/V2EventTypeTest.php`
- Index (200), show (200), create (201), update (200), delete (204)
- Validation (422), not-found (404), permissions denied (403)
- V2 envelope on all responses

### 2.4 Verify
- V2 endpoint works end-to-end
- Old `api/event_types` routes: dead (backend code kept as reference)

---

## Phase 3: Remaining RESTful Resources

Same pattern as Phase 2 for each. 6 files + 1 test file per resource.

### 3.1 Events
- Route: `v2/events`
- Resource includes nested `EventTypeResource`, `ScheduleResource` via `whenLoaded()`
- Test: `V2EventTest.php`

### 3.2 Schedules
- Route: `v2/schedules`
- Test: `V2ScheduleTest.php`

### 3.3 Visitors
- Route: `v2/visitors`
- PostRequest: name required, email unique|nullable, password required
- PatchRequest: password nullable (service handles empty)
- Test: `V2VisitorTest.php`

### 3.4 Guests
- Route: `v2/guests`
- Resource includes ticket/arrival tracking fields
- Test: `V2GuestTest.php`

### 3.5 Callbacks
- Route: `v2/callbacks`
- Service already generates hash in `beforeCreate`
- Test: `V2CallbackTest.php`

### 3.6 Message Groups
- Route: `v2/message-groups` (kebab-case)
- Resource includes user relation via `whenLoaded()`
- Test: `V2MessageGroupTest.php`

---

## Phase 4: RPC Endpoints

### 4.1 Route group
```php
Route::prefix('v2/rpc')
    ->name('v2.rpc.')
    ->middleware(['auth:sanctum', V2ErrorHandler::class])
    ->group(function () { ... });
```

### 4.2 Callback Fire
- `POST v2/rpc/callbacks/{callback}/fire`
- Single-action controller `Rpc/Callbacks/FireController.php`
- Port logic from `SendController::callback()`
- Note: cross-references Competition/Entry/LiveVote from partymeister-competitions
- Test: `V2Rpc/CallbackFireTest.php`

### 4.3 Callback Send Test
- `POST v2/rpc/callbacks/send-test`
- Single-action controller `Rpc/Callbacks/SendTestController.php`
- Calls `StuhlService::send('TEST')`

### 4.4 Guest Ticket Scan
- `POST v2/rpc/guests/scan-ticket`
- Single-action controller `Rpc/Guests/ScanTicketController.php`
- Port from `ScanTicketsController::index()`
- Return structured data (no HTML in response)
- Test: `V2Rpc/GuestScanTicketTest.php`

### 4.5 Event Playlist
- `GET/POST v2/rpc/events/{event}/playlist`
- Controller `Rpc/Events/PlaylistController.php`
- Test: `V2Rpc/EventPlaylistTest.php`

### 4.6 Schedule Playlist
- `GET/POST v2/rpc/schedules/{schedule}/playlist`
- Controller `Rpc/Schedules/PlaylistController.php`
- Test: `V2Rpc/SchedulePlaylistTest.php`

---

## Phase 5: Auth Endpoints

### 5.1 Route group
```php
Route::prefix('v2/auth')
    ->name('v2.auth.')
    ->middleware([V2ErrorHandler::class])
    ->group(function () { ... });
```

### 5.2 Login — `POST v2/auth/login`
- Controller: `Auth/LoginController.php`
- Returns Sanctum token + visitor profile
- Port from `VisitorLoginService`

### 5.3 Register — `POST v2/auth/register`
- Controller: `Auth/RegisterController.php`
- Port from `VisitorRegistrationService`
- Respects `PM_VISITOR_LOGIN_ENABLED` config

### 5.4 Logout — `POST v2/auth/logout` (auth:sanctum)
- Controller: `Auth/LogoutController.php`
- Revokes current Sanctum token

### 5.5 Password Forgot — `POST v2/auth/password/forgot`
- Controller: `Auth/PasswordForgotController.php`
- Sends `PasswordReset` mailable

### 5.6 Password Reset — `POST v2/auth/password/reset`
- Controller: `Auth/PasswordResetController.php`

### 5.7 Current Profile — `GET v2/auth/me` (auth:sanctum)
- Controller: `Auth/MeController.php`

### Tests
- `V2Auth/LoginTest.php`
- `V2Auth/RegisterTest.php`
- `V2Auth/PasswordResetTest.php`

---

## Phase 6: Public Endpoints

### 6.1 Route group
```php
Route::prefix('v2/public')
    ->name('v2.public.')
    ->middleware([V2ErrorHandler::class])
    ->group(function () { ... });
```

### 6.2 Public resources (read-only, index + show)
- `GET v2/public/visitors`
- `GET v2/public/events`
- `GET v2/public/schedules`
- `GET v2/public/event-types`

Reuse V2 Resources from Phase 3.

### Tests
- `V2Public/EventsTest.php`
- `V2Public/SchedulesTest.php`

---

## Phase 7: Quality & Verification

- [ ] All V2 responses have correct envelope
- [ ] Status codes: 201 create, 204 delete, 422 validation, 403 forbidden, 404 not found
- [ ] Run Pint formatting
- [ ] No N+1 queries (use `whenLoaded()` consistently)
- [ ] All tests pass

---

## File Inventory

| Category | Count | Phase |
|---|---|---|
| Namespace migration (existing files) | ~596 | 0 |
| V2 Controllers (CRUD) | 7 | 2-3 |
| V2 Controllers (RPC) | 6 | 4 |
| V2 Controllers (Auth) | 6 | 5 |
| V2 Controllers (Public) | 1-4 | 6 |
| V2 Resources | 7 | 2-3 |
| V2 Collections | 7 | 2-3 |
| V2 Form Requests (CRUD) | ~21 | 2-3 |
| V2 Form Requests (Auth) | ~6 | 5 |
| Route additions | 1 | 2-6 |
| Test infrastructure | ~3 | 1 |
| Test files | ~16 | 2-6 |
| **New files total** | **~80-84** | |
| **Existing files modified** | **~597** | 0 |
| **Existing files deleted** | **0** | |

---

## Scope: partymeister-core first

This plan covers partymeister-core as the template. Once proven, the same pattern
applies to all other partymeister packages:

- **partymeister-competitions** — entries, votes, competitions, live voting (159 files to migrate)
- **partymeister-accounting** — items, sales, POS (88 files to migrate)
- **partymeister-slides** — slides, playlists, transitions (87 files to migrate)
- **partymeister-frontend** — page rendering, navigation (3 files to migrate)
- **motor-revision** — revision-specific features (88 files to migrate)
- **motor-cms** — pages, navigation, components (48 files to migrate)

---

## Reference

- Motor-admin V2 pattern: `energis-website-backend-motor/packages/motor-admin/src/Http/Controllers/Api/V2/`
- Motor-core V2 base classes: `motor-core` branch `feature/EN-1812-api-v2-versioning`
- Motor-admin BaseService: `energis-website-backend-motor/packages/motor-admin/src/Services/BaseService.php`
- Test pattern: `energis-website-backend-motor/packages/motor-scoring/tests/Feature/V2ScoreTest.php`
- Test helpers: `energis-website-backend-motor/tests/Pest.php`
