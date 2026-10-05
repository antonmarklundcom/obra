# Service conversion redesign — 2026-10-04

The redesign applies to the homepage, all 13 service hubs and 37 specialty pages. It preserves the current repository's 74 sitemap URLs, route metadata and original service manuscripts. This is a presentation and enquiry-flow change; conversion uplift needs measurement after deployment.

## First three sections

1. **Service-specific hero:** existing H1, short explanation, relevant visual, WhatsApp/form actions, coverage and scope reassurance.
2. **Choose your case:** up to three clear entry points on hubs, or suitable situations on specialties. Roofing separates new roofs, repairs and structure/drainage.
3. **Understand the next step:** what to send, the proposal structure, process and early answers about estimates, visits and guarantees. The proposal is explicitly an example structure, without invented prices.

The complete specialty directory, original descriptions, inclusions, long-form SEO text, process, related links and FAQs continue below. Navigation jumps link directly to the appropriate sections.

The homepage also has a compact hero, three visual entry points (build, improve, roofing) and the enquiry brief immediately afterward. Its original long-form sections remain below. Six primary service cards now use relevant photography and a consistent grid.

## Image revision after owner review

The first schematic roof drawings looked too similar at card size. They have been replaced by **51 distinct generated reference photographs**: one for the homepage and one for each service/specialty. Prompts use Paraguay context (Asunción/Gran Asunción, rendered masonry, ceramic brick, clay tiles, sheet metal, shade, galerías, quinchos and subtropical plants). Roof choices now show a metal roof, a localized leak and a gutter/downpipe connection separately, with larger photographs on desktop.

Final assets use Higgsfield **GPT Image 2.5 Sunburst, medium, 1k**, following the owner's model preference. Each has 480/960/1200px WebP variants and responsive srcsets. They are explicitly labeled as generated references, and the project-evidence component refuses the generated-reference directory. These do not replace the need for real authorized project photos.

Quoted budget: 35 earlier Recraft explorations × 1.25 credits plus 51 final Sunburst images × 0.5 credits = **69.25 estimated credits**, below the owner's 100-credit ceiling. Submission rate-limit rejections created no jobs. Generation provenance is recorded in `docs/media/reference-images.json`; original PNG downloads stay local in ignored `.image-source/`.

## Priority checklist

| Priority | Improvement | Implementation / remaining dependency |
|---|---|---|
| 1 | Reorganize the opening for conversion | Shared three-section structure. **Owner comment:** “the services pages are a bit text heavy … keep the pages/seo and text … first 1–3 sections convert much better per service page.” |
| 2 | Clarify what each service solves | Separate presentation profiles for all 13 services; specialty summaries retained. |
| 3 | Put relevant proof near the decision | Authorized service-specific project component implemented. Actual project evidence still needs owner-supplied photos, scope and permission. |
| 4 | Make the main action obvious | Prominent contextual WhatsApp and enquiry actions in the hero and next-step section. |
| 5 | Show relevant specialty visuals | 51 distinct Paraguay-context generated reference photos for the homepage and all 50 service pages, explicitly labeled. |
| 6 | Preserve service selection into enquiry | Service, specialty and originating page follow the form link and submission. |
| 7 | Reduce friction for repairs and small jobs | Terrain and financing are optional for suitable services; server and client validation agree. |
| 8 | Keep entered values after errors | Short-lived server session, linked field errors and accessible invalid states. |
| 9 | Show truthful submission results | Session-bound receipt confirms actual CRM/email delivery, offers optional WhatsApp and supports retry. |
| 10 | Count delivered leads accurately | Separate attempts, delivery successes and failures; browser events cannot forge server lead records. |
| 11 | Make roofing needs easier to select | Three case choices and grouped specialty cards. |
| 12 | Help compare roof options | Responsive comparison table without fabricated prices. |
| 13 | Surface estimate, visit and guarantee answers | Existing FAQ facts reused near the first decision. |
| 14 | Explain what an estimate contains | Clearly labeled example proposal with scope, stages and exclusions. |
| 15 | Reduce opening copy density | Compact summaries; original long descriptions retained farther down. |
| 16 | Make long pages navigable | Section jump links for specialties, details and questions. |
| 17 | Improve typography and reading width | Responsive heading sizes, readable long-copy widths, spacing and contrast. |
| 18 | Make specialty cards easier to scan | Distinct relevant photo, complete summary and clear destination per card. |
| 19 | Avoid oversized mobile opening sections | Compact case overview before full specialty grid. |
| 20 | Match technical services to their workflow | Supervision and estimating get specific steps; original construction process remains available. |
| 21 | Show real team credentials | Optional verified profile component; name, credentials and portrait await owner information. |
| 22 | Strengthen business identity | Existing legal/NAP configuration remains authoritative. Complete real operator, RUC, address and email in server configuration; no values invented. |
| 23 | Simplify the service directory | Category jump navigation and visible summaries on mobile. |
| 24 | Improve mobile footer usability | Collapsible native groups; links remain available without JavaScript. |
| 25 | Improve keyboard navigation | Mobile menu focus handling and native disclosure controls. |
| 26 | Keep action context through the page | Final contact and sticky form links include service, specialty and origin. |
| 27 | Track the funnel by originating page | Private stats distinguish page loads, WhatsApp clicks, valid submissions, delivered leads and failures. These are not unique users or qualified leads. |
| 28 | Explain functional form storage | Privacy copy documents session behavior and anonymous event measurement. |
| 29 | Protect SEO through automated comparison | Fresh 74-URL before/after baseline, unchanged metadata, no lost word count or inbound links. |
| 30 | Make regression checks repeatable | Route, PHP, form, event, WhatsApp, SEO and desktop/mobile browser checks. |

## Real evidence configuration

Keep secrets and business data in untracked `config/local.php`, using `config/local.example.php`. Set `team` only to verified details. Add projects only when the image is an actual authorized completed work: `service`, `title`, `scope`, `location`, `image` under `/assets/images/`, and `authorized => true`. Retain photo author and permission records privately. Empty or invalid entries do not render. Illustrations and reference photos must never be presented as completed Obra projects.

## Verification and rollout

Review screenshots: [roofing desktop](screenshots/techos-desktop.png), [roofing mobile](screenshots/techos-mobile.png), [tile-roof desktop](screenshots/tejas-desktop.png), [tile-roof mobile](screenshots/tejas-mobile.png).

The [comparison gallery](screenshots/comparison/README.md) preserves actual live before captures and current PR-build after previews, including the homepage. The PNGs above are the earlier design review; the comparison gallery is the current visual revision.

- `node tools/verify.mjs --skip-pw --php=C:/php/php.exe`: PHP syntax, 74 routes, redirects and blocked paths, 17 form cases, event validation, WhatsApp consistency, SEO audit and diff.
- `node tools/pw-check.mjs http://127.0.0.1:8086`: all sitemap pages plus the unconfirmed receipt page at desktop 1366×768 and mobile 390×844; checks console errors, failed resources, broken images, horizontal overflow, mobile sticky behavior and action target sizes.
- `docs/audit/service-redesign-before.json` and `service-redesign-after.json` record the repository baseline and final crawl. Existing SEO manuscripts are unchanged.

Results after the homepage and image revision: verification gate **GREEN** (57 PHP files, 51 distinct image subjects/153 WebP files, 74 sitemap URLs, 14 redirects, 17 form cases, event and WhatsApp checks). Browser check **PASS: 150 runs / 75 URLs × 2 viewports**. Final SEO diff **PASS: 74 → 74 URLs, zero changed descriptions**, no protected metadata changes or word-count/inbound-link losses. Jump-link targets are checked on the homepage, service pages and directory. JavaScript syntax and staged whitespace checks pass.

Before production, verify PHP sessions work on the host, keep CRM/email credentials in server configuration, and exercise one real enquiry without mock delivery. Mock tests verify handling, not the remote CRM or mail provider. After release, re-run the live audit and compare per-service delivered leads with the previous period. Add real project/team evidence when available and assess lead quality in the CRM. No measured conversion or production Core Web Vitals improvement is claimed by this PR.
