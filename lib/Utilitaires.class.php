<?php

/**
 * Class Untilitaires
 * Classe qui contient les outils utiles pour tous les scripts
 *
 *
 * @author Jonathan Martel
 * @version 1.0
 * 
 *
 *
 */
class Utilitaires
{

	/**
	 * afficheTable permet d'afficher des données sous forme de table
	 *
	 * @param Array $data : tableau de données à ficher sous forme de table
	 * @return HTML $res : code HTML de la table
	 */
	public static function afficheTable($data)
	{
		$res = '';
		$header = '';
		foreach ($data as $cle => $enregistrement) {
			$res .= '<tr>';
			$header = '';
			foreach ($enregistrement as $colonne => $valeur) {
				$header .= '<td>' . $colonne . '</td>';
				$res .= '<td>' . $valeur . '</td>';
			}
			$res .= '</tr>';
			$header = '<tr>' . $header . '</tr>';
		}
		$res = '<table>' . $header . $res . '</table>';
		return $res;
	}
}
