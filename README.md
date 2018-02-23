Symfony app for the darts team football predictions.

## Deploying to Dokku

- Create a Dokku app and mariadb, and link them
- Set up dokku git remote
- `dokku config:set APP_ENV=prod`
- `dokku config:set NPM_CONFIG_PRODUCTION=false` (installs dev dependencies in production, allowing access to Webpack, but keeps NPM in prod mode when generating assets)