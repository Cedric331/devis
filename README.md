# Devis

## Installation

1. Installer les dépendances PHP et JavaScript :
   ```bash
   composer install
   npm ci && npm run build
   ```
2. Copier le fichier d'environnement et générer la clé de l'application :
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Exécuter les migrations :
   ```bash
   php artisan migrate
   ```

## File d'attente

Lancer Horizon pour traiter les jobs en file :
```bash
php artisan horizon
```
