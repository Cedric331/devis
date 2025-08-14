OuiDevis — Spécification produit (version « pas de gestion d’argent »)
One-liner
SaaS pour créer, envoyer et faire accepter des devis, avec relances automatiques et suivi d’acompte.
La plateforme ne gère pas d’argent : elle déclenche un paiement via le compte Stripe de l’utilisateur ou affiche son RIB. L’encaissement se fait hors plateforme.

Clause « Aucune gestion de fonds » (obligatoire)
La plateforme n’encaisse pas, ne détient pas, ne transite pas et ne redistribue pas d’argent.

La plateforme n’est pas merchant of record.

Stripe : enregistre l’ID du compte Stripe connecté (OAuth) et crée des Sessions Checkout au nom de ce compte. Les fonds vont directement à l’utilisateur.

Virement (RIB) : affiche l’IBAN/BIC fourni ; paiement effectué en dehors de l’app.

Données paiement stockées = métadonnées : method (stripe|bank_transfer|…), amount, status (pending|paid|failed), reference, timestamp, evidence_file?. Aucune donnée carte.

Acteurs & multi-tenant
Company (tenant) : espace dédié, branding, paramètres devis/relances, répertoire clients.

Users : Owner / Member.

Admin plateforme : via Filament (gouvernance globale uniquement).

Capacités par Company
Devis

Créer un devis : items (libellé, qty, PU, TVA, remise), notes/CGV, échéance, devise, branding.

Importer un PDF existant.

PDF du devis générable (en plus de la page publique) pour envoi/archivage.

Versioning : toute modif financière (items/prix/TVA/acompte) ⇒ nouvelle version + acceptation à refaire. Modifs non financières (RIB visible, notes internes, échéance, statut paiement manuel) ⇒ pas de nouvelle acceptation.

Paramètres par Company : devise par défaut, TVA, numérotation {YEAR}-{SEQ}, remise autorisée, CGV/mentions légales, RIB par défaut (IBAN/BIC), instructions de paiement, acompte par défaut (%), textes d’email (envoi/relances).

Acceptation

Page publique /d/{hash} : Accepter / Refuser.

Acceptation = nom + case “Bon pour accord” + IP + horodatage + empreinte de version → PDF d’acceptation.

Acompte (optionnel)

Stripe (si connecté) : Checkout Session sur le compte Stripe de la Company ; webhooks → statut Acompte payé.

RIB : affichage IBAN/BIC ; marquage manuel “acompte reçu” (référence + justificatif).

Sans acompte : acceptation seule.

Relances (personnalisables par Company)

Scénarios, délais et modèles d’email (variables {client_name}, {quote_number}, {quote_link}, {due_date}, {amount}) :

Non vu (J+2, J+7),

Vu mais non accepté (J+X),

Accepté mais acompte non reçu (date prévue / mode RIB).

Répertoire clients

Fiches Clients (personne/entreprise) : coordonnées, TVA, adresses, emails de facturation.

Import/Export CSV, déduplication basique (email/SIREN), autocomplete à la création de devis.

Tableau de bord Company

Statuts : Brouillon → Envoyé → Vu → Accepté (Acompte en attente | Acompte payé) → Terminé ; ou Refusé / Expiré.

KPI : vues, taux d’acceptation, délai moyen d’acceptation, acomptes en attente, montants marqués “payés”.

Recherche/filtre : par client, statut, date.

Envoi & notifications
Envoi du lien de devis : email intégré ou copier/coller.

Notifications (email/in-app) : devis vu, accepté, acompte marqué payé, devis expiré.

Back-office plateforme (Filament)
Réservé à l’administrateur (tenants, abonnements, quotas, jobs, incidents, paramètres globaux).

Aucun accès aux contenus commerciaux des tenants.

Workflows
Créer/Importer → Envoyer (lien) → Vu → Accepté.

Stripe : Checkout → webhook → Acompte payé.
RIB : Acompte en attente → marquage manuel → Acompte payé.

Relances auto selon règles Company.

Expiration auto à l’échéance (Expiré) ; possible réactivation.

Versioning si changement financier (re-acceptation).

Tech stack
Backend : Laravel 12 (PHP 8.3+), Redis/Queues, PostgreSQL.

Frontend : Vue 3 + Inertia.js, Tailwind CSS.

Admin : Filament (plateforme uniquement).

Fichiers : S3-compatible (PDF devis/acceptation, preuves).

Paiements : Stripe Checkout + Connect Standard.

Auth : Laravel (Sanctum/Session).

Packages
Laravel Sail (Docker)

spatie/laravel-medialibrary (fichiers/preuves)

laravel/cashier-stripe (Checkout/Connect)

spatie/laravel-activitylog (journal)

spatie/laravel-permission (RBAC)

laravel/horizon (queues)

(Email : Postmark/Resend/SES/SMTP)

Architecture & patterns
Single Action Controller (1 use-case = 1 contrôleur).

Services : QuoteNumberingService, CheckoutSessionFactory, ReminderEngine, PdfRenderer, PaymentStatusUpdater.

Jobs : relances, rendu PDF, webhooks Stripe.

DTO/FormRequest : validation stricte.

Multi-tenant : scoping par company_id (policies + requêtes).

Versioning devis : table dédiée, empreinte (render_hash) stockée dans l’acceptation.

Données (clés)
companies (branding, params, iban, bic, payment_instructions_default, stripe_account_id?)

users (company_id, rôle)

clients (company_id, type, identités, TVA, adresses)

quotes (company_id, client_id, number, currency, status, public_hash, deposit_percent?, payment_method, due_at)

quote_versions (quote_id, version, totals_json, render_hash)

quote_items (quote_version_id, label, qty, unit_price_cents, tax_rate)

quote_acceptances (quote_id, version, signer_name, ip, signed_at, pdf_path)

payments (quote_id, method, amount_cents, status, reference, evidence_path?, paid_at)

quote_events (type: sent|viewed|reminder_sent|status_changed|version_created|payment_marked, payload)

views, reminders, stripe_accounts

Endpoints (exemples)
POST /quotes, POST /quotes/{id}/send, GET /quotes/{id}

POST /public/quotes/{hash}/accept, POST /public/quotes/{hash}/refuse

POST /quotes/{id}/mark-deposit-paid (RIB), POST /stripe/webhook

POST /quotes/{id}/new-version

GET/POST /clients, POST /clients/import, GET /quotes/export

GET /dashboard/metrics, POST /settings/reminders

Sécurité & conformité
Isolation tenant par company_id + policies.

Secrets Stripe chiffrés.

SAQ-A (Stripe Checkout), aucune donnée carte.

RGPD : export/suppression par Company, logs d’accès, minimisation des données.

Prix
9,99 € / mois (option annuelle 99 €).

