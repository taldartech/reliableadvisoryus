# Reliable Advisory Financial Services LLC (Static Site)

This repository contains the source for the Reliable Advisory marketing site: a mostly-static, multi-page website (HTML + Bootstrap + a custom theme stylesheet) for a U.S.-based financial planning and wealth management firm.

Pages cover the firm’s overview, services, leadership/values, planning tools (embedded third-party calculators), and contact information. Search/SEO metadata is included on each page via canonical links, Open Graph/Twitter tags, and `schema.org` JSON-LD structured data.

## What’s in this repo

### Main pages
- `[index.html](index.html)` - Home page (hero, core message, and services preview).
- `[services.html](services.html)` - Services overview.
- `[about.html](about.html)` - About/values/approach.
- `[tools.html](tools.html)` - Embedded planning calculators (iframes) and “open full calculator” links.
- `[contact.html](contact.html)` - Phone/email/hours and a contact form that submits via `mailto:`.
- `[privacy.html](privacy.html)` - Privacy policy placeholder text.
- `[terms.html](terms.html)` - Terms of service placeholder text.

### SEO helpers
- `[robots.txt](robots.txt)` - Robots rules (includes a domain placeholder note).
- `[sitemap.xml](sitemap.xml)` - Sitemap (includes a domain placeholder note).

### Frontend assets
- `css/brand.css` - Custom visual theme and component styling (brand colors, layout, typography, forms, tool iframes, etc.).
- `js/nav.js` - Navigation active-state logic.
- `assets/` - Static assets (currently includes `assets/logo-reliable-advisory.svg`).

## How the site works (key behavior)

### Navigation active state
`js/nav.js` reads `data-page` from the `<body>` and applies an `.active` class to the nav link whose `data-nav` matches that page.

### Contact form submission
`contact.html` includes a contact form that ultimately submits via `mailto:info@reliableadvisory.us`.

- With JavaScript enabled: the inline script assembles a subject/body from the form fields and then navigates to a `mailto:` URL.
- Without JavaScript: the form has a `mailto:` `action` and the browser will typically open an email draft using the form fields (behavior varies by browser).

### Tools page embeds
`tools.html` embeds third-party calculators using `<iframe>` elements and also provides “Open full calculator” links. The embedded calculator sources are from `calculator.net`, and the page also links to `SSA.gov My Social Security`.

If an embedded panel appears blank due to browser/site restrictions, use the “Open full calculator” link for each tool.

## SEO & structured data

Each page includes:
- Canonical URLs and Open Graph/Twitter meta tags.
- `schema.org` JSON-LD (via an inline `<script type="application/ld+json">` block) for the page/organization.
- `index.html` and other pages share a consistent layout and includes a footer disclaimer relevant to investment advisory services.

## Legal / compliance notes

This site includes a footer disclaimer: “Investment advisory services … Securities offered through licensed representatives”.

`privacy.html` and `terms.html` are explicitly written as placeholders and should be replaced/reviewed by qualified counsel to reflect actual data practices, regulatory requirements, and governing conditions.

## Before launch checklist (content-only)

1. Update the production domain:
   - Replace `https://www.reliableadvisory.us` with your production domain in `[robots.txt](robots.txt)` and `[sitemap.xml](sitemap.xml)`.
   - Confirm canonical/OG/Twitter URLs in each HTML page also match the production domain.
2. Finalize legal text:
   - Replace the placeholder contents in `[privacy.html](privacy.html)` and `[terms.html](terms.html)` with finalized, counsel-reviewed versions.
3. Validate third-party embeds:
   - Confirm `calculator.net` iframes load correctly in your target browsers and that the “Open full calculator” links work as intended.
