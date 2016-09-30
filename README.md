Le premier mardi du mois Au mutualāb
=====

Le premier mardi du mois, une séance cinéma est organisée entre les coworkeurs/euses du [Mutualāb](http://mutualab.org).

Les personnes interressées par la séance proposent des films, puis votent pour les films qu'elles veulent voir.
Le film avec le plus grand nombre de vote est sélectionné.

Plutôt que de faire les propositions ET les votes par mail à un coworkeur dédié, cette application propose de recenser 
les films et les avis de tout le monde sans besoin d'une personne dédiée.

Des remarques ?
=====
Si vous avez une remaque/evolution à proposer, vous pouvez ouvrir une issue

Pour les devs qui souhaitent participer
=====
### Quelques infos
- Projet en Symfony 3
- Docker pour le développement (donc nécéssite que docker et docker-compose soient installés)
- Encore en developpement :wink:
- Pensez à faire une **pull request plutot que pousser directement sur master** pour que je puise review
- Si vous modifier le schema de base de données, pensez à faire un `make migration-diff`, puis si tout est ok `make migration-migrate`

### Installer le projet
`make` (prendra un moment lors du premier lancement, puis très rapide pour les suivants)

#### Misc...
Voir le `Makefile` pour quelques commandes utiles
