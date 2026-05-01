# Le Fil Rouge - Gestion Animation Jeunesse

<p align="center">
  <img src="https://wakatime.com/badge/user/996f0f7d-c952-4cd0-a2d6-e00eb364028d/project/fe09ea41-ee8b-4650-a872-8e2c623215b6.svg?cache_seconds=60" alt="WakaTime">
  <a href="https://www.figma.com/design/9lzwLsQn7pkZTwEIQnk1RA/Le-Fil-Rouge?node-id=0-1&t=CHFPrh0sjf7PPZ2s-1" target="_blank">
    <img src="https://img.shields.io/badge/Figma-Design-F24E1E?logo=figma">
  </a>
  <a href="https://github.com/Camara-Mohamed/camara-mohamed-doc-PFE" target="_blank">
    <img src="https://img.shields.io/badge/Documentation-GitHub-black?logo=github">
  </a>
  <img src="https://img.shields.io/badge/Status-Projet%20académique-green">
</p>

---

Dans le cadre de mon projet de fin d'études, j'ai choisi de faire une application web de gestion pour les formations en animation jeunesse, permettant de centraliser le parcours des animateurs, simplifier les démarches administratives et faciliter la communication entre animateurs, coordinateurs et administrateurs.

Développée dans le cadre de ma **dernière année de formation à la HEPL - Techniques Infographiques option Web**.

---

## 1. Contexte

Durant mon propre parcours de formation, les informations liées aux formations, aux stages, aux inscriptions ou 
encore aux documents administratifs étaient souvent mises à disposition sur différentes plateformes, comme les 
e-mails ou des groupes Facebook. On se perdait parfois, ce qui entraînait des 
oublis ou des pertes d’informations.

Je propose une solution pour mieux répondre à ces problèmes. L’objectif est de permettre aux animateurs, mais aussi 
aux coordinateurs, de gérer l’ensemble de leur parcours depuis une seule et même plateforme : une application web 
"**Le Fil Rouge**".

---

## 2. Personas et Scénarios

### Stéphanie - Administratrice

**Scénario 1 : Demande pour rejoindre la formation**

Stéphanie vient de recevoir une notification : c'est une demande de Sam qui voudrait devenir animateur et commencer 
sa formation. Il a rempli le formulaire disponible sur le site public. Stéphanie a étudié la demande de Sam et 
décide qu'il peut rejoindre la formation. Elle décide alors de lui créer un compte via la page de gestion des 
volontaires sur son interface d'administration. Elle lui crée une adresse mail qui se termine par @lefilrouge.com et 
un mot de passe, et remplit aussi les champs avec son nom et prénom. Ensuite, elle lui assigne le rôle "Arrivant". 
Une fois le profil créé, un mail est renvoyé à Sam sur l'adresse mail que Stéphanie avait au préalable indiquée dans 
le champ "Envoyé à :".

Stéphanie peut maintenant voir le profil de Sam dans la liste des autres volontaires. Elle peut ensuite modifier son rôle en "Animateur 1ère année" lorsqu'elle le jugera nécessaire (s'il a bien rempli son profil), ou d'autres données, mais ne peut pas modifier son mot de passe. Elle peut aussi supprimer son profil de volontaire.

**Scénario 2 : Ajout de document**

Quelques jours plus tard, Stéphanie reçoit à nouveau une notification de Sam, mais cette fois-ci, il a mis à jour son profil en ajoutant notamment son casier judiciaire, ce qui a envoyé une notification à Stéphanie. Sur son profil, elle visualise alors son casier judiciaire. Comme il est valide, elle accorde à Sam le rôle d'animateur de 1ère année. Il est maintenant au début de sa formation.

**Scénario 3 : Création de formation**

Un peu plus tard, Stéphanie reçoit une notification que Hugo vient de créer une formation. Elle se rend dans la page de gestion des messages et va sur la formation que Hugo vient de créer. Après l'avoir examinée, elle conclut qu'elle est valide et décide que la formation peut être publiée. Elle voit ensuite que la formation est disponible dans la liste des formations. Elle peut la modifier, la supprimer et voir ceux qui s'y sont inscrits et valider ou non leur demande.

**Scénario 4 : Création de stage ou de séjour**

Un peu avant les vacances, Stéphanie reçoit une notification que Paul vient de créer un stage. Elle se rend dans la page de gestion des messages et va sur le stage que Paul vient de créer. Après l'avoir examiné, elle conclut qu'il n'est pas valide parce que Paul a fait une erreur dans l'un des champs. Elle décide de corriger l'erreur et publie ensuite le stage. Elle voit ensuite que le stage est disponible dans la liste des stages et séjours. Elle peut le modifier, le supprimer et voir ceux qui s'y sont inscrits et valider ou non leur demande.

**Scénario 5 : Publication d'une actualité**

En fin de semestre, avec les formateurs, Stéphanie a fait une réunion sur des changements à propos du nouveau logo du "Fil Rouge" et de la nouvelle direction artistique. Elle décide de créer une actualité et d'en informer tous les membres. Via son interface d'administration, sur la page de gestion des actualités, elle en crée une et décide de la publier.

### Hugo - Formateur

**Scénario 1 : Création de formation**

Après avoir regardé un reportage sur la communication non violente, Hugo décide de créer une formation pour enfin partager ce qu'il a appris. Il se rend dans la page des formations et, avec son rôle, il décide de créer une nouvelle formation. Il complète les différents champs et, après en être satisfait, il crée la formation et attend la validation de Stéphanie pour qu'elle soit visible par tous les membres. Sa formation est visible sur la page des formations uniquement par lui et les administrateurs. Il peut télécharger un PDF récapitulatif de la formation.

**Scénario 2 : Validation d'un utilisateur**

Quelques heures plus tard, il reçoit une notification que Stéphanie a validé sa formation, et plusieurs animateurs, coordinateurs et formateurs s'y sont inscrits. Il va voir la liste de ceux-ci et décide qu'il y a un déséquilibre entre le nombre de coordinateurs et d'animateurs. Il décide alors d'accepter certains coordinateurs et d'en refuser certains pour que ce soit équitable. Ceux-ci sont notifiés.

### Paul - Coordinateur

**Scénario 1 : Création de stage**

À l'approche des vacances de Pâques, Paul décide de créer un stage sur le thème de la chasse aux œufs. Il se rend dans la page des "stages et séjours" et, avec son rôle, il décide de créer un nouveau stage. Il complète les différents champs et, après en être satisfait, il crée le stage et attend la validation de Stéphanie pour qu'il soit visible par tous les membres. Son stage est visible sur la page des "stages et séjours" uniquement par lui et les administrateurs. Il peut télécharger un PDF du contrat de travail.

**Scénario 2 : Validation d'un utilisateur**

Quelques heures plus tard, il reçoit une notification que Stéphanie a validé son stage, et plusieurs animateurs et coordinateurs s'y sont inscrits. Il va voir la liste de ceux-ci et décide d'accepter deux coordinateurs pour l'aider et choisit 2 animateurs de chaque année. Ceux-ci sont notifiés.

### Léa, Luc et Tiffany - Animatrice (1ère année, 2ème année, Brevetée)

Léa et Luc sont en cours de formation animateur, et Tiffany a terminé sa formation animateur.

**Scénario 1 : Calendrier des stages et formations**

Sur son profil, Léa remarque la page calendrier. Sur cette page, elle voit les différents stages, séjours et formations sur un calendrier.

**Scénario 2 : S'inscrire à un stage**

À l'approche des vacances, Tiffany conseille à ses deux amis de s'inscrire ensemble au même séjour. Sur le site, via leur profil respectif sur la page "stages et séjours", il y a une liste des différents stages et séjours qui arriveront prochainement. Ils décident ensemble de s'inscrire en cliquant sur le bouton "S'inscrire" après avoir accédé à la page du détail du séjour. Sur la page du séjour, ils voient plus bas que Tiffany est déjà inscrite. À leur tour, ils attendent qu'on accepte leur inscription.

**Scénario 3 : Candidature acceptée**

Léa et Luc ont reçu une notification disant qu'ils ont été acceptés pour le séjour. Ils vont voir la page du séjour et voient qu'ils peuvent télécharger un contrat de travail.

**Scénario 4 : Désinscription**

Malheureusement, Luc a un imprévu. Il décide alors de se désinscrire en cliquant sur le bouton "Se désinscrire". La coordinatrice est notifiée.

**Scénario 5 : Inscription à une formation**

Quelques semaines après, les 3 amis sont notifiés que Hugo a créé une nouvelle formation. Les deux amis s'y inscrivent en allant sur la page de la formation. Ils y voient les modalités et tout. Malheureusement, Léa, en première année, n'a pas accès à la formation vu qu'elle est seulement en 1ère année.

### Membres - Utilisateurs connectés

**Scénario 1 : Aide**

Ils ont accès à la page aide où ils voient comment utiliser le site quand on est connecté.

### Sam - Utilisateur non affilié

**Scénario 1 : Visite du site**

Un ami animateur a conseillé à Sam le site "le fil rouge". Curieux, Sam va le voir pour se renseigner et, pour en 
apprendre plus, il parcourt les différentes pages.

**Scénario 2 : Devenir animateur**

Convaincu par les valeurs et l'idée, Sam souhaite s'inscrire à une formation. Malheureusement, comme il n'est pas dans le système, il peut choisir de rejoindre la formation et est redirigé sur la page dédiée. Il remplit le formulaire avec ses données et le soumet. Il reçoit un message disant que son profil va être étudié.

## 3. Fonctionnalités principales

### Authentification
- Création de compte par administrateur
- Attribution de rôles (arrivant, animateur 1ère/2ème année, breveté, coordinateur, admin)

### Gestion des formations
- Création, modification, suppression, validation
- Inscription aux formations avec validation par administrateur
- Tri et filtres

### Gestion des séjours et stages
- Création, modification, suppression, validation
- Inscription aux stages avec validation par administrateur
- Tri et filtres
- Contrat de travail PDF

### Profil et documents
- Mise à jour des informations personnelles et coordonnées
- Téléversement et téléchargement de documents administratifs

## 3. Fonctionnalités secondaires

### Dashboard
- Calendrier des formations, des stages et des séjours

### Profil et historique
- Suivis de l'historique des formations, des stages et des séjours

## 3. Site Public
- Page "Accueil"
- Page "Les Formations"
- Page "Les Stages et Séjours"
- Page "Qui sommes-nous"
- Page "Actualités"
- Page "Nous Contacter"
- Page "Devenir Animateur"

---

## Technologies

| Technologie         | Utilité                                         |
|---------------------|-------------------------------------------------|
| Frontend & Backend  | Laravel 12 + Livewire 4  + Tailwind + Alpine JS |
| Base de données     | SQLite                                          |
| Testing             | Pest                                            |
| Stockage            | AWS S3 Storage                                  |
| Hébergement         | Laravel Cloud                                   |

---

## Installation

### Prérequis

- PHP 8.4+
- Laravel 12+
- Livewire 4+
- SQLite

### Étapes

1. Cloner le repository
   ```bash
   git clone https://github.com/Camara-Mohamed/le-fil-rouge.git
   cd le-fil-rouge
   ```

2. Initialiser le projet
   ```bash
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   ```

3. Créer les dossiers de cache et session
   ```bash
   touch database/database.sqlite
   ```

4. Lier le stockage public
   ```bash
   php artisan storage:link
   ```

5. Créer les tables nécessaires
   ```bash
   php artisan cache:table
   php artisan session:table
   php artisan queue:table
   ```

6. Migrer et seeder la base de données
   ```bash
   php artisan migrate:fresh --seed
   ```

7. Lancer le projet
 ```bash
   composer run dev 
   ```

8. Accéder à l'application
   ```
   http://localhost:8000
   ```

### Configuration

Éditer le fichier `.env` pour configurer :

---

## Documentation

Pour plus de détails sur le projet, consulter la documentation que j'ai faite sur le projet vous y verrez ma recherche 
graphique, mon processus de réflexion, illustrés et expliqués :
[Documentation GitHub - Projet de Fin d'Études](https://github.com/Camara-Mohamed/camara-mohamed-doc-PFE)

---

## Tests

Lancer la suite de tests :
```bash
php artisan test
```

---

## Auteur

Mohamed Camara
- Email : [camara.mohmd@gmail.com](mailto:camara.mohmd@gmail.com)
- Formation : HEPL - Techniques Infographiques option Web (Projet de Fin d'Études)
- Portfolio : [mohamed-camara.com](https://mohamed-camara.com/)
