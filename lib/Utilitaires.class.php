<?php
/**
 * 
 *
 *
 * @author Jonathan Martel
 * @version 1.0
 * 
 *
 *
 */
class Utilitaires {
	
	/**
	 * 
	 *
	 * @param void
	 * @return Singleton
	 */
	public static function afficheTable($data) {
		$res = '';
		$header = '';
		foreach ($data as $cle => $enregistrement) 
		{
			$res .= '<tr>';
			$header = '';
			foreach ($enregistrement as $colonne => $valeur) {
				$header .= '<td>'. $colonne.'</td>';
				$res .= '<td>'. $valeur .'</td>';
			}
			$res .= '</tr>';
			$header = '<tr>' . $header .'</tr>';
		}
		$res = '<table>'. $header . $res . '</table>';
		return $res;
	}

}
