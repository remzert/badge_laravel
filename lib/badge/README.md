# Système de badge

- Ajouter le comportement badgeable au model user 'use Badgeable;'
- Créer une migration qui étend de 'BadgeMigration'
- Rajouter le subscriber dans l''EventServiceProvider'

***php
protected $subscribe = [
        BadgeSubscriber::class
    ]

***

