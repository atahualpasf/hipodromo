<?php
	session_set_cookie_params(0 , '/hipodromo/');
	session_start();
	class Database{
		private $dbConnection = null;
		private $_SITE_ROOT;
		private $_CONF_ROOT;
		private $_INCL_ROOT;

		function __construct(){
			$this->_SITE_ROOT = $_SERVER['DOCUMENT_ROOT'] . 'hipodromo/';
			$this->_CONF_ROOT = $this->_SITE_ROOT . 'conf/';
			$this->_INCL_ROOT = $this->_SITE_ROOT . 'includes/';
			require($this->_CONF_ROOT."config.inc.php");
			$this->dbConnection = pg_connect($strConnection);
		}

		/************************************************************
		*																														*
		*						FUNCIONES GENÉRICAS DE MI CLASE 								*
		*																														*
		************************************************************/
		public function getIncludesPath() {
      return $this->_INCL_ROOT;
	  }

		public function getRootPath() {
			return $this->_SITE_ROOT;
		}

		public function getIncludesUri() {
      return '/hipodromo/includes/';
	  }

		public function getRootUri() {
			return '/hipodromo/';
		}

		/************************************************************
		*																														*
		*						FUNCIONES GENÉRICAS DE POSTGRESQL								*
		*																														*
		************************************************************/
		function status(){
			$status = pg_connection_status($this->dbConnection);
			if ($status === PGSQL_CONNECTION_OK) {
				return "Connection status ok";
			} else {
				return "Connection status bad";
			}
		}

		function disconnect(){
			if(!pg_close($this->dbConnection)) {
				return "Failed to close connection to " . pg_host($this->dbConnection) . ": " . pg_last_error($this->dbConnection) . "<br/>\n";
			} else {
				return "Successfully disconnected from database";
			}
		}

		function result_construct($action,$data){
			$result = array("action"=>$action,"response"=>array("data"=>$data));
			$result = json_encode($result, JSON_UNESCAPED_UNICODE);
			return $result;
		}

		/************************************************************
		*																														*
		*					 FUNCIONES GENÉRICAS DE LA APLICACIÓN							*
		*																														*
		************************************************************/
		function getRolesUsuario() {
			$result = pg_query($this->dbConnection,
			"SELECT * FROM rol");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			} else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return $this->result_construct("success", $respuesta);
			}
		}

		function getLugares(){
			$result = pg_query($this->dbConnection,"SELECT p.pklug_id,p.lug_nombre as parroquia, m.lug_nombre as municipio,e.lug_nombre as estado
			FROM lugar e, lugar m, lugar p WHERE p.fklug_lug_id = m.pklug_id and m.fklug_lug_id = e.pklug_id order by p.pklug_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		function getEjemplaresMadres() {
			$result = pg_query($this->dbConnection,
			"SELECT e.pkeje_id as pkmadre, e.eje_nombre as madre
			FROM ejemplar e
			WHERE e.eje_sexo = 'Y' AND e.fkeje_mad_id IS NULL AND e.fkeje_pad_id IS NULL");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		function getEjemplaresPadres() {
			$result = pg_query($this->dbConnection,
			"SELECT e.pkeje_id as pkpadre, e.eje_nombre as padre
			FROM ejemplar e
			WHERE e.eje_sexo = 'C' AND e.fkeje_mad_id IS NULL AND e.fkeje_pad_id IS NULL");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE PROPIETARIOS							*
		*																														*
		************************************************************/
		function createPropietario($fkpro_lug_id, $pro_ci, $pro_primer_nombre, $pro_segundo_nombre, $pro_primer_apellido, $pro_segundo_apellido, $pro_fecha_nacimiento, $pro_correo){
			$result = pg_query($this->dbConnection,
			"INSERT INTO propietario VALUES(nextval('propietario_pkpro_id_seq'::regclass),'$fkpro_lug_id', '$pro_ci', '$pro_primer_nombre', '$pro_segundo_nombre', '$pro_primer_apellido', '$pro_segundo_apellido', '$pro_fecha_nacimiento', '$pro_correo')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}
		
		function getPropietarios() {
			$result = pg_query($this->dbConnection,
			"SELECT pro.*, t.tel_codigo, t.tel_numero, p.lug_nombre as parroquia, e.lug_nombre as estado
			FROM lugar p, lugar m, lugar e, propietario pro LEFT JOIN telefono t ON t.fktel_pro_id = pro.pkpro_id
			WHERE pro.fkpro_lug_id = p.pklug_id AND p.fklug_lug_id = m.pklug_id AND m.fklug_lug_id = e.pklug_id
			ORDER BY pkpro_id");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function getPropietarioById($pkpro_id) {
			$result = pg_query($this->dbConnection,
			"SELECT pro.*, t.*
			FROM propietario pro LEFT JOIN telefono t ON t.fktel_pro_id = pro.pkpro_id
			WHERE pkpro_id = '$pkpro_id'");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function updatePropietario($pkpro_id, $fkpro_lug_id, $pro_ci, $pro_primer_nombre, $pro_segundo_nombre, $pro_primer_apellido, $pro_segundo_apellido, $pro_fecha_nacimiento, $pro_correo){
			$result = pg_query($this->dbConnection,
			"UPDATE propietario
			SET fkpro_lug_id='$fkpro_lug_id', pro_ci='$pro_ci', pro_primer_nombre='$pro_primer_nombre', pro_segundo_nombre='$pro_segundo_nombre', pro_primer_apellido='$pro_primer_apellido', pro_segundo_apellido='$pro_segundo_apellido', pro_fecha_nacimiento='$pro_fecha_nacimiento', pro_correo='$pro_correo'
			WHERE pkpro_id='$pkpro_id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deletePropietario($id) {
			$result = pg_query($this->dbConnection,
				"DELETE FROM propietario WHERE pkpro_id='$id'");
			if (pg_last_error()) {
				return $this->result_construct("error",pg_last_error());
			} else {
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		function getPropietariosDetalladoByStud($pkstu_id) {
			$result = pg_query($this->dbConnection,
			"SELECT p.pro_primer_nombre, p.pro_segundo_nombre, p.pro_primer_apellido, p.pro_segundo_apellido, sp.stupro_porcentaje
			FROM stud s, propietario p, stud_propietario sp
			WHERE s.pkstu_id = sp.fkstupro_stu_id AND sp.fkstupro_pro_id = p.pkpro_id  AND s.pkstu_id = '$pkstu_id'");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE ENTRENADORES							*
		*																														*
		************************************************************/
		function createEntrenador($fkent_lug_id, $ent_ci, $ent_primer_nombre, $ent_segundo_nombre, $ent_primer_apellido, $ent_segundo_apellido, $ent_fecha_nacimiento){
			$result = pg_query($this->dbConnection,
			"INSERT INTO entrenador VALUES(nextval('entrenador_pkent_id_seq'::regclass), '$fkent_lug_id', '$ent_ci', '$ent_primer_nombre', '$ent_segundo_nombre', '$ent_primer_apellido', '$ent_segundo_apellido', '$ent_fecha_nacimiento')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function getEntrenadores() {
			$result = pg_query($this->dbConnection,
			"SELECT ent.*, t.tel_codigo, t.tel_numero, p.lug_nombre as parroquia, e.lug_nombre as estado
			FROM lugar p, lugar m, lugar e, entrenador ent LEFT JOIN telefono t ON t.fktel_ent_id = ent.pkent_id
			WHERE ent.fkent_lug_id = p.pklug_id AND p.fklug_lug_id = m.pklug_id AND m.fklug_lug_id = e.pklug_id
			ORDER BY pkent_id");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function getEntrenadorById($pkent_id) {
			$result = pg_query($this->dbConnection,
			"SELECT ent.*, t.*
			FROM entrenador ent LEFT JOIN telefono t ON t.fktel_ent_id = ent.pkent_id
			WHERE pkent_id = '$pkent_id'");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function updateEntrenador($pkent_id, $fkent_lug_id, $ent_ci, $ent_primer_nombre, $ent_segundo_nombre, $ent_primer_apellido, $ent_segundo_apellido, $ent_fecha_nacimiento){
			$result = pg_query($this->dbConnection,
			"UPDATE entrenador
			SET fkent_lug_id='$fkent_lug_id', ent_ci='$ent_ci', ent_primer_nombre='$ent_primer_nombre', ent_segundo_nombre='$ent_segundo_nombre', ent_primer_apellido='$ent_primer_apellido', ent_segundo_apellido='$ent_segundo_apellido', ent_fecha_nacimiento='$ent_fecha_nacimiento'
			WHERE pkent_id='$pkent_id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteEntrenador($id) {
			$result = pg_query($this->dbConnection,
				"DELETE FROM entrenador WHERE pkent_id='$id'");
			if (pg_last_error()) {
				return $this->result_construct("error",pg_last_error());
			} else {
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE JINETES									*
		*																														*
		************************************************************/
		function createJinete($fkjin_lug_id, $jin_ci, $jin_primer_nombre, $jin_segundo_nombre, $jin_primer_apellido, $jin_segundo_apellido, $jin_fecha_nacimiento, $jin_altura, $jin_experiencia){
			$result = pg_query($this->dbConnection,
			"INSERT INTO jinete VALUES(nextval('jinete_pkjin_id_seq'::regclass), '$fkjin_lug_id', '$jin_ci', '$jin_primer_nombre', '$jin_segundo_nombre', '$jin_primer_apellido', '$jin_segundo_apellido', '$jin_fecha_nacimiento', '$jin_altura', '$jin_experiencia')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}
		
		function getJinetes() {
			$result = pg_query($this->dbConnection,
			"SELECT jin.*, t.tel_codigo, t.tel_numero, p.lug_nombre as parroquia, e.lug_nombre as estado
			FROM lugar p, lugar m, lugar e, jinete jin LEFT JOIN telefono t ON t.fktel_jin_id = jin.pkjin_id
			WHERE jin.fkjin_lug_id = p.pklug_id AND p.fklug_lug_id = m.pklug_id AND m.fklug_lug_id = e.pklug_id
			ORDER BY pkjin_id");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function getJineteById($pkjin_id) {
			$result = pg_query($this->dbConnection,
			"SELECT jin.*, t.*
			FROM jinete jin LEFT JOIN telefono t ON t.fktel_jin_id = jin.pkjin_id
			WHERE pkjin_id = '$pkjin_id'");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function updateJinete($pkjin_id, $fkjin_lug_id, $jin_ci, $jin_primer_nombre, $jin_segundo_nombre, $jin_primer_apellido, $jin_segundo_apellido, $jin_fecha_nacimiento, $jin_altura, $jin_experiencia){
			$result = pg_query($this->dbConnection,
			"UPDATE jinete
			SET fkjin_lug_id='$fkjin_lug_id', jin_ci='$jin_ci', jin_primer_nombre='$jin_primer_nombre', jin_segundo_nombre='$jin_segundo_nombre', jin_primer_apellido='$jin_primer_apellido', jin_segundo_apellido='$jin_segundo_apellido', jin_fecha_nacimiento='$jin_fecha_nacimiento', jin_altura='$jin_altura', jin_experiencia='$jin_experiencia'
			WHERE pkjin_id='$pkjin_id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteJinete($id) {
			$result = pg_query($this->dbConnection,
				"DELETE FROM jinete WHERE pkjin_id='$id'");
			if (pg_last_error()) {
				return $this->result_construct("error",pg_last_error());
			} else {
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*																														*
		*					 		  FUNCIONES GENÉRICAS DE STUDS								*
		*																														*
		************************************************************/
		function createStud($fkstu_lug_id, $stu_nombre, $stu_fecha_creacion){
			$result = pg_query($this->dbConnection,
			"INSERT INTO stud VALUES(nextval('stud_pkstu_id_seq'::regclass), '$fkstu_lug_id', '$stu_nombre', '$stu_fecha_creacion')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function getStuds() {
			$result = pg_query($this->dbConnection,
			"SELECT s.*, p.lug_nombre as parroquia, e.lug_nombre as estado
			FROM stud s, lugar p, lugar m, lugar e WHERE s.fkstu_lug_id = p.pklug_id AND p.fklug_lug_id = m.pklug_id AND m.fklug_lug_id = e.pklug_id");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function getStudById($pkstu_id) {
			$result = pg_query($this->dbConnection,
			"SELECT *	FROM stud WHERE pkstu_id = '$pkstu_id'");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function updateStud($pkstu_id, $fkstu_lug_id, $stu_nombre, $stu_fecha_creacion){
			$result = pg_query($this->dbConnection,
			"UPDATE stud
			SET fkstu_lug_id='$fkstu_lug_id', stu_nombre='$stu_nombre', stu_fecha_creacion='$stu_fecha_creacion'
			WHERE pkstu_id='$pkstu_id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteStud($id) {
			$result = pg_query($this->dbConnection,
				"DELETE FROM stud WHERE pkstu_id='$id'");
			if (pg_last_error()) {
				return $this->result_construct("error",pg_last_error());
			} else {
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*																														*
		*					 		  FUNCIONES GENÉRICAS DE GORRA								*
		*																														*
		************************************************************/
		function getGorrasDetalladoByStud($pkstu_id) {
			$result = pg_query($this->dbConnection,
			"SELECT c.col_nombre, cg.colgor_pieza
			FROM stud s, gorra g, color_gorra cg, color c
			WHERE s.pkstu_id = g.fkgor_stu_id AND g.pkgor_id = cg.fkcolgor_gor_id AND cg.fkcolgor_col_id = c.pkcol_id AND s.pkstu_id = '$pkstu_id'");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		/************************************************************
		*																														*
		*					 		FUNCIONES GENÉRICAS DE CHAQUETA								*
		*																														*
		************************************************************/
		function getChaquetasDetalladoByStud($pkstu_id) {
			$result = pg_query($this->dbConnection,
			"SELECT c.col_nombre, cc.colcha_pieza
			FROM stud s, chaqueta ch, color_chaqueta cc, color c
			WHERE s.pkstu_id = ch.fkcha_stu_id AND ch.pkcha_id = cc.fkcolcha_cha_id AND cc.fkcolcha_col_id = c.pkcol_id AND s.pkstu_id = '$pkstu_id'");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE EJEMPLARES								*
		*																														*
		************************************************************/
		function createEjemplar($fkeje_har_id, $fkeje_pel_id, $fkeje_raz_id, $fkeje_mad_id, $fkeje_pad_id, $eje_fecha_nacimiento, $eje_nombre, $eje_precio, $eje_sexo, $eje_tatuaje){
			if (!empty($fkeje_mad_id) && !empty(fkeje_pad_id)) {
				$result = pg_query($this->dbConnection,
				"INSERT INTO ejemplar VALUES(nextval('ejemplar_pkeje_id_seq'::regclass), '$fkeje_har_id', '$fkeje_pel_id', '$fkeje_raz_id', '$fkeje_mad_id', '$fkeje_pad_id', '$eje_fecha_nacimiento', '$eje_nombre', '$eje_precio', '$eje_sexo', '$eje_tatuaje')");
			} else {
				$result = pg_query($this->dbConnection,
				"INSERT INTO ejemplar VALUES(nextval('ejemplar_pkeje_id_seq'::regclass), '$fkeje_har_id', '$fkeje_pel_id', '$fkeje_raz_id', NULL, NULL, '$eje_fecha_nacimiento', '$eje_nombre', '$eje_precio', '$eje_sexo', '$eje_tatuaje')");
			}
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}
		
		function getEjemplares() {
			$result = pg_query($this->dbConnection,
			"SELECT e.pkeje_id, e.eje_nombre, e.eje_sexo, date_part('year', current_date) - date_part('year', e.eje_fecha_nacimiento) as edad, r.raz_nombre, p.pel_nombre, h.har_nombre,
			CASE  WHEN e.fkeje_mad_id IS NULL AND e.fkeje_pad_id IS NULL THEN CASE e.eje_sexo WHEN 'Y' THEN 'Madre' WHEN 'C' THEN 'Semental' END ELSE 'Hijo' END as afinidad
			FROM ejemplar e, raza r, pelaje p, hara h
			WHERE e.fkeje_raz_id = r.pkraz_id AND e.fkeje_pel_id = p.pkpel_id AND e.fkeje_har_id = h.pkhar_id");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function getEjemplarById($pkeje_id) {
			$result = pg_query($this->dbConnection,
			"SELECT e.*, r.raz_nombre, p.pel_nombre, h.har_nombre
			FROM ejemplar e, raza r, pelaje p, hara h
			WHERE e.fkeje_raz_id = r.pkraz_id AND e.fkeje_pel_id = p.pkpel_id AND e.fkeje_har_id = h.pkhar_id AND pkeje_id = '$pkeje_id'");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function updateEjemplar($pkeje_id, $fkeje_har_id, $fkeje_pel_id, $fkeje_raz_id, $fkeje_mad_id, $fkeje_pad_id, $eje_fecha_nacimiento, $eje_nombre, $eje_precio, $eje_sexo, $eje_tatuaje){
			if ((!empty($fkeje_mad_id)) && (!empty($fkeje_pad_id))) { 
				$result = pg_query($this->dbConnection,
				"UPDATE ejemplar
				SET pkeje_id='$pkeje_id', fkeje_har_id='$fkeje_har_id', fkeje_pel_id='$fkeje_pel_id', fkeje_raz_id='$fkeje_raz_id', fkeje_mad_id='$fkeje_mad_id', fkeje_pad_id='$fkeje_pad_id', eje_fecha_nacimiento='$eje_fecha_nacimiento', eje_nombre='$eje_nombre', eje_precio='$eje_precio', eje_sexo='$eje_sexo', eje_tatuaje='$eje_tatuaje'
				WHERE pkeje_id='$pkeje_id'");
			} else {
				$result = pg_query($this->dbConnection,
				"UPDATE ejemplar
				SET pkeje_id='$pkeje_id', fkeje_har_id='$fkeje_har_id', fkeje_pel_id='$fkeje_pel_id', fkeje_raz_id='$fkeje_raz_id', fkeje_mad_id=NULL, fkeje_pad_id=NULL, eje_fecha_nacimiento='$eje_fecha_nacimiento', eje_nombre='$eje_nombre', eje_precio='$eje_precio', eje_sexo='$eje_sexo', eje_tatuaje='$eje_tatuaje'
				WHERE pkeje_id='$pkeje_id'");
			}
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteEjemplar($id) {
			$result = pg_query($this->dbConnection,
				"DELETE FROM ejemplar WHERE pkeje_id='$id'");
			if (pg_last_error()) {
				return $this->result_construct("error",pg_last_error());
			} else {
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}
		
		/************************************************************
		*																														*
		*					 FUNCIONES GENÉRICAS DE IMPLEMENTOS								*
		*																														*
		************************************************************/
		function getImplementos() {
			$result = pg_query($this->dbConnection,
			"SELECT *	FROM implemento");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		/************************************************************
		*																														*
		*					 FUNCIONES GENÉRICAS DE USUARIOS									*
		*																														*
		************************************************************/
		function getUsuarios() {
			$result = pg_query($this->dbConnection,
			"SELECT u.*, r.pkrol_id, r.rol_nombre
			FROM usuario u, rol r
			WHERE u.fkusu_rol_id = r.pkrol_id");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		function getUsuarioById($pkusu_id) {
			$result = pg_query($this->dbConnection,
			"SELECT u.pkusu_id,u.usu_nombre,encode(u.usu_imagen, 'base64') as usu_imagen,r.pkrol_id,r.rol_nombre
			FROM usuario u, rol r
			WHERE pkusu_id = '$pkusu_id' and fkusu_rol_id = pkrol_id");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function getUsuarioPorId($id) {
			$result = pg_query($this->dbConnection,
			"SELECT u.*, r.pkrol_id, r.rol_nombre
			FROM usuario u, rol r
			WHERE u.pkusu_id = '$id' and u.fkusu_rol_id = r.pkrol_id");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		function registerUsuario($username,$email,$password,$rol,$foto) {
			pg_set_error_verbosity($this->dbConnection,PGSQL_ERRORS_DEFAULT);
			if (!empty($foto)) {
				$result = pg_query($this->dbConnection,
				"INSERT INTO usuario (pkusu_id,fkusu_rol_id,usu_correo,usu_nombre,usu_clave,usu_imagen)
				VALUES(nextval('usuario_pkusu_id_seq'::regclass), '$rol', '$email', '$username', '$password', '$foto') RETURNING pkusu_id");
			} else {
				$result = pg_query($this->dbConnection,
				"INSERT INTO usuario (pkusu_id,fkusu_rol_id,usu_correo,usu_nombre,usu_clave,usu_imagen)
				VALUES(nextval('usuario_pkusu_id_seq'::regclass), '$rol', '$email', '$username', '$password', NULL) RETURNING pkusu_id");
			}

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			} else {
				$row = pg_fetch_row($result);
				$id = $row['0'];
				return $this->result_construct("success",$id);
			}
		}

		function loginUsuario() {
			$result = pg_query($this->dbConnection,
			"SELECT pkusu_id,usu_nombre,usu_correo,usu_clave FROM usuario");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			} else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return $this->result_construct("success", $respuesta);
			}
		}
		
		function getPrivilegiosByRol($id,$privilegio) {			
			$result = pg_query($this->dbConnection,
			"SELECT rp.*
			FROM	rol_privilegio rp
			WHERE 	rp.fkrolpri_rol_id = $id and rp.fkrolpri_pri_id = $privilegio");
			
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				if (empty($respuesta)) {
					return $this->result_construct("error","No tiene asignado ningún privilegio");
				}
				return $this->result_construct("success", $respuesta);
			}
		}
		
		function updateUsuario($pkusu_id, $fkusu_rol_id, $usu_nombre, $usu_correo, $usu_clave, $usu_imagen){
			if (!empty($usu_imagen)) {
				$result = pg_query($this->dbConnection,
				"UPDATE usuario
				SET pkusu_id = '$pkusu_id', fkusu_rol_id = '$fkusu_rol_id', usu_nombre = '$usu_nombre', usu_correo = '$usu_correo', usu_clave = '$usu_clave', usu_imagen = '$usu_imagen'
				WHERE pkusu_id='$pkusu_id'");
			} else {
				$result = pg_query($this->dbConnection,
				"UPDATE usuario
				SET pkusu_id = '$pkusu_id', fkusu_rol_id = '$fkusu_rol_id', usu_nombre = '$usu_nombre', usu_correo = '$usu_correo', usu_clave = '$usu_clave', usu_imagen = NULL
				WHERE pkusu_id='$pkusu_id'");
			}
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}
		
		function deleteUsuario($id) {
			$result = pg_query($this->dbConnection,
				"DELETE FROM usuario WHERE pkusu_id='$id'");
			if (pg_last_error()) {
				return $this->result_construct("error",pg_last_error());
			} else {
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}
		
		function getRoles(){
			$result = pg_query($this->dbConnection,
			"SELECT * FROM rol");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE TELEFONO									*
		*																														*
		************************************************************/
		function updateTelefono($id, $tel_codigo, $tel_numero){
			$result = pg_query($this->dbConnection,
			"UPDATE telefono
			SET tel_codigo='$tel_codigo', tel_numero='$tel_numero'
			WHERE fktel_pro_id='$id' OR fktel_ent_id='$id' OR fktel_jin_id='$id' OR fktel_caba_id='$id' OR fktel_inv_id='$id' OR fktel_taqu_id='$id' OR fktel_vet_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE HARA											*
		*																														*
		************************************************************/
		function getHaras(){
			$result = pg_query($this->dbConnection,
			"SELECT * FROM hara");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE PELAJE										*
		*																														*
		************************************************************/
		function getPelajes(){
			$result = pg_query($this->dbConnection,
			"SELECT * FROM pelaje");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE RAZA											*
		*																														*
		************************************************************/
		function getRazas(){
			$result = pg_query($this->dbConnection,
			"SELECT * FROM raza");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}

		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE APUESTAS									*
		*																														*
		************************************************************/
		function getApuestas(){
			$result = pg_query($this->dbConnection,
			"SELECT a.*, j.jug_nombre, e.eje_nombre, t.taq_nombre
			FROM apuesta a, corredor c, jugada j, taquilla t, ejemplar e
			WHERE a.fkapu_cor_id = c.pkcor_id AND a.fkapu_jug_id = j.pkjug_id AND a.fkapu_taq_id = t.pktaq_id AND c.fkcor_eje_id = e.pkeje_id
			ORDER BY a.pkapu_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		function getApuestaById($pkapu_id) {
			$result = pg_query($this->dbConnection,
			"SELECT a.*, j.jug_nombre, e.eje_nombre, t.taq_nombre
			FROM apuesta a, corredor c, jugada j, taquilla t, ejemplar e
			WHERE a.fkapu_cor_id = c.pkcor_id AND a.fkapu_jug_id = j.pkjug_id AND a.fkapu_taq_id = t.pktaq_id AND c.fkcor_eje_id = e.pkeje_id AND pkapu_id = '$pkapu_id'");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		function getApuestaByFactura($pkfac_id) {
			$result = pg_query($this->dbConnection,
			"SELECT a.*, j.jug_nombre, e.eje_nombre, t.taq_nombre
			FROM apuesta a, corredor c, jugada j, taquilla t, ejemplar e
			WHERE a.fkapu_cor_id = c.pkcor_id AND a.fkapu_jug_id = j.pkjug_id AND a.fkapu_taq_id = t.pktaq_id AND c.fkcor_eje_id = e.pkeje_id AND a.fkapu_fac_id = '$pkfac_id'
			ORDER BY a.pkapu_id");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		function updateApuesta($pkapu_id, /*$fkapu_cor_id,*/ $fkapu_jug_id, /*$fkapu_fac_id, */$fkapu_taq_id, $apu_monto, $apu_lugar_llegada){
			if (!empty($apu_lugar_llegada)) { 
				$result = pg_query($this->dbConnection,
				"UPDATE apuesta
				SET fkapu_jug_id='$fkapu_jug_id', fkapu_taq_id='$fkapu_taq_id', apu_monto='$apu_monto', apu_lugar_llegada='$apu_lugar_llegada'
				WHERE pkapu_id='$pkapu_id'");
			} else {
				$result = pg_query($this->dbConnection,
				"UPDATE apuesta
				SET fkapu_jug_id='$fkapu_jug_id', fkapu_taq_id='$fkapu_taq_id', apu_monto='$apu_monto', apu_lugar_llegada=NULL
				WHERE pkapu_id='$pkapu_id'");
			}
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}/*fkapu_cor_id='$fkapu_cor_id',*/ /* fkapu_fac_id='$fkapu_fac_id',  */

		function deleteApuestaByFactura($pkfac_id) {
			$result = pg_query($this->dbConnection,
				"DELETE FROM apuesta WHERE fkapu_fac_id='$pkfac_id'");
			if (pg_last_error()) {
				return $this->result_construct("error",pg_last_error());
			} else {
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}
		
		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE JUGADAS									*
		*																														*
		************************************************************/
		function getJugadas(){
			$result = pg_query($this->dbConnection,
			"SELECT * FROM jugada");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE TAQUILLAS								*
		*																														*
		************************************************************/
		function getTaquillas(){
			$result = pg_query($this->dbConnection,
			"SELECT * FROM taquilla");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE CORREDORES								*
		*																														*
		************************************************************/
		function getCorredores(){
			$result = pg_query($this->dbConnection,
			"SELECT c.pkcor_id, e.eje_nombre, j.jin_primer_apellido || ', ' || j.jin_primer_nombre as jinete
			FROM corredor c, ejemplar e, jinete j
			WHERE c.fkcor_eje_id = e.pkeje_id AND c.fkcor_jin_id = j.pkjin_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE CARRERAS									*
		*																														*
		************************************************************/
		function getCarreras(){
			$result = pg_query($this->dbConnection,
			"SELECT c.*, h.hor_inicio FROM carrera c, horario h 
			WHERE c.fkcar_hor_id = h.pkhor_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		
		
		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE CABALLERIZA							*
		*																														*
		************************************************************/
		function getCaballerizas(){
			$result = pg_query($this->dbConnection,
			"SELECT c.pkcab_id, c.cab_descripcion, ca.caba_primer_apellido || ', ' || ca.caba_primer_nombre as caballerizo, v.vet_primer_apellido || ', ' || v.vet_primer_nombre as veterinario, cab_descripcion
			FROM caballeriza c, caballerizo ca, veterinario v
			WHERE c.fkcab_vet_id = v.pkvet_id AND c.fkcab_caba_id = ca.pkcaba_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		// function getCaballerizaById(){
		// 	$result = pg_query($this->dbConnection,
		// 	"SELECT c.pkcab_id, ca.caba_primer_apellido || ', ' || ca.caba_primer_nombre as caballerizo, v.vet_primer_apellido || ', ' || v.vet_primer_nombre as veterinario, cab_descripcion
		// 	FROM caballeriza c, caballerizo ca, veterinario v
		// 	WHERE c.fkcab_vet_id = v.pkvet_id AND c.fkcab_caba_id = ca.pkcaba_id AND ");
		// 	if(pg_last_error()){
		// 		return $this->result_construct("error",pg_last_error());
		// 	}
		// 	else {
		// 		$respuesta = array();
		// 		while($row = pg_fetch_assoc($result)){
		// 			$respuesta[] = $row;
		// 		}
		// 		return json_encode($respuesta);
		// 	}
		// }
		
		function deleteCaballeriza($id) {
			$result = pg_query($this->dbConnection,
				"DELETE FROM caballeriza WHERE pkcab_id='$id'");
			if (pg_last_error()) {
				return $this->result_construct("error",pg_last_error());
			} else {
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}
		
		
		
		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE INSCRIPCIÓN							*
		*																														*
		************************************************************/
		function createInscripcion($fkins_car_id, $fkins_cor_id, $ins_valor, $ins_gualdrapa, $ins_puesto_partida, $ins_favorito){
			if (!empty($ins_favorito)) {
				$result = pg_query($this->dbConnection,
				"INSERT INTO inscripcion VALUES(nextval('inscripcion_pkins_id_seq'::regclass), '$fkins_car_id', '$fkins_cor_id', '$ins_valor', '$ins_gualdrapa', '$ins_puesto_partida', '$ins_favorito')");
			} else {
				$result = pg_query($this->dbConnection,
				"INSERT INTO inscripcion VALUES(nextval('inscripcion_pkins_id_seq'::regclass), '$fkins_car_id', '$fkins_cor_id', '$ins_valor', '$ins_gualdrapa', '$ins_puesto_partida', NULL)");
			}
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}
		
		function getInscripciones(){
			$result = pg_query($this->dbConnection,
			"SELECT i.*, c.car_fecha, h.hor_inicio, string_agg(m.mod_nombre, ',') as lote, c.car_orden, d.dis_metros, 
			j.jin_primer_apellido || ', ' || j.jin_primer_nombre as jinete, e.eje_nombre
			FROM carrera c, horario h, modalidad_carrera mc, modalidad m, distancia d, inscripcion i, corredor co, jinete j, ejemplar e
			WHERE c.fkcar_hor_id = h.pkhor_id AND c.pkcar_id = mc.fkmodcar_car_id AND mc.fkmodcar_mod_id = m.pkmod_id AND c.fkcar_dis_id = d.pkdis_id AND 
			i.fkins_car_id = c.pkcar_id AND co.pkcor_id = i.fkins_cor_id AND co.fkcor_jin_id = j.pkjin_id AND co.fkcor_eje_id = e.pkeje_id
			GROUP BY pkins_id, pkcar_id, hor_inicio, h.hor_fin, dis_metros, co.pkcor_id, pkjin_id, pkeje_id
			ORDER BY pkcar_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		function getInscripcionById($pkins_id) {
			$result = pg_query($this->dbConnection,
			"SELECT * FROM inscripcion WHERE pkins_id = '$pkins_id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		function updateInscripcion($pkins_id, $fkins_car_id, $fkins_cor_id, $ins_valor, $ins_gualdrapa, $ins_puesto_partida, $ins_favorito){
			if (!empty($ins_favorito)) {
				$result = pg_query($this->dbConnection,
				"UPDATE inscripcion
				SET fkins_car_id='$fkins_car_id', fkins_cor_id='$fkins_cor_id', ins_valor='$ins_valor', ins_gualdrapa='$ins_gualdrapa', ins_puesto_partida='$ins_puesto_partida', ins_favorito='$ins_favorito'
				WHERE pkins_id='$pkins_id'");
			} else {
				$result = pg_query($this->dbConnection,
				"UPDATE inscripcion
				SET fkins_car_id='$fkins_car_id', fkins_cor_id='$fkins_cor_id', ins_valor='$ins_valor', ins_gualdrapa='$ins_gualdrapa', ins_puesto_partida='$ins_puesto_partida', ins_favorito=NULL
				WHERE pkins_id='$pkins_id'");
			}
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}
		
		function deleteInscripcion($id) {
			$result = pg_query($this->dbConnection,
				"DELETE FROM inscripcion WHERE pkins_id='$id'");
			if (pg_last_error()) {
				return $this->result_construct("error",pg_last_error());
			} else {
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}
		
		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE CARRERAS									*
		*																														*
		************************************************************/
		function getFacturasByApuesta(){
			$result = pg_query($this->dbConnection,
			"SELECT f.*
			FROM factura f, apuesta a
			WHERE a.fkapu_fac_id = f.pkfac_id
			GROUP BY f.pkfac_id
			ORDER BY f.pkfac_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta[] = $row;
				}
				return json_encode($respuesta);
			}
		}
		
		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE BOXES										*
		*																														*
		************************************************************/
		function getBoxByCaballeriza() {
			$result = pg_query($this->dbConnection,
			"SELECT * FROM boxe WHERE fkbox_cab_id = '$_POST[id]'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}	else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					if ($row[pkbox_id]==$_POST[pkbox_id]) {
						$respuesta .= "<option selected value='$row[pkbox_id]'>$row[box_descripcion] </option>";
					} else {
						$respuesta .= "<option value='$row[pkbox_id]'>$row[box_descripcion] </option>";
					}
				}
				return json_encode($respuesta, JSON_UNESCAPED_UNICODE);
			}
		}
	}
?>