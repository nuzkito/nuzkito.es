# nuzkito.es

Source of my web [nuzkito.es](https://nuzkito.es). The site is generated with [Pluma](https://github.com/nuzkito/pluma).

## Local development

Start the editor and the site preview:

```bash
docker compose up serve
```

- Editor: http://127.0.0.1:8010
- Site preview: http://127.0.0.1:8011

The `serve` image installs Pluma globally with Composer when it is built. The `PLUMA_VERSION` variable in `.env` sets the version.

## Generate the site

Generate the full static site in `site/`:

```bash
docker compose run --rm serve pluma generate
```

## Update Pluma

Rebuild the image without the cache, so that Composer installs the latest version:

```bash
docker compose build --no-cache serve
```

The Pluma version is in the `PLUMA_VERSION` variable of the `.env` file. Docker Compose reads this file for the `serve` image, and the deploy workflow reads it to install Pluma. To change the version, edit `.env` and rebuild the image.

## Deploy

The [Deploy web](.github/workflows/deploy.yml) workflow generates the site and publishes it to GitHub Pages.

The workflow runs on each push to `main`. You can also run it by hand from the Actions tab (`workflow_dispatch`).
