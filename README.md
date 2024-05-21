# Introduction
Cette documentation est destiné à l'utilisateur de l'application au niveau "organisator" ou "administrator".

# Table des matières
* [Gestion des utilisateurs](#gestion-des-utilisateurs)
    * [Création de compte](#création-de-compte)
    * [Authentification](#authentification)
    * [Modification et suppression de compte](#modification-et-suppression-de-compte)
* [Gestion des tickets](#gestion-des-tickets)
    * [Panier](#panier)
    * [Paiement](#paiement)
    * [E-ticket](#e-ticket)
    * [Scanning des tickets](#scanning-des-tickets)
* [Gestion des offres](#gestion-des-offres)
    * [Création d'une offre](#création-dune-offre)
    * [Modification et suppression d'une offre](#modification-et-suppression-dune-offre)


# Gestion des utilisateurs
Cette section traite de la gestion des utilisateurs et de leurs comptes.

## Création de compte
Chaque utilisateur peut créer un compte en se rendant à l'URL suivante : https://joticketsaler.fallforrising.com/register.  
Lors de l'inscription, les informations suivantes seront demandées :
* Nom
* Prénom
* Adresse email
* Mot de passe (le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial)

**A venir :** Nous demanderons aux utilisateurs de valider leur adresse email via un lien qui leur sera envoyé.

## Authentification
Chaque utilisateur possédant un compte pourra s'authentifier à l'URL suivante : https://joticketsaler.fallforrising.com/login, en utilisant l'adresse email renseignée lors de son inscription, ainsi que son mot de passe.  
Une fois authentifié, l'utilisateur aura accès aux fonctionnalités suivantes :
* Accès à la boutique
* Ajout d'articles dans son panier
* Paiement de ses articles
* Modification de son compte
* Suppression de son compte

**A venir :** Nous demanderons aux utilisateurs de procéder à une double authentification en saisissant un code qui leur sera envoyé par email.   
**Sécurité :** Les utilisateurs possèdent un identifiant de type UUID, ce qui rend leur obtention impossible. De plus, comme évoqué ci-dessus, les mots de passe doivent respecter des critères de sécurité minimum.

## Modification et suppression de compte
Chaque utilisateur possédant un compte peut le modifier ou le supprimer à l'URL suivante : https://joticketsaler.fallforrising.com/profil.

# Gestion des tickets
Cette section traite de la gestion des tickets et de leur validation.

## Panier
L'utilisateur, après s'être authentifié, pourra ajouter des tickets à son panier en se rendant à l'URL suivante : https://joticketsaler.fallforrising.com/shop.  
De plus, il aura la possibilité de revoir son panier avant de passer au paiement à l'URL suivante : https://joticketsaler.fallforrising.com/cart.  
À partir de cette page, il pourra également supprimer des articles de son panier.  
**Attention: Cette URL n'est accessible que si le panier de l'utilisateur n'est pas vide.**

**A venir :** Les clients pourront modifier les quantités des articles dans leur panier lors de la révision de celui-ci.  
**Sécurité :** Ces pages ne sont accessibles que si l'utilisateur est authentifié.

## Paiement
L'utilisateur pourra payer les articles de son panier à l'URL suivante : https://joticketsaler.fallforrising.com/payment.  
**Attention: Cette URL n'est accessible que si le panier de l'utilisateur n'est pas vide.**

**Sécurité :** Ces pages ne sont accessibles que si l'utilisateur est authentifié.

## E-ticket
Lors du paiement, l'utilisateur recevra un nombre de tickets correspondant aux offres sélectionnées et à la quantité de chacune d'elles.  
Ces tickets seront envoyés par email à l'adresse fournie lors de l'inscription.  
Les tickets sont représentés par des QR codes uniques pour chaque ticket.

## Scanning des tickets
Un utilisateur ayant un rôle d'`admin` ou d'`organisator` pourra se rendre à l'URL suivante : https://joticketsaler.fallforrising.com/scan.  
Si l'appareil sur lequel il ouvre cette page possède une caméra, il lui sera demandé la permission d'utiliser cette caméra (les autorisations sont gérées par le navigateur).  
Il aura alors la vue de sa caméra et pourra scanner des tickets avec celle-ci.  
L'application se chargera de valider le ticket. Quatre cas sont possibles :
* Le ticket est authentique, existe et n'a pas encore été scanné :
    L'interface sera colorée en vert, le nom et le prénom du possesseur du ticket seront visibles, et un message indiquant "OK" sera affiché.  

* Le ticket n'a pas été trouvé :
    Le ticket n'existe pas ou la lecture du QR code n'a pas fonctionné (réessayer). L'interface sera colorée en rouge et un message indiquant "Le ticket n'a pas été trouvé" sera affiché.

* Le ticket n'est pas valide :
    Le ticket n'existe pas ou il est erroné. L'interface sera colorée en rouge et un message indiquant "Ticket invalide" sera affiché.

* Le ticket a été trouvé mais a déjà été scanné : 
    L'interface sera colorée en rouge et un message indiquant "Ticket déjà scanné" sera affiché.

**Attention: Cette interface n'est accessible que si l'utilisateur possède le rôle d'`admin` ou d'`organisator`.**

# Gestion des offres
Les organisateurs et administrateurs peuvent ajouter, modifier ou supprimer des offres de tickets.  
**Attention:  Cette section n'est accessible qu'aux utilisateurs possédant le rôle d'`admin` ou d'`organisator`.**

## Création d'une offre
L'utilisateur peut créer une offre en cliquant sur l'icône d'ajout et en fournissant les informations suivantes :
* Le nom de l'offre
* Le prix, qui doit être sous la forme `xx.xx`.
* La quantité de tickets dans l'offre
Une image par défaut sera affichée pour les noms autres que `solo`, `duo` ou `familly`.

## Modification et suppression d'une offre
L'utilisateur peut modifier une offre en cliquant sur `edit`.  
Il sera invité à modifier les informations de l'offre en respectant les mêmes conditions que pour la création.  
De plus, il peut supprimer l'offre en cliquant sur `delete`.
