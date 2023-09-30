# SLURP v2.0 – Le moteur de JdR universel

Ce projet contient le code source de mon application permettant de faire des parties de SLURP en ligne. SLURP est un moteur de règles universelles de JdR sur table.  

Il s’agit d’un site web contenant toutes les règles sous forme de MPA, plus :
- Une SPA permettant la gestion de votre personnage
- Une SPA incluant un module de tchat en websocket et différents widgets permettant de gérer les règles en cours de partie (le serveur de tchat, en NodeJS, est extrêmement simple. Il n’est pas inclus dans le code étant donné qu’il doit être déployé sur un serveur différent de celui utilisé pour le site, qui est en _shared hosting_).
- Une partie administration ouvert aux Meneurs de jeu permettant de gérer les personnages et les groupes dont il a la responsabilité.
- Une partie administration qui m’est exclusivement réservée. Elle permet de gérer d’autres données du site (compétences, traits, pouvoirs, créatures, changement de mot de passe oublié...)

Ce repo me permet de montrer à mes employeurs et clients mes compétences techniques.

### Structure et architecture
Ce site a été volontairement développé sans aucun framework ni aucune bibliothèque.
- Back-end : PHP 8 et MySQL 8. Tout le code est contenu dans des classes, ordonnées à la manière de Symfony. PHP est chargé de tout le processing calculatoire assez lourd.
- Front-end : JS (dont le rôle est restreint à l’échange client-serveur, à la mise à jour du HTML, aux lancer de dés et au client _chat_ – il ne gère aucun traitement des règles).
- CSS : écrit au départ de manière un peu maladroite, je suis en train de le reprendre en SCSS. Pour l’instant, c’est un peu le bordel dans le dossier sass.

Étant donné qu’il s’agit du premier site que j’ai réalisé, le code est passé par plusieurs refactorisations et son architecture a été profondément modifiée à mesure que je gagnais en compétences. C’est pourquoi il reste quelques incohérences dans le nommage (parfois anglais, parfois français) ainsi que dans les commentaires (anglais ou français). Il faudrait en fait reprendre la structure de la base de données pour n’y utiliser que l’anglais.

### Base de données
La base de données n’est pas fournie dans le code source.

### Voir une démo
Vous pouvez voir le site en fonctionnement à l’adresse [jdr.pichegru.net](https://jdr.pichegru.net).
L’essentiel du site n’est cependant pas accessible si vous n’avez pas de compte (et vous ne pouvez pas en créer un vous-même). Si vous êtes intéressé, contactez-moi : t.pichegru@gmail.com. Je me ferai un plaisir de vous en créer un.