<?
/**
* Clase que gestiona los listados de Archivos Adjuntos. Sobrecarga del método __toString() para que muestre un listado
* en html al ser serializada, con las opciones y enlaces necesarios para gestionar la administración de archivos adjuntos.
* Recibe como parámetro una instancia de la clase que posee la lista de Adjuntos.
* Dicha clase debe implementar la interfaz IAdjuntos.
* 
* @package Utils
* @version 0.1
*/
class Lista_Adjuntos{
	
	/**
	 * Variable que almacena la entidad que posee la lista de Adjuntos.
	 *
	 * @var object
	 */
	private $Entidad;
	
	/**
	 * Constructor de la clase.
	 *
	 * @param object $Entidad
	 */
	public function __construct($Entidad){
		$this->Entidad = $Entidad;
	}
	
	/**
	 * Sobrecargando el método "mágico" para serializar el objeto.
	 *
	 * @return string $html Código html a ser mostrado.
	 */
	public function __toString(){
		global $appDir;
		
		$clase = get_class($this->Entidad);
		$Entidad = $this->Entidad;
		
		$html = "
				<table style='width:99%;'>
					 <tr>
						<th style='width:70%;' colspan='3'>
							"._translate("Archivos adjuntos", true)." &nbsp;&nbsp;&nbsp;&#8212;&nbsp;&nbsp;&nbsp;
							<a href='javascript:void(0);' onclick=\"window.open('$appDir/Common/php/utils/adjuntar_archivo.php?id=".$Entidad->get_Id()."&clase=".$clase."','".rand()."','width=700,height=350,scrollbars=yes');\">
								&#91;&nbsp;"._translate("Añadir", true)." / "._translate("Eliminar", true)."&nbsp;&#93;
							</a>
						</th>
					</tr>";
		foreach($Entidad->get_Adjuntos() as $Adjunto){
			$html.="
			<tr par>
				<td>
					<a href='javascript:void(0);' onclick=\"window.open('$appDir/Common/php/utils/enviar_archivo.php?id=".$Entidad->get_Id()."&clase=".$clase."&id_archivo=".$Adjunto->get_Id()."','".rand()."','width=700,height=350,scrollbars=yes');\">".$Adjunto->get_Name()."</a>
				</td>
				<td>".$Adjunto->get_Descripcion()."</td>
				<td style='width:2%;'>".$Adjunto->get_Hum_Size()."</td>
			</tr>";
		}
		$html .="</table>";
		
		return $html;
	}
}
?>