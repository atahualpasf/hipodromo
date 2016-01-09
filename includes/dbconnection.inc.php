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
		*					 FUNCIONES GENÉRICAS DE LA APLICACIÓN				  		*
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

		/************************************************************
		*																														*
		*					 	FUNCIONES GENÉRICAS DE PROPIETARIOS					  	*
		*																														*
		************************************************************/
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

		function getPropietarioById($pkent_id) {
			$result = pg_query($this->dbConnection,
			"SELECT *	FROM propietario WHERE pkent_id = '$pkent_id'");

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
		*					 	FUNCIONES GENÉRICAS DE ENTRENADORES					  	*
		*																														*
		************************************************************/
		function getEntrenadores() {
			$result = pg_query($this->dbConnection,
			"SELECT ent.*, p.lug_nombre as parroquia, e.lug_nombre as estado
			FROM entrenador ent, lugar p, lugar m, lugar e WHERE ent.fkent_lug_id = p.pklug_id AND p.fklug_lug_id = m.pklug_id AND m.fklug_lug_id = e.pklug_id");

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
			"SELECT *	FROM entrenador WHERE pkent_id = '$pkent_id'");

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
		*					 	FUNCIONES GENÉRICAS DE JINETES							  	*
		*																														*
		************************************************************/
		function getJinetes() {
			$result = pg_query($this->dbConnection,
			"SELECT j.*, p.lug_nombre as parroquia, e.lug_nombre as estado
			FROM jinete j, lugar p, lugar m, lugar e WHERE j.fkjin_lug_id = p.pklug_id AND p.fklug_lug_id = m.pklug_id AND m.fklug_lug_id = e.pklug_id");

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
			"SELECT *	FROM jinete WHERE pkjin_id = '$pkjin_id'");

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
		*					 		  FUNCIONES GENÉRICAS DE STUDS					  		*
		*																														*
		************************************************************/
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
		*					 		  FUNCIONES GENÉRICAS DE GORRA					  		*
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
		*					 		FUNCIONES GENÉRICAS DE CHAQUETA					  		*
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
		*					 	FUNCIONES GENÉRICAS DE EJEMPLARES					  		*
		*																														*
		************************************************************/
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



		/************************************************************
		*																														*
		*					 FUNCIONES GENÉRICAS DE IMPLEMENTOS					  		*
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
		*					 FUNCIONES GENÉRICAS DE USUARIOS						  		*
		*																														*
		************************************************************/
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
	}
?>