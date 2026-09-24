# Programs catalog: full listing + filters

**Date:** 2026-09-24  
**Page:** `/kemerovo/programs` (and other city `/programs` hubs)  
**Status:** Approved in brainstorming; awaiting user review of this spec before implementation plan

## Problem

The programs hub shows a curated ACF `catalog` block (~18 cards), not the full corpus of published CPT `service` + `program` posts (~125). Users cannot browse or filter the real catalog. The service «Онлайн-консультация психиатра» (`psy-online`) uses a generic `clinic-consult.jpg` cover that does not depict an online consultation.

## Goals

1. Show **all** published services and programs on the programs catalog section.
2. Provide filters: **direction** + **format** + **search by title**.
3. Paginate **24** items per page with shareable URL query params.
4. Keep the existing **zapoy program_cards** block above the catalog unchanged.
5. Generate and attach a more fitting cover image for online psychiatry consultation.

## Non-goals

- Changing the zapoy 1–7 day cards block content or layout.
- Rewriting single-service templates or FAQ copy.
- Client-only (JS-only) catalog that dumps all 125 items into the first paint.
- Manually maintaining 125 ACF repeater cards.

## Approach (chosen)

**Live CPT catalog + `service_cat` taxonomy**, server-side query, layout A for filters.

## Data model

### Source of cards

- Query `post_type => ['service', 'program']`, `post_status => publish`.
- Respect existing per-city hide overrides (`city_overrides` / `ov_hide`) if already used for singles — do not show hidden posts for the current city.
- Card fields from post + ACF: title, short text (lead/excerpt), price string, badge if available, permalink via `alba_service_permalink` / city URL helpers, icon/cover via `alba_media_url`.

### Taxonomy `service_cat` (existing, currently empty)

Hierarchical. Two logical groups assigned as terms on the same taxonomy:

**Direction (parent or flat terms):**

- Алкоголизм / запой  
- Наркомания  
- Психиатрия  
- Кодирование  
- Детокс / стационар  
- Реабилитация  
- Психотерапия / семья  
- Онлайн  
- Срочная помощь / выезд  

**Format:**

- Стационар  
- На дому  
- Амбулаторно  
- Онлайн  

Each post gets ≥1 direction and ≥1 format where applicable. One-time seed maps posts by slug prefix / title heuristics; editable in WP admin afterward.

**Term slugs (stable for URLs):** e.g. `alcohol`, `drugs`, `psychiatry`, `coding`, `detox`, `rehab`, `therapy`, `online-dir`, `urgent` for directions; `stationary`, `home`, `ambulatory`, `online` for formats. (Exact slug list fixed during implementation; direction «Онлайн» vs format «Онлайн» must not collide — use distinct slugs.)

## UI / UX

### Page structure (top → bottom)

1. Existing hub lead / hero (unchanged).
2. Existing **program_cards** zapoy block (unchanged).
3. **Full catalog** section with filters + grid + pagination.
4. Existing ward_fund / faq / cta (unchanged).

### Filter panel — layout A

- Full-width **search** input (title).
- Row of **direction** chips (multi-select).
- Row of **format** chips (multi-select).
- Result count («Найдено: N») + **Сбросить**.
- Grid of existing `cat-card` styling.
- Pagination controls (24 per page).

### URL contract

GET params on the programs page, for example:

- `q` — search string  
- `direction[]` — one or more term slugs (PHP array query args)  
- `format[]` — same  
- `paged` — page number  

Filters must work **without JavaScript** (HTML form GET). Optional progressive enhancement for chip UX only.

## Technical design

### Theme files (expected touch points)

| Area | Path / responsibility |
|------|------------------------|
| Catalog block | `template-parts/blocks/catalog.php` — switch to CPT-driven render when flag/mode set, or new block variant |
| Block registry | `inc/page-blocks.php` |
| Query + filters helper | New small include e.g. `inc/catalog-query.php` |
| Taxonomy seed | One-time seeder (admin/CLI or theme install hook guarded to run once) |
| Styles | Theme CSS for filter bar chips / pagination, matching existing Alba look |
| Cover image | Generated asset under site `images/` + update ACF `cover_url` for `psy-online` |

### Query behavior

- `posts_per_page` = 24  
- `tax_query` AND between direction group and format group; OR within multi-selected terms of the same group  
- Search: WordPress `s` limited to titles if a simple title filter is available; otherwise default search is acceptable for v1  
- Order: title ASC (or menu_order if set) — consistent, predictable browsing  

### ACF catalog repeater

- Stop relying on the 18 curated items for the programs hub catalog section.  
- Prefer: block setting «Источник: CPT» or replace items loop with CPT query when page is the programs hub.  
- Legacy ACF items may remain in DB unused for this page; no need to delete in v1.

### Online consultation image

- Generate a realistic photo-style image: doctor giving a patient an **online** consultation (video call / screen context), tonally compatible with clinic photography.  
- Save as e.g. `images/clinic-consult-online.jpg` (or WP media).  
- Set `cover_url` (and catalog icon if the grid uses cover) for service slug `psy-online` / «Онлайн-консультация психиатра».  
- Do not replace the generic `clinic-consult.jpg` globally for unrelated services.

## Error / empty states

- No matches: message «Ничего не найдено» + reset link.  
- Missing price/cover: graceful fallbacks already used on singles (`clinic-room.jpg` etc.).

## Testing checklist

- `/kemerovo/programs` shows zapoy block + ~125-aware pagination (page 1 has ≤24 cards; total pages match count).  
- Filtering by direction, format, both, and search updates results and URL.  
- Shared filtered URL reproduces the same results.  
- Works with JS disabled.  
- Other cities’ `/programs` hubs behave the same.  
- `psy-online` single and any catalog card show the new online-consult image.  
- Hidden-for-city services stay hidden if overrides exist.

## Implementation notes for planning

1. Seed `service_cat` terms + assign all posts.  
2. Implement catalog query + filter UI (layout A) + pagination.  
3. Wire programs page catalog block to CPT source.  
4. Generate and attach online consultation image.  
5. Verify on live programs URL and spot-check filters.
