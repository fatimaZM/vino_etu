<?php

/**
 * Class Utilisateurs
 * Classe qui gère les données et le côntrole des utilisateurs
 *
 */
class Utilisateurs extends Modele
{

    /**
     * @var 
     * @access private
     * @static
     */



    /**
     * Fonction controlerUtilisateur : contrôler l'authentification de l'utilisateur dans la table vino__utilisateur
     * $identifiant
     * $mot_de_passe
     * Valeurs de retour : 1 si utilisateur avec $identifiant et $mot_de_passe trouvé, 0 sinon
     */

    function controllerUtilisateur($courriel, $mot_de_passe)
    {
        $response = ['data' => null];
        //SHA : mot de passe en clair
        $req = "SELECT * FROM vino__utilisateur WHERE courriel_utilisateur='$courriel' AND password_utilisateur = '$mot_de_passe'"; 

        //SHA : hachage du mot de passe
        // $req = "SELECT * FROM vino__utilisateur WHERE courriel_utilisateur='$identifiant' AND password_utilisateur = SHA2('$mot_de_passe', 256)";

        if ($result = $this->_db->query($req)) {
            $response['data'] = $result->fetch_assoc();
        } else {
            throw new Exception("Erreur de requête sur la base de données", 1);
        }

        return $response;
    }



}
