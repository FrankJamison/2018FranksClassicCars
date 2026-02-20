# Frank's Classic Cars

A classic server-rendered PHP application that demonstrates end-to-end web development: database-backed catalog browsing, an employee-only area, RSS feed generation, and server-side charting.

This repo is written to be readable in a code review and to showcase practical, “real app” concerns: configuration, sessions, data access, pagination, and environment-aware deployment.

Live preview: https://classiccars.fcjamison.com/

## Quick Tour (for employers / recruiters)

**What this demonstrates**

- Server-rendered PHP pages with shared layout includes
- MySQL-backed reads/writes using `mysqli`
- Session-based access control for an employee-only section
- RSS generation with optional XSL styling
- Dynamic chart image generation using PHP GD
- Environment-aware configuration (local override file + env vars)

**Notable design & development elements**

- Consistent page templating via shared includes (head/footer/logo/session/config)
- Reusable helper functions (validation utilities, pagination, chart builder)
- Separation between public site and authenticated member workflows
- Config precedence that supports local dev and deployment without committing secrets

## Key Pages

- Public home: [index.php](index.php)
- Product details: [product.php](product.php)
- Create employee account: [createaccount.php](createaccount.php)
- Employee login: [login.php](login.php)
- RSS feed generator: [autorss.php](autorss.php)
  - Uses a `pl` query parameter for product line selection (examples: `classic`, `vintage`, `motorcycle`).
- Member area home: [members/index.php](members/index.php)
- Member tools:
  - Add customer: [members/addcustomer.php](members/addcustomer.php)
  - Credit limits + chart: [members/creditlimits.php](members/creditlimits.php)
  - Inventory listing + pagination: [members/inventory.php](members/inventory.php)
  - Logout: [members/logout.php](members/logout.php)

## Tech Stack

- PHP (procedural, server-rendered)
- MySQL
- Apache (XAMPP-friendly)
- Front-end: HTML/CSS (see [css/style.css](css/style.css))
- RSS + XSL: [autorss.php](autorss.php) + [rssfeed.xsl](rssfeed.xsl)
- Charts: PHP GD helpers in [includes/functions.inc.php](includes/functions.inc.php)

## Architecture Notes (developer-focused)

This codebase is intentionally “classic PHP” in structure:

- `includes/` holds shared layout and app glue:
  - configuration: [includes/variables.inc.php](includes/variables.inc.php)
  - sessions/authorization gate for member pages: [includes/session.inc.php](includes/session.inc.php)
  - reusable helpers (validation, pagination, chart generation): [includes/functions.inc.php](includes/functions.inc.php)

## Local Setup

### Requirements

- PHP 5.4+ (newer versions generally work; this codebase uses older-style patterns)
- MySQL 5.6+
- PHP extensions:
  - `mysqli`
  - `gd` (needed for server-side chart image generation)

### Database

1. Create a MySQL database (the dump defaults to `uc_davis_web512`).
2. Import the schema/data dump: [FranksClassicCars.sql](FranksClassicCars.sql)
3. Ensure your MySQL user has permissions for that schema.

### Configuration

Database connection settings live in [includes/variables.inc.php](includes/variables.inc.php).

Local/production overrides are supported via `includes/variables.local.inc.php` and `includes/variables.prod.inc.php`.
These files are meant to be untracked (see [.gitignore](.gitignore)) so credentials do not end up in source control.

Precedence (lowest → highest):

1. Defaults in `includes/variables.inc.php`
2. Optional `includes/variables.local.inc.php` (recommended for local overrides)
3. Optional `includes/variables.prod.inc.php` (loaded only when explicitly enabled)
4. Environment variables: `FCC_DB_HOST`, `FCC_DB_USER`, `FCC_DB_PASS`, `FCC_DB_NAME`

### Run locally (quick smoke test)

From the project root:

```bash
php -S 127.0.0.1:8000
```

Then open `http://127.0.0.1:8000/`.

## Running under Apache (XAMPP/Laragon/WAMP)

If you prefer Apache instead of `php -S`, point an Apache VirtualHost (or DocumentRoot) at this repo folder.

Minimal checklist:

1. Map your Apache DocumentRoot to the repo root (the folder containing [index.php](index.php)).
2. Ensure the target directory is readable by Apache and has `AllowOverride All` if you rely on `.htaccess` rules (this app does not require `.htaccess` by default).
3. Browse to your configured site URL.

If you use a custom local hostname (for example `franksclassiccars.test`), you may also need a `hosts` file entry on your machine.

## RSS Feeds

The RSS generator is implemented in [autorss.php](autorss.php). It selects items by product line using the `pl` query parameter. The output can be styled/transformed with [rssfeed.xsl](rssfeed.xsl).

## Charts / Credit Limits

The credit-limit chart is generated server-side using PHP GD (see the graph helpers in [includes/functions.inc.php](includes/functions.inc.php)). If chart images don’t render, verify the `gd` extension is enabled in your PHP installation.

## Engineering Notes / Next Improvements

This is a portfolio/learning codebase; if hardening it for production, the next steps would be:

- Convert dynamic SQL to prepared statements throughout
- Add CSRF protection on all state-changing forms
- Improve error handling (currently suppressed in [includes/functions.inc.php](includes/functions.inc.php))
- Add centralized input sanitization/encoding helpers

## Troubleshooting

- MySQL “Access denied”:
  - Confirm your local MySQL username/password match your environment, or override them in `includes/variables.local.inc.php`.
  - Confirm production mode is not enabled locally (`FCC_USE_PROD_CONFIG=1` / `FCC_ENV=production`).

## VS Code

This repo includes a VS Code task:

- **Open in Browser**: opens the site locally at http://franksclassiccars.localhost/

If you want the task to open the live preview instead, edit [.vscode/tasks.json](.vscode/tasks.json) and replace the URL with `https://classiccars.fcjamison.com/`.
