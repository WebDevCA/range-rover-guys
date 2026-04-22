# SEO Audit Handoff — rangeroverguys.com

> Reconciled against the working tree on branch `claude/seo-audit-handoff-docs-33pcy` at HEAD `76e3e92` on 2026-04-22. A new Claude session can resume from the Outstanding list below without re-discovery.

## Project at a glance
- **Domain**: https://rangeroverguys.com
- **Business**: Range Rover Guys — independent Range Rover / Land Rover repair shop, est. 1985
- **Address**: 7662 Slater Avenue, Suite J, Huntington Beach, CA 92647
- **Phone**: (714) 465-5488  (tel: `+17144655488`)
- **Geo**: 33.719057, -117.991018
- **Hours**: Monday–Saturday, 8:00 AM – 5:00 PM *(confirm with owner)*
- **Service area**: Huntington Beach, Irvine, Newport Beach, Seal Beach, Los Alamitos
- **Repo**: https://github.com/WebDevCA/range-rover-guys
- **Stack**: PHP (no framework), Apache shared hosting, `.htaccess`, jQuery frontend
- **Canonical URL**: `https://rangeroverguys.com/` — bare domain, HTTPS. `.htaccess` on the server 301s both `http://` and `www.` variants.

## Current state — PageSpeed Insights mobile, 2026-04-22
| Metric | Score |
|---|---|
| Performance | **93** 🟢 |
| Accessibility | **76** 🟡 |
| Best Practices | **69** 🟡 |
| **SEO** | **100** 🟢 |
| First Contentful Paint | 1.7s 🟢 |
| Largest Contentful Paint | 3.0s 🟡 (target <2.5s) |

**Key implication:** PSI runs from Google infrastructure and successfully analyzed the page. **Googlebot reaches the site fine.** Any 403 that assistant-class WebFetches see is the host's WAF blocking datacenter IPs wholesale — it does NOT affect search rankings. Don't debug the 403.

---

## ✅ Completed (verified in working tree)

These were already applied before the initial upload commit (`76e3e92`). Cited by file:line so the next session can spot-check.

- **`robots.txt`** — HTTPS, bare domain, single `sitemap.xml` reference (matches the canonical target exactly).
- **`sitemap.xml:1`** — XML declaration present; all URLs on HTTPS; `lastmod` = `2026-04-22`; homepage `priority` = `1.0`.
- **`header.php:15`** — viewport meta tag.
- **`header.php:17-27`** — Open Graph (`og:title`, `og:description`, `og:image`, `og:url`, `og:type`) and `twitter:card` are set. OG values use `htmlspecialchars`.
- **`header.php:37`** — `rel="canonical"` points at `https://rangeroverguys.com/`.
- **`header.php:39-66`** — `AutoRepair` JSON-LD skeleton exists (values need correction, see Outstanding #2).
- **`header.php`** — no `<meta name="keywords">` present (doc's original #12 already done).
- **`index.php:5`** — meta description already reads "Expert Range Rover repair & service in Huntington Beach since 1985. All models, dealer-level diagnostics, shuttle to Irvine, Newport Beach & Seal Beach." (160 chars, no Honda reference).
- **`index.php:32`** — "Land Rovers began in …  1948" (year corrected; "Wales" still wrong — see Outstanding #9).
- **`index.php:13`** — "luxury off-road SUVs" (doc's `wih` typo rewrite applied).
- **`footer.php:26-28`** — jQuery 3.7.1 from `code.jquery.com` with SRI `sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=` (CVE-vulnerable 1.4.2 gone).
- **`footer.php`** — no IE7.js conditional block, no googlecode references.
- **`footer.php:9`** — `<strong>Range Rover Guys</strong>` closes correctly (the broken-unclosed-`<strong>` bug is gone).
- **`footer.php:22-24`** — semantic `<footer>` element with `© 2026 Range Rover Guys`.

---

## 🔴 Outstanding — do first

### 1. Delete empty `sitemap.txt`
File exists in the repo root (0 bytes) and serves no purpose. `robots.txt` no longer references it. Remove from server and from repo.

### 2. Fix JSON-LD values in `header.php:39-66`
Current values diverge from the project NAP/geo/hours:
- `streetAddress: "7662 Slater Ave."` → needs `"7662 Slater Avenue, Suite J"`
- `latitude: "33.708116"` / `longitude: "-117.994718"` → needs `33.719057` / `-117.991018`
- `dayOfWeek` is Mon–Fri only → needs Saturday added
- `opens: "07:30"` / `closes: "5:30"` → needs `"08:00"` / `"17:00"` (note: `"5:30"` is not a valid ISO 8601 time; must be `HH:MM`)

Replace the `<script type="application/ld+json">` block with:
```json
{
  "@context": "https://schema.org",
  "@type": "AutoRepair",
  "name": "Range Rover Guys",
  "image": "https://rangeroverguys.com/images/shop.jpg",
  "telephone": "+1-714-465-5488",
  "priceRange": "$$",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "7662 Slater Avenue, Suite J",
    "addressLocality": "Huntington Beach",
    "addressRegion": "CA",
    "postalCode": "92647",
    "addressCountry": "US"
  },
  "geo": { "@type": "GeoCoordinates", "latitude": "33.719057", "longitude": "-117.991018" },
  "url": "https://rangeroverguys.com",
  "openingHoursSpecification": [{
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
    "opens": "08:00",
    "closes": "17:00"
  }],
  "areaServed": ["Huntington Beach","Irvine","Newport Beach","Seal Beach","Los Alamitos"],
  "makesOffer": ["Range Rover repair","Range Rover electrical diagnosis","Range Rover maintenance"]
}
```

### 3. Delete dead YUI stylesheets in `header.php:29-31`
Yahoo shut down the YUI CDN in 2019 and the block is `http://` (mixed content if uncommented). Currently commented out with `<!--link .../-->`. Delete the whole block rather than leaving dead markup:
```html
<!--link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.1.1/build/cssreset/reset-min.css" media="screen" />

<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.1.1/build/cssbase/base-min.css" media="screen" /-->
```

### 4. Replace Google Maps iframe in `footer.php:4`
Current iframe uses `http://maps.google.com/maps?...` — mixed content on HTTPS, no lazy loading, no title, no responsive wrapper. Regenerate via Google Maps → Share → Embed a map, then add `loading="lazy"`, `title="Map to Range Rover Guys in Huntington Beach"`, `referrerpolicy="no-referrer-when-downgrade"`. Wrap in a responsive container (CSS `aspect-ratio: 638/400`).

### 5. Finish address rewrite in `footer.php:6-14`
Still has a `mapquest.com` address link, a "Website" row, no "Hours" row, and the surrounding heading is `<h3>` when it should be `<h2>`. Replace the block with:
```html
<h2>Contact Us Today</h2>

<address>
  <strong>Range Rover Guys</strong><br />
  <strong>Address:</strong>
    <a href="https://maps.google.com/?q=7662+Slater+Ave+Suite+J+Huntington+Beach+CA+92647">
      7662 Slater Avenue, Suite J<br />Huntington Beach, CA 92647
    </a><br />
  <strong>Phone:</strong>
    <a href="tel:+17144655488">(714) 465-5488</a><br />
  <strong>Hours:</strong> Monday–Saturday, 8:00 AM – 5:00 PM
</address>
```

### 6. Wire up GA4
`footer.php:32-38` already contains the gtag.js block, but it is HTML-commented and still has the placeholder `G-XXXXXXXXXX`. Create a GA4 property, substitute the real measurement ID, and uncomment:
```html
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>
```
The Classic Analytics `_gaq` block is already gone. Note: UA property `UA-17596756-1` stopped collecting on July 1, 2023, so ~3 years of analytics data are already missing.

### 7. Escape echoed PHP output
`header.php:7` (`<title><?php echo $page_title; ?></title>`) and `header.php:9` (`<meta name="description" content="<?php echo $meta_description; ?>" />`) are unescaped. The Open Graph tags on lines 17/19 use `htmlspecialchars` — apply the same treatment for consistency and XSS safety:
```php
<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>
```

### 8. Resolve electrical-diagnosis inconsistency
- Nav in `header.php:80-85` exposes Home / Air Conditioning / Brake Service / Site Map. `electrical-diagnosis.php` exists on disk but is not linked.
- `index.php:21` has a prominent `<h2>Range Rover Electrical Huntington Beach</h2>` with three paragraphs of body copy — a page promising service pages that the nav hides.

Pick one: (a) ship `electrical-diagnosis.php` and re-enable the nav entry + add it to `sitemap.xml`, or (b) remove the H2 and body copy from `index.php:21-27`. Option (a) is the SEO-positive choice.

### 9. Finish "Fun Facts" correction in `index.php:32`
Currently reads "Land Rovers began in Wales in 1948." The year is right, but Land Rover was designed and built in **Solihull, England**, not Wales (and debuted at the Amsterdam Motor Show in April 1948). Replace Wales with "Solihull, England".

### 10. Fix orphan paragraph in `index.php:15`
Paragraph begins with a leading comma: `<p>, where we pride ourselves on providing top-quality service…`. An opening clause was clearly deleted. Either merge this paragraph with the one above it (whose closing sentence it was probably attached to) or rewrite so it stands alone.

### 11. Fix broken closing tag in `index.php:45`
The Range Rover History section closes with `</p-->` — a `</p>` tag that has been wedged into a mangled HTML-comment terminator. Browsers tolerate it but validators and source-of-truth tools won't. Replace with `</p>`.

### 12. Verify `.htaccess` on server
The handoff's earlier draft stated `.htaccess` was created with HTTPS redirect, www→bare 301, security headers, gzip, caching, sensitive-file denies, and no UA filtering. **There is no `.htaccess` tracked in this repo.** Either the file lives only on the production host (shared hosting deployments often exclude it from VCS) or it was never created. Confirm via SSH/FTP to the server. If missing, create and deploy; if present, copy it into the repo so future work is auditable.

---

## 🟡 Content work — biggest ranking lift after the fixes above

### 13. Thin content — restore and expand
The May 27 2025 in-code comment says content was removed "in an attempt to help SEO." That's backwards — thin pages lose to competitors running 800–1,500 word service pages.

Add H2 sections (100–150 words each, keyword in first sentence):
- Range Rover Air Suspension Repair (huge pain point, high search volume)
- Range Rover Transmission & Drivetrain Service
- Range Rover Pre-Purchase Inspections Huntington Beach
- Range Rover Oil Changes & Scheduled Maintenance
- Range Rover Brake Service

### 14. Add FAQ section + `FAQPage` schema
High-intent questions to answer in 40–80 words each:
- "How much does Range Rover air suspension repair cost?"
- "Do you service the Range Rover Sport / Velar / Evoque / Defender?"
- "Can you do warranty-compliant maintenance outside the dealer?"
- "Do you offer loaner vehicles or shuttle service?"
- "Do you work on Land Rover Discovery and LR4?"

### 15. Testimonials with `Review` + `AggregateRating` schema
Pull 3–6 Google/Yelp reviews onto the page. Mark up each with `Review`, then site-wide `AggregateRating`.

### 16. Images — currently ZERO on homepage
- Hero image (shop or serviced Range Rover): `alt="Range Rover being serviced at Range Rover Guys in Huntington Beach"`, explicit `width`/`height`, `fetchpriority="high"` — **this alone should drop LCP under 2.5s**
- Before/after, bay shots: descriptive filenames (`range-rover-air-suspension-repair-huntington-beach.jpg`, not `IMG_4012.jpg`)
- All non-hero images: `loading="lazy"`

### 17. On-page NAP must match Google Business Profile exactly
Include visible NAP in footer + once in-body. Must match GBP character-for-character (same street abbreviation, same suite format).

---

## 🟢 Nice-to-haves
- Favicon, Apple touch icon, `theme-color`
- Populate empty `<header></header>` with logo + branded home link
- Add `aria-label="Primary"` to `<nav>`
- Copyright line in footer: `© 2010–2026 Range Rover Guys` (currently just `© 2026`)
- GBP + social links in footer, mirrored in JSON-LD `sameAs`
- HSTS header in `.htaccess` (enable after 1+ week of stable HTTPS)
- Clean URLs via mod_rewrite: `/air-suspension-repair/` not `?page=services&id=5`
- Per-service landing pages linked from homepage H2s
- Investigate `pages.php` (114 KB, unreferenced by nav or sitemap) — decide whether it's dead code to delete or content to resurface.

---

## `.gitignore`
Committed alongside this document at `/.gitignore`.

---

## How to use this brief in the new session
1. Read `docs/seo-audit-handoff.md` (this file).
2. Ask Claude to read `header.php`, `footer.php`, `index.php`, `robots.txt`, `sitemap.xml` from the repo to verify the ✅ list still matches the working tree.
3. Confirm commit workflow (direct to `main` vs. PR-based — your preference).
4. Work the Outstanding list in priority order.
