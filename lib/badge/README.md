## Système de badge

- Composer.json : ajouter dans le "autoload" psr-4 `Badge\\` : `lib/badge/src/`
- Ajouter le comportement badgeable au model user `use Badgeable`
- Créer une migration qui extends de BadgeMigration
- Rajouter le subscriber dans l'eventServiceProvider
