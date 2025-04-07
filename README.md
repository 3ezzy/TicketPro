# TicketPro - Système de Gestion de Tickets

TicketPro est une application web complète pour la gestion des tickets de support, permettant aux clients de signaler des problèmes, aux administrateurs d'assigner des tickets aux développeurs, et aux développeurs de résoudre les problèmes et soumettre leurs solutions.

## 📋 Table des matières
- [Fonctionnalités](#fonctionnalités)
- [Technologies utilisées](#technologies-utilisées)
- [Rôles et permissions](#rôles-et-permissions)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Structure de la base de données](#structure-de-la-base-de-données)
- [Captures d'écran](#captures-décran)
- [Développement futur](#développement-futur)
- [Licence](#licence)

## ✨ Fonctionnalités

### Gestion des tickets
- Création de tickets avec détails (titre, description, priorité, système d'exploitation, logiciel)
- Suivi du statut des tickets (ouvert, en cours, en attente d'approbation, fermé)
- Visualisation détaillée des tickets avec historique des actions
- Filtrage et recherche avancés

### Gestion des assignations
- Attribution des tickets aux développeurs par les administrateurs
- Système de notification pour les nouvelles assignations
- Tableau de bord pour visualiser les tickets assignés

### Processus de résolution
- Interface pour les développeurs pour marquer les tickets comme résolus
- Système d'approbation des résolutions par les administrateurs
- Notes de résolution et commentaires

### Statistiques et rapports
- Tableau de bord avec métriques clés
- Statistiques par développeur (taux de résolution, temps moyen)
- Vue d'ensemble des tickets par statut, priorité et catégorie

## 🛠️ Technologies utilisées

- **Framework**: Laravel (PHP)
- **Base de données**: PostgreSQL
- **Frontend**: 
  - HTML, CSS, JavaScript
  - TailwindCSS pour le design
  - Alpine.js pour les interactions JavaScript légères
- **Bibliothèques**: 
  - Font Awesome pour les icônes
  - UI Avatars pour les images de profil

## 👥 Rôles et permissions

### Client
- Peut créer des tickets
- Peut voir, modifier et supprimer ses propres tickets
- Peut voir les détails des résolutions

### Développeur
- Peut voir tous les tickets
- Peut consulter les détails des tickets qui lui sont assignés
- Peut marquer les tickets comme résolus et ajouter des notes de résolution
- Ne peut pas modifier ou supprimer des tickets

### Administrateur
- Peut voir tous les tickets
- Peut assigner des tickets aux développeurs
- Peut supprimer des tickets
- Peut approuver ou rejeter les résolutions proposées par les développeurs
- Ne peut pas modifier les tickets (créés par les clients)

## 🔧 Installation

### Prérequis
- PHP >= 8.1
- Composer
- PostgreSQL
- Node.js & NPM

### Étapes d'installation

1. Cloner le dépôt
   ```bash
   git clone https://github.com/votre-username/ticketpro.git
   cd ticketpro
   ```

2. Installer les dépendances PHP
   ```bash
   composer install
   ```

3. Installer les dépendances JavaScript
   ```bash
   npm install
   npm run build
   ```

4. Copier le fichier d'environnement
   ```bash
   cp .env.example .env
   ```

5. Configurer la base de données dans le fichier .env
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=ticketpro
   DB_USERNAME=postgres
   DB_PASSWORD=votre_mot_de_passe
   ```

6. Générer la clé d'application
   ```bash
   php artisan key:generate
   ```

7. Exécuter les migrations et les seeders
   ```bash
   php artisan migrate --seed
   ```

8. Démarrer le serveur de développement
   ```bash
   php artisan serve
   ```

## ⚙️ Configuration

### Configuration de la base de données
Le système utilise PostgreSQL par défaut, mais peut être adapté pour d'autres systèmes de gestion de base de données supportés par Laravel.

### Configuration des emails
Pour les notifications par email, configurez les paramètres SMTP dans le fichier .env :
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## 📝 Utilisation

### Connexion

Utilisez les comptes de test suivants pour vous connecter :

- **Client**
  - Email: client1@example.com
  - Mot de passe: password

- **Développeur**
  - Email: developer1@example.com
  - Mot de passe: password

- **Admin**
  - Email: admin1@example.com
  - Mot de passe: password

### Workflow typique

1. **Création du ticket** - Un client crée un nouveau ticket en décrivant son problème
2. **Assignation** - Un administrateur examine le ticket et l'assigne à un développeur approprié
3. **Résolution** - Le développeur résout le problème et soumet sa solution avec des notes explicatives
4. **Approbation** - L'administrateur vérifie la solution et approuve la résolution
5. **Fermeture** - Le ticket est marqué comme résolu et fermé

## 📊 Structure de la base de données

Le système comprend les tables principales suivantes :

- **users** - Stocke les informations des utilisateurs (clients, développeurs, administrateurs)
- **tickets** - Contient les détails des tickets de support
- **software** - Répertorie les logiciels concernés par les tickets
- **assignments** - Enregistre les assignations de tickets aux développeurs
- **ticket_resolutions** - Stocke les informations de résolution des tickets


## 🔮 Développement futur

Fonctionnalités prévues pour les prochaines versions :

- Intégration d'un système de commentaires pour les tickets
- Ajout de notifications par email
- Implémentation d'un système de rapports avancés
- Intégration avec d'autres services (Slack, Jira, etc.)
- Application mobile pour la gestion des tickets en déplacement

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

Développé avec ❤️ par Mehdi🖤