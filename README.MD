#  Projet dev web Symfony - CSC4101 - Timothée Mathubert

# IMPORTANT

**Si le chargement d'images ne fonctionne pas, faites sur votre machine php --ini, cherchez dans le résultat le fichier 'extensions.ini' et ajoutez-y la ligne 'extension=fileinfo'.**

## Application web de collection de cartes TUX

On peut gagner des points et des cartes TUX en faisant de bonnes choses à MiNET et en poussant toujours plus ses projets !
Cette application permet de montrer les cartes TUX qu'on a !

Normalement, on peut acheter des cartes TUX avec des points TUX : comme l'application ne gèrera pas les points, on affichera seulement le prix des cartes !

### CarteTux [Objet] :
 - type : Local, Niveau 1/2/3, Mascotte, Prez, ... (les types ne sont pas encore totalement déterminés) *str*
 - image : Champs multiples pour l'implémentation de la mise en ligne d'image *utilise VichUploader*
 - description : Description de la carte (on précise l'équipement ou la personne par exemple) *str*
 - prix : Prix en points TUX *int*
 - date : Date d'obtention de la carte *Date*
 - classeurtux : Le classeur dans lequel se trouve la carte *relation ManyToOne*

### ClasseurTux [Inventaire] :
 - name : Le nom du classeur
 - cartestux : La liste des cartes Tux du classeur *relation OneToMany*
 - membretux : L'utilisateur propriétaire du classeur *relation OneToMany*

### MembreTux [Membre] :
 - pseudo : Le nom d'utilisateur *str*
 - classeurtux : Le classeur de l'utilisateur *relation ManyToOne*
 - vitrinestux : Les vitrines du l'utilisateur *relation OneToMany*
 - user : lien avec l'entité "User" de Symfony *relation OneToOne*

### VitrineTux [Galerie] :
 - name : Le nom de la vitrine *str*
 - ispublic : Booléen pour déterminer de l'état public ou non de la vitrine *bool*
 - cartestux : La liste des cartes Tux du classeur *relation ManyToMany*
 - membretux : Le propriétaire des vitrines *relation ManyToOne*

### User

### Les comptes créés : [EMAIL / MDP / ROLE]
 - xhelozs@localhost / xhelozs / ROLE_ADMIN
 - placeholder@localhost / placeholder / ROLE_USER
 - nishogi@localhost / nishogi / ROLE_USER
 - jouliet@localhost / jouliet / ROLE_USER
 - xanode@localhost / xanode / ROLE_USER
 - fauconk@localhost / fauconk / ROLE_USER
 - izaia@localhost / izaia' / ROLE_USER
 
