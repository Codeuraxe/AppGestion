# MediatekFormation

Application d'origine 

L'application MediatekFormation est un projet accessible via le lien GitHub suivant : GitHub - CNED-SLAM/mediatekformation. Vous y trouverez également la documentation complète dans le fichier README du dépôt.

Présentation 

MediatekFormation est une plateforme web développée avec Symfony 5.4, conçue pour permettre l'accès à des vidéos d'auto-formation proposées par une chaîne de médiathèques, également disponibles sur YouTube. 
Elle intègre une partie back-office destinée à la gestion des formations par les administrateurs.

Fonctionnalités ajoutées 

![reree](https://github.com/Codeuraxe/Kanban2/assets/115351194/10197538-36ab-4e0d-b707-eeb9fb700906)

Les différentes pages

## Page n°1: Les formations - Front-office

![gergre](https://github.com/Codeuraxe/Kanban2/assets/115351194/f80f8fd3-8af4-45f3-8c1e-7a878d48c678)


Cette page présente les formations disponibles et inclut une fonctionnalité de trie sur les formations, playlists, dates. 
Ainsi que des fonctions de filtrage sur les formations, playlists et catégories.  
Voir le dépôt : 
## Page n°2: Les playlists - Front-office

![tgth](https://github.com/Codeuraxe/Kanban2/assets/115351194/14701fbc-af30-4ed5-a02f-9ef974310d11)


Cette page présente les playlists disponibles et inclut une fonctionnalité de trie sur les playlists, le nombre formations. Ainsi que des fonctions de filtrage sur les playlists et catégories.  
Voir le dépôt : 
## Page n°3: Page de Connexion - Back-office

![rhtb](https://github.com/Codeuraxe/Kanban2/assets/115351194/6e9ed767-176c-436a-b59a-586e888e714b)

Accessible via l'ajout de /admin à l'URL ou le bouton gestion, cette page permet aux administrateurs de se connecter au back-office du site.
## Page n°4: Page des Formations - Back-office

![brfd](https://github.com/Codeuraxe/Kanban2/assets/115351194/4d196298-3f89-4aa9-8283-13907c6bbf34)


Affichée après connexion de l'administrateur, cette page permet la gestion des formations, avec des options pour éditer ou supprimer une formation, ou en ajouter une nouvelle.

## Page n°5: Ajouter une Formation

![uyu](https://github.com/Codeuraxe/Kanban2/assets/115351194/9bbba977-28a1-48b8-949a-fcd30e13ebc1)


Cette page s'affiche lorsque l'on souhaite ajouter une nouvelle formation, comprenant un formulaire détaillé pour renseigner toutes les informations nécessaires.

## Page n°6: Modifier une Formation

![tvy](https://github.com/Codeuraxe/Kanban2/assets/115351194/714fbd98-89fb-4ee7-abb7-519a67f72432)

Similaire à la page d'ajout, mais pré-remplie avec les informations de la formation à éditer.

## Page n°7: Page des Playlists - Back-office

![huku](https://github.com/Codeuraxe/Kanban2/assets/115351194/5cd1d06c-2324-40ff-aad8-5600332c96e0)

Permet la gestion des playlists avec options pour ajouter, éditer ou supprimer une playlist.

## Page n°8: Ajout d'une Playlist

![uyuy](https://github.com/Codeuraxe/Kanban2/assets/115351194/ee562adb-8e68-4b0a-a1c7-e08861fdc38f)

Formulaire pour la création d'une nouvelle playlist.

## Page n°9: Modification d'une Playlist

![vyuk](https://github.com/Codeuraxe/Kanban2/assets/115351194/3f07f194-3dcb-4b7e-9321-7e731574c4dc)

Permet d'éditer une playlist existante. 

## Page n°10: Page des Catégories

![ygu](https://github.com/Codeuraxe/Kanban2/assets/115351194/150c8089-a75b-4309-8fa0-21a272f4bc15)

Permet l'ajout et la suppression de catégories de formations.

## Installation de l'application en local

Suivez ces étapes pour installer l'application en environnement local :
Assurez-vous que Composer, Git, et Wamserver (ou un équivalent) sont installés sur votre machine.
Téléchargez le code depuis le dépôt GitHub et dézippez-le dans le dossier www de Wampserver (ou un dossier équivalent), puis renommez le dossier en "mediatekformation".
Ouvrez une fenêtre de commandes en mode administrateur, naviguez dans le dossier du projet, et exécutez composer install pour reconstituer le dossier vendor.
Utilisez le fichier mediatekformation.sql trouvé à la racine du projet pour créer la base de données MySQL nommée "mediatekformation" avec l'utilisateur root sans mot de passe 
(si vous préférez utiliser des identifiants différents, modifiez le fichier .env à la racine du projet en conséquence).
Ouvrez l'application dans un IDE professionnel pour de meilleures performances. 
L'application peut être lancée à l'adresse : http://localhost/mediatekformation/public/index.php.

## Tester l'application en ligne
L'application est également disponible en ligne aux adresses suivantes :
Accès principal : https://mediatekformation.online
Page d'authentification admin : https://mediatekformation.online/public/admin
Documentation technique : https://mega.nz/folder/QOFAlL6T#KZt2tqV0oJWrcE6WrUktpg
Pour accéder à la documentation technique, téléchargez le dossier et cliquez sur index.html

