# Programs Catalog Filters Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Show all ~125 CPT services/programs on `/programs` with direction + format + search filters, 24/page pagination, and a new cover for online psychiatry consultation.

**Architecture:** CPT-driven `catalog` block (like doctors `from_cpt`), `service_cat` taxonomy seeded once, server-side `WP_Query` from GET params, layout A filter UI.

**Tech Stack:** WordPress, ACF, theme PHP/CSS, Cursor GenerateImage for cover asset.

## Global Constraints

- Keep zapoy `program_cards` block unchanged.
- Filters work without JS (GET form).
- URL: `q`, `direction[]`, `format[]`, `paged`.
- 24 posts per page.
- Do not globally replace `clinic-consult.jpg`.

---

### Task 1: Catalog query + taxonomy seed

**Files:**
- Create: `wp-content/themes/alba/inc/catalog-query.php`
- Modify: `wp-content/themes/alba/functions.php` (require)

- [ ] Implement term defs, seed, query, hide-for-city helper
- [ ] Run seed via PHP once; verify 125 assigned
- [ ] Skip commit unless user asks

### Task 2: Catalog block UI + ACF from_cpt

**Files:**
- Modify: `template-parts/blocks/catalog.php`
- Modify: `inc/page-blocks.php` (from_cpt field)
- Modify: page 8 ACF to enable from_cpt
- Modify: `css/style.css` (filter bar + pagination)

- [ ] Render filters layout A + grid + pagination
- [ ] Verify `/kemerovo/programs` shows 24 cards and filters

### Task 3: Online consultation image

**Files:**
- Create: `images/clinic-consult-online.jpg` (generated)
- Update: service `psy-online` cover_url

- [ ] Generate image of doctor + patient on video call
- [ ] Attach to service 109
