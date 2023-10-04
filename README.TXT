Projet dev web Symfony - CSC4101

Application web de collection de cartes TUX

On peut gagner des points et des cartes TUX en faisant de bonnes choses à MiNET !
Cette application permet de montrer les cartes TUX qu'on a !

Normalement, on peut acheter une carte TUX avec des points TUX : comme l'application ne gèrera pas les points, on affichera seulement le prix des cartes !

CarteTux [Objet] :
 - type : Local, Matos, Mascotte, Prez, ... (les types ne sont pas encore totalement déterminés)
 - desc : Description de la carte (on précise l'équipement, la personne par exemple)
 - prix : prix en points TUX
 - date : date d'obtention de la carte

ClasseurTux [Inventaire] :
 - name : Le nom du classeur
 - cartestux : La liste des cartes Tux du classeur

VitrineTux [Galerie] :
 - 