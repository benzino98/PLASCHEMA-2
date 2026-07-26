# PLASCHEMA API v1

Base URL: `https://your-domain.example/api/v1`

The API exposes published public content and a Sanctum-protected content-management surface for trusted first-party integrations.

## Authentication

Create a token with an existing admin or editor account:

```bash
curl -X POST https://your-domain.example/api/v1/auth/token \
  -H 'Accept: application/json' \
  -H 'Content-Type: application/json' \
  -d '{"email":"editor@plaschema.gov.ng","password":"YOUR_PASSWORD","device_name":"mobile-app"}'
```

Use the returned token:

```bash
curl https://your-domain.example/api/v1/admin/providers \
  -H 'Accept: application/json' \
  -H 'Authorization: Bearer YOUR_TOKEN'
```

Revoke the current token:

```bash
curl -X DELETE https://your-domain.example/api/v1/auth/token \
  -H 'Accept: application/json' \
  -H 'Authorization: Bearer YOUR_TOKEN'
```

> Tokens are displayed only once. Never commit credentials or tokens, expose them in client-side source code, or share them in logs.

## Public Endpoints

| Method | Endpoint | Filters |
|---|---|---|
| GET | `/plans` | `sector`, `featured`, `per_page` |
| GET | `/plans/{slug}` | — |
| GET | `/providers` | `q`, `lga`, `specialty`, `ownership`, `service`, `per_page` |
| GET | `/providers/search` | Same provider filters |
| GET | `/providers/{slug}` | — |
| GET | `/news` | `q`, `category`, `per_page` |
| GET | `/news/{slug}` | — |
| GET | `/faqs` | `category` (slug) |
| GET | `/downloads` | `q`, `category`, `per_page` |
| POST | `/contact` | JSON body: `name`, `email`, `subject`, `message` |

Pagination defaults to 15 items and is capped at 50. Collection responses use Laravel Resource pagination with `data`, `links`, and `meta`.

Example provider search:

```bash
curl 'https://your-domain.example/api/v1/providers/search?lga=Jos%20North&specialty=General&per_page=20' \
  -H 'Accept: application/json'
```

## Protected Content Endpoints

All require `Authorization: Bearer ...`. Both admin and editor tokens may manage content.

| Resource | Endpoints |
|---|---|
| Providers | `GET/POST /admin/providers`, `PUT/DELETE /admin/providers/{slug}` |
| Plans | `GET/POST /admin/plans`, `PUT/DELETE /admin/plans/{id}` |
| News | `GET/POST /admin/news`, `PUT/DELETE /admin/news/{id}` |
| FAQs | `GET/POST /admin/faqs`, `PUT/DELETE /admin/faqs/{id}` |
| Downloads | `GET /admin/downloads`, `PUT/DELETE /admin/downloads/{slug}` |
| Messages | `GET /admin/messages`, `GET /admin/messages/{id}`, `PATCH /admin/messages/{id}/read` |

Contact-message endpoints require an **admin** token. The server checks both the token ability and current persisted user role, preventing stale admin access after role demotion.

Download API updates metadata and publication state only. Binary document replacement remains in the web CMS.

## Rate Limits

| Tier | Limit |
|---|---|
| Public reads | 60 requests/minute per IP/user |
| Contact submission | 5 requests/minute per IP |
| Token attempts | 5 requests/minute per email/IP |
| Protected API | 120 requests/minute per user |

A limit breach returns HTTP `429`. Use the standard rate-limit response headers to determine retry timing.

## Status Codes

- `200` successful read/update/delete
- `201` created
- `401` invalid or revoked token
- `403` insufficient role/token ability
- `404` missing or unpublished public resource
- `422` invalid request or filter
- `429` rate limit exceeded

## Versioning

`v1` is part of every endpoint URL. Additive fields may be introduced without a version change. Breaking resource or validation changes require a new version prefix.

See [openapi.yaml](./openapi.yaml) for the complete machine-readable contract.
