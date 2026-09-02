# Google Search Embed

WordPress.org site search is powered by Google Programmable Search Engine (PSE).
There is no WordPress-side search index and no API key in this repository — this
block renders an empty container that Google's `cse.js` fills in client-side.

## How it works

1. `/search/do-search.php` (in the meta repo, not here) normalises the query,
   infers a refinement from the referrer, and redirects to
   `/search/<term>/?in=<refinement>`.
2. `templates/page-search.html` → `patterns/search.php` places this block.
3. `index.php` emits `<div id="gsce-search" data-config="…" data-terms="…"></div>`.
4. `view.js` injects `cse.js` for the `cx` below, then calls `render()` and
   `.execute( terms )`.

Results are fetched entirely by Google; the term reaches it via `data-terms`.
`view.js` also POSTs the term to `https://api.wordpress.org/search/1.0/` to
record it, which does not affect results.

## Configuration

Which sites are indexed, the refinement tabs, result styling and the ad-free API
key are all configured in Google's control panel, not here. The only engine
setting in this repo is the engine ID in `view.js`:

```js
const cx = '012566942813864066925:bnbfebp99hs';
```

WordPress.org uses the paid, ad-free element, billed per query and backed by
Google Cloud project `my-project-1625033745762`. Its API key lives in the
control panel's **Ads** section — never in this repo.

- Billing:
  <https://console.cloud.google.com/billing/linkedaccount?project=my-project-1625033745762>
- Quota:
  <https://console.cloud.google.com/apis/api/programmablesearchelement.googleapis.com/quotas?project=my-project-1625033745762>

## Requesting access

The billing and quota pages are not open to all contributors. Members of the
meta team can request access at <https://make.wordpress.org/systems/>.
