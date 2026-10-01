# Google Ads: techos (exact match and close variants), obra.com.py

Status 2026-10-01. The site is ready to receive ad traffic; the Ads account side is Anton's (needs his account, billing and IDs). Keyword volumes and CPCs are **not available** (keyword-library MCP not connected): run Keyword Planner before setting budgets.

## 1. What the site already does for ads
- One page per intent, with the typed phrase in the H1, title and first paragraph (relevance and Quality Score): see section 3.
- WhatsApp button above the fold on every page, sticky bar on mobile, 5 different pre-written messages per page. Short form as the alternative.
- Click tracking without cookies (`/t.php`, `/stats.php?token=…`) plus optional GA4 and Google Ads conversions after cookie consent.
- **Attribution to the CRM**: `gclid`, `gbraid`, `wbraid`, `utm_source/medium/campaign/term/content` and the landing path travel with the form (`fields` in the VenderCRM payload and in the notification email). They are read from the ad URL and kept in `sessionStorage`.

## 2. What Anton must set up (in this order)
1. **Account settings → Auto-tagging: ON** (adds `gclid`).
2. **Final URL suffix / tracking template** (campaign level):
   `utm_source=google&utm_medium=cpc&utm_campaign={campaignid}&utm_term={keyword}&utm_content={creative}`
3. **Conversions** (Goals → Conversions → New → Website, "manual setup", one per action):
   - `WhatsApp click` (category Contact; value: leave empty or your own average lead value; count: One)
   - `Formulario enviado` (Submit lead form; count: One)
   - `Llamada` (Phone call lead, optional)
   Each gives a **conversion label**.
4. Put the IDs in `config/local.php` on the server (never in git), keys: `ads_id` (`AW-123456789`), `ads_label_wa`, `ads_label_form`, `ads_label_tel`; or the env vars `OBRA_ADS_ID`, `OBRA_ADS_LABEL_WA`, `OBRA_ADS_LABEL_FORM`, `OBRA_ADS_LABEL_TEL`. With `ads_id` empty nothing loads. Conversions fire only after the visitor accepts the cookie banner, so expect Ads to count fewer conversions than the real number: compare with `/stats.php` (own counts of WhatsApp clicks, which do not depend on consent).
5. Mark `WhatsApp click` and `Formulario enviado` as **Primary** conversions for bidding. Start with Maximize clicks or manual CPC for the first 2-3 weeks, then switch to Maximize conversions once there are ~15-30 conversions.
6. Location: Paraguay, Central + Asunción (presence, not "interest"). Language: Spanish. Schedule: when someone can answer WhatsApp.
7. Policy: no price promises, no "garantizado", no "mejor", no "gratis" in ads (the site avoids them too).

## 3. Campaign structure: one ad group per page, exact match first
Match types: `[exact]` is the base; add `"phrase"` after the first weeks if search terms show good close variants. Do not use broad match without a negative list.

| Ad group | Exact-match keywords (start list) | Final URL |
|---|---|---|
| Techos (general) | [construcción de techos] [techos para casas] [techista] [techistas en asunción] [construir techo] | `/techos/` |
| Techo de chapa | [techo de chapa] [techos de chapa] [colocación de chapas] [colocar techo de chapa] [chapa trapezoidal] [techo de chapa para cochera] | `/techos/chapa/` |
| Termoacústico | [techo termoacústico] [chapa termoacústica] [techos termoacústicos] [techo aislado] [panel sándwich techo] | `/techos/termoacusticos/` |
| Techo de tejas | [techo de tejas] [techos de tejas] [colocación de tejas] [tejas coloniales] [techo de teja] | `/techos/tejas/` |
| Techo de losa | [techo de losa] [losa de viguetas] [losa de hormigón] [hacer losa de techo] | `/techos/losa/` |
| Impermeabilización | [impermeabilización de techos] [impermeabilizar techo] [impermeabilizar losa] [membrana asfáltica techo] | `/techos/impermeabilizar/` |
| Goteras | [goteras en el techo] [arreglar goteras] [techo que gotea] [filtración en el techo] [reparar gotera] | `/techos/goteras/` |
| Cambio y reparación | [cambio de techo] [reparación de techos] [cambiar techo] [arreglo de techos] | `/reformas/techos/` |
| Canaletas | [canaletas para techo] [colocación de canaletas] [bajadas pluviales] | `/techos/canaletas/` |
| Estructura | [estructura de techo] [estructura metálica para techo] [cabriadas] | `/techos/estructuras/` |
| Quincho con techo | [techo de quincho] [techado de quincho] [quincho con techo de tejas] | `/quinchos/techo-madera/` |
| Tinglados y cocheras | [tinglados] [construcción de tinglados] [techo para cochera] [cochera techada] | `/tinglados/` and `/tinglados/cocheras/` |

Keep "machimbre" and "cielorraso de machimbre" out of this account: that group belongs to carpinteria.com.py (`/machimbre/`).

### Negative keywords (campaign level, start list)
gratis, curso, cursos, trabajo, empleo, pdf, como hacer, tutorial, diy, precio m2, usado, venta de chapas, venta de tejas, fábrica de chapas, materiales, ferretería, comprar chapas, tejas precio, planos, dibujo, maqueta, argentina, españa, méxico, chile, uruguay, brasil, bolivia, colombia, perú.
Add from the search-terms report every week for the first month. Keep an eye on "venta de chapas": people who want to **buy** material, not hire a roofer.

### Ad copy (responsive search ads, 3 headlines minimum, no prices or guarantees)
Per ad group use the exact phrase in headline 1, then pick from:
- "Visita y presupuesto por rubro"
- "Pedí tu presupuesto por WhatsApp"
- "Asunción y Gran Asunción"
- "Mandá fotos y medidas"
- "Un responsable de obra"
Descriptions: say what is built and the next step ("Mandanos fotos del techo y te decimos qué conviene. Presupuesto por escrito, por rubro."). Add callout and sitelink assets pointing to `/cotizar/`, `/techos/`, `/guias/techo-losa-chapa/`, `/guias/impermeabilizar-losa/`.

## 4. After go-live: weekly checklist
1. Search-terms report → negatives, and new exact keywords from terms that convert.
2. Compare Ads conversions with `/stats.php` WhatsApp clicks and with the CRM leads (they carry `gclid` and `utm_term`).
3. Pages where people click but nobody writes: check the first screen on a phone, the WhatsApp text, and the questions people actually ask.
4. Never change the H1 of a landing page without changing the ad group's headline 1 (relevance).
