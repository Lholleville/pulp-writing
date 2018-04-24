## Système de badge

- Composer.json : ajouter dans le "autoload" psr-4 `Badge\\` : `lib/badge/src/`
- Ajouter le comportement badgeable au model user `use Badgeable`
- Créer une migration qui extends de BadgeMigration
- Rajouter le subscriber dans l'eventServiceProvider

Dans les tables :

name : correspond au nom du bagde.

action : correspond à l'action du bagde (fonction pratique pour le site)

avatar : visuel du badge

action_count : nombre de fois qu'il faut pour débloquer le badge. Par exemple,
pour un badge récompensant 100 messages postés sur le site, il faut compter le nombre de messages que l'utilisateur a publié puis le comparer avec le nombre action_count


Coder les badges dans le fichier `BadgeSubscriber.php`

