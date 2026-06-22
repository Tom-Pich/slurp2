# SLURP v3 – Le moteur de JdR universel

Ce projet contient le code source de mon application permettant de faire des parties de SLURP en ligne. SLURP est un moteur de règles universelles de JdR sur table. C’est un _fork_ de GURPS de ma propre invention. Le projet a démarré en 2000.

Ce site contient :
- Toutes les règles de SLURP.
- Une table de jeu, comportant des widgets d’assistance et un système de _chat_ en websocket (le serveur de chat n’est pas inclus ici).
- Un système de gestion des personnages.
- Une partie réservée aux MJ leur permettant de gérer leurs parties.
- Une partie administration qui m’est exclusivement réservée.

### Structure et architecture
Ce site est développé avec le moins de bibliothèques possible. J’en utilise deux : _TinyMCE_ pour l’édition de texte dans la partie admin, et _Morphdom_ pour le DOM diffing.

### Base de données
La base de données n’est pas fournie dans le code source.

### Voir une démo
Vous pouvez voir le site en fonctionnement à l’adresse [jdr.pichegru.net](https://jdr.pichegru.net).
L’essentiel du site n’est cependant pas accessible si vous n’avez pas de compte (et vous ne pouvez pas en créer un vous-même). Si vous êtes intéressé, contactez-moi via le site.