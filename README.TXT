Projet dev web Symfony - CSC4101

Application web de collection de cartes TUX

On peut gagner des points et des cartes TUX en faisant de bonnes choses à MiNET et en poussant toujours plus ses projets !
Cette application permet de montrer les cartes TUX qu'on a !

Normalement, on peut acheter des cartes TUX avec des points TUX : comme l'application ne gèrera pas les points, on affichera seulement le prix des cartes !

CarteTux [Objet] :
 - type : Local, Niveau 1/2/3, Mascotte, Prez, ... (les types ne sont pas encore totalement déterminés)
 - desc : Description de la carte (on précise l'équipement ou la personne par exemple)
 - prix : Prix en points TUX
 - date : Date d'obtention de la carte
 - classeurtux : Le classeur dans lequel se trouve la carte (relation ManyToOne)

ClasseurTux [Inventaire] :
 - name : Le nom du classeur
 - cartestux : La liste des cartes Tux du classeur (relation OneToMany)
 - membretux : L'utilisateur propriétaire du classeur (relation OneToOne)

MembreTux [Membre] :
 - role : Le rôle dans MiNET
 - pseudo : Le nom d'utilisateur
 - classeurtux : Le classeur de l'utilisateur (relation OneToOne)
 - vitrinestux : Les vitrines du l'utilisateur (relation OneToMany)

VitrineTux [Galerie] :
 - name : Le nom de la vitrine
 - ispublic : Booléen pour déterminer de l'état public ou non de la vitrine
 - cartestux : La liste des cartes Tux du classeur (relation ManyToMany)
 - membretux : Le propriétaire des vitrines (relation ManyToOne)