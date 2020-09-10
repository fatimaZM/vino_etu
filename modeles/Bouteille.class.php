<?php

/**
 * Class Bouteille
 * Cette classe possède les fonctions de gestion des bouteilles dans le cellier et des bouteilles dans le catalogue complet.
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */
class Bouteille extends Modele
{
    const BOUTEILLE = 'vino__bouteille'; //table contenant la liste de bouteille du catalogue
    const CELLIER = 'vino__cellier'; //table contenant la liste des celliers et les informations les concernant (à quel utilisateur il appartient apr exemple)
    const TYPE = 'vino__type'; //table contenant la liste des types de vin (rouge, blanc, etc.)
    const CELLIER_BOUTEILLE = 'cellier__bouteille'; //table contenant la liste des bouteilles du celliers avec leurs informations

    /**
     * Cette méthode retourne la liste des bouteilles contenues dans la base de données
     * 
     * @return Array $rows contenant toutes les bouteilles.
     */
    public function getListeBouteille()
    {

        $rows = array();
        $res = $this->_db->query('SELECT * FROM ' . self::BOUTEILLE);
        if ($res->num_rows) {
            while ($row = $res->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        return $rows;
    }


    /**
     * Cette méthode retourne la liste des bouteilles contenues dans un cellier
     * 
     * @return Array $rows contenant toutes les bouteilles.
     */
    //clause WHERE de getListeBouteilleCellier() pour fin de test seulement 
    public function getListeBouteilleCellier()
    {

        $rows = array();
        $requete = 'SELECT
								c.vino__cellier_id,
								c.vino__bouteille_id,
								c.date_achat,
								c.garde_jusqua,
								c.notes,
								c.prix,
								c.quantite,
								c.millesime,
								vc.id,
								vc.fk_id_utilisateur,
								b.id,
								b.nom,
								b.image,
								b.code_saq,
								b.url_saq,
								b.pays,
								b.description,
								t.type
							FROM cellier__bouteille c
							INNER JOIN ' . self::BOUTEILLE . ' b ON c.vino__bouteille_id = b.id
							INNER JOIN ' . self::CELLIER . ' vc ON c.vino__cellier_id = vc.id
							INNER JOIN ' . self::TYPE . ' t ON t.id = b.fk_type_id
							WHERE c.vino__cellier_id = 2';

        if (($res = $this->_db->query($requete)) ==     true) {
            if ($res->num_rows) {
                while ($row = $res->fetch_assoc()) {
                    $row['nom'] = trim(utf8_encode($row['nom']));
                    $rows[] = $row;
                }
            }
        } else {
            throw new Exception("Erreur de requête sur la base de donnée", 1);
            //$this->_db->error;
        }



        return $rows;
    }

    /**
     * Cette méthode permet de retourner les résultats de recherche pour la fonction d'autocomplete de l'ajout des bouteilles dans le cellier
     * 
     * @param string $nom La chaine de caractère à rechercher
     * @param integer $nb_resultat Le nombre de résultat maximal à retourner.
     * 
     * @throws Exception Erreur de requête sur la base de données 
     * 
     * @return array id et nom de la bouteille trouvée dans le catalogue
     */
    public function autocomplete($nom, $nb_resultat = 10)
    {

        $rows = array();
        $nom = $this->_db->real_escape_string($nom);
        $nom = preg_replace("/\*/", "%", $nom);

        //echo $nom;
        $requete = 'SELECT id, nom FROM ' . self::BOUTEILLE . ' WHERE LOWER(nom) like LOWER("%' . $nom . '%") LIMIT 0,' . $nb_resultat;
        //var_dump($requete);
        if (($res = $this->_db->query($requete)) ==     true) {
            if ($res->num_rows) {
                while ($row = $res->fetch_assoc()) {
                    $row['nom'] = trim(utf8_encode($row['nom']));
                    $rows[] = $row;
                }
            }
        } else {
            throw new Exception("Erreur de requête sur la base de données", 1);
        }


        //var_dump($rows);
        return $rows;
    }


    /**
     * Cette méthode ajoute une ou des bouteilles au cellier
     * 
     * @param Object $data Tableau des données représentants la bouteille.
     * 
     * @return Boolean Succès ou échec de l'ajout.
     */
    public function ajouterBouteilleCellier($data)
    {
        //TODO : Valider les données.
        // var_dump($data);	

        //requete pour vérifier si la bouteille à ajouter n'est pas déjà au cellier :
        $sql = "SELECT vino__cellier_id, vino__bouteille_id FROM " . self::CELLIER_BOUTEILLE . " WHERE vino__cellier_id = " . $data->id_cellier . " AND vino__bouteille_id =" . $data->id_bouteille;

        //Si la bouteille est déjà au cellier, on incrémente seulement sa quantité, sinon on créé un nouvelle référence au cellier :
        if ($this->_db->query($sql)->num_rows > 0) {
            $this->modifierQuantiteBouteilleCellier($data->id_bouteille, $data->quantite);
        } else {
            $requete = "INSERT INTO " . self::CELLIER_BOUTEILLE . " (vino__cellier_id,vino__bouteille_id,date_achat,garde_jusqua,notes,prix,quantite,millesime) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $this->_db->prepare($requete);
            $stmt->bind_param('iisisdii', $data->id_cellier, $data->id_bouteille, $data->date_achat, $data->garde_jusqua, $data->notes, $data->prix, $data->quantite, $data->millesime);
            $res = $stmt->execute();
        }

        return $res;
    }


    /**
     * Cette méthode change la quantité d'une bouteille en particulier dans le cellier
     * 
     * @param int $id id de la bouteille
     * @param int $nombre Nombre de bouteille a ajouter ou retirer
     * 
     * @return Boolean Succès ou échec de l'ajout.
     */
    public function modifierQuantiteBouteilleCellier($id, $nombre)
    {
        //TODO : Valider les données.


        $requete = "UPDATE " . self::CELLIER_BOUTEILLE . " SET quantite = GREATEST(quantite + " . $nombre . ", 0) WHERE vino__bouteille_id = " . $id . " AND vino__cellier_id = 2";
        //echo $requete;
        $res = $this->_db->query($requete);

        return $res;
    }
}
