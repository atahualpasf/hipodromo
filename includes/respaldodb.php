<?php
	session_start();
	class Database{
		private $dbConnection = null;
		private $_SITE_ROOT;
		
		function __construct(){
			$this->_SITE_ROOT = $_SERVER['DOCUMENT_ROOT'];
			include_once($this->_SITE_ROOT."/config.inc.php");
			$this->dbConnection = pg_connect($strConnection);
		}
		
		
		/************************************************************
		*															*
		*			FUNCIONES GENÉRICAS DE POSTGRESQL				*
		*															*
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
			$result = json_encode($result);
			return $result;
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

		function getOficinasGeneral(){	
			$result = pg_query($this->dbConnection,"SELECT o.pkofi_id, o.ofi_nombre FROM oficina o order by o.pkofi_id");
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
		
		function getHorarios(){	
			$result = pg_query($this->dbConnection,"SELECT h.* FROM horario h ORDER BY h.pkhor_id");
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

		function getHorarioById($id){	
			$result = pg_query($this->dbConnection,
			"SELECT h.* 
			FROM horario h 
			WHERE f.pkhor_id = $id
			ORDER BY h.pkhor_id");
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

		function getEdificiosGeneral(){	
			$result = pg_query($this->dbConnection,"SELECT e.pkedi_id, e.edi_nombre FROM edificio e order by e.pkedi_id");
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

		function getAdministradoras(){	
			$result = pg_query($this->dbConnection,
			"SELECT a.*
			FROM administradora a
			ORDER BY a.pkadm_id");
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

		function getAsambleasGeneral(){
			$result = pg_query($this->dbConnection,
			"SELECT a.*
			FROM asamblea a 
			ORDER BY a.pkasa_id");

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

		function getUnidadTributaria(){
			$result = pg_query($this->dbConnection,
			"SELECT ut.*
			FROM unidad_tributaria ut 
			ORDER BY ut.pkunitri_id");

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

		function getReparacionesGeneral(){
			$result = pg_query($this->dbConnection,
			"SELECT r.*
			FROM reparacion r 
			ORDER BY r.pkrep_id");

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

		function getProveedoresGeneral(){
			$result = pg_query($this->dbConnection,
			"SELECT p.*
			FROM proveedor p 
			ORDER BY p.pkprov_id");

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

		function getMantenimientosGeneral(){
			$result = pg_query($this->dbConnection,
			"SELECT m.*
			FROM mantenimiento m
			ORDER BY m.pkman_id");

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

		function getInsumosGeneral(){
			$result = pg_query($this->dbConnection,
			"SELECT i.*
			FROM insumo i 
			ORDER BY i.pkinsu_id");

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

		function getEdificiosServiciosBasicos(){
			$result = pg_query($this->dbConnection,
			"SELECT esb.pkediserbas_id, sb.*
			FROM edificio_servicio_basico esb, servicio_basico sb
			WHERE esb.fkserbas_ediserbas_id = sb.pkserbas_id
			ORDER BY sb.pkserbas_id");

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

		function getRecibosDetallados($id, $fac_fecha_inicio, $fac_fecha_fin){
			if (empty($fac_fecha_inicio)) {
				$fac_fecha_inicio = '2015-01-01';
			}
			if (empty($fac_fecha_fin)) {
				$fac_fecha_fin = '2015-12-31';
			}
			$result = pg_query($this->dbConnection,
			"SELECT (SELECT man_descripcion
					FROM 	mantenimiento man, edificio_instalacion ediins 
					WHERE 	man.fkediins_man_id = ediins.pkediins_id and ediins.fkedi_ediins_id = edi.pkedi_id and fac.fkman_fac_id = man.pkman_id),
					(SELECT rep_descripcion
					FROM 	reparacion rep, evaluacion_diagnostico evadia 
					WHERE 	rep.fkevadia_rep_id = evadia.pkevadia_id and evadia.fkedi_evadia_id = edi.pkedi_id and fac.fkman_fac_id = rep.pkrep_id),
					(SELECT serbas_nombre
					FROM 	servicio_basico serbas, edificio_servicio_basico ediserbas 
					WHERE 	ediserbas.fkserbas_ediserbas_id = serbas.pkserbas_id and ediserbas.fkedi_ediserbas_id = edi.pkedi_id and fac.fkediserbas_fac_id = ediserbas.pkediserbas_id),
					(SELECT insu_nombre
					FROM 	insumo insu 
					WHERE 	insu.fkedi_insu_id = edi.pkedi_id and fac.fkinsu_fac_id = insu.pkinsu_id),
					edi.edi_nombre, fac.fac_fecha, fac.fac_monto_total, pro.pro_primer_nombre, pro.pro_primer_apellido, 
					edi.edi_nombre, apa.apa_nombre, pis.pis_nombre, apa.apa_alicuota, fac_monto_total * apa_alicuota as cuota_parte
			FROM 	edificio edi, factura fac, apartamento apa, propietario_apartamento proapa, propietario pro, piso pis
			WHERE 	proapa.pkproapa_id = '$id' and proapa.fkpro_proapa_id = pro.pkpro_id and proapa.fkapa_proapa_id = apa.pkapa_id and
			 		apa.fkpis_apa_id = pis.pkpis_id and pis.fkedi_pis_id = edi.pkedi_id and 
			 		((EXISTS 	(SELECT man_descripcion
			 					FROM 	mantenimiento man, edificio_instalacion ediins 
			 					WHERE 	man.fkediins_man_id = ediins.pkediins_id and ediins.fkedi_ediins_id = edi.pkedi_id and fac.fkman_fac_id = man.pkman_id)) or 
			 		(EXISTS 	(SELECT rep_descripcion
								FROM 	reparacion rep, evaluacion_diagnostico evadia 
								WHERE 	rep.fkevadia_rep_id = evadia.pkevadia_id and evadia.fkedi_evadia_id = edi.pkedi_id and fac.fkman_fac_id = rep.pkrep_id)) or 
					(EXISTS 	(SELECT serbas_nombre
								FROM 	servicio_basico serbas, edificio_servicio_basico ediserbas 
								WHERE 	ediserbas.fkserbas_ediserbas_id = serbas.pkserbas_id and ediserbas.fkedi_ediserbas_id = edi.pkedi_id and fac.fkediserbas_fac_id = ediserbas.pkediserbas_id)) or 
					(EXISTS 	(SELECT insu_nombre
								FROM 	insumo insu 
								WHERE 	insu.fkedi_insu_id = edi.pkedi_id and fac.fkinsu_fac_id = insu.pkinsu_id))) and 
								fac.fac_fecha between date '$fac_fecha_inicio' and date '$fac_fecha_fin'");

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

		function getCoordenadasEdificio($pkedi_id) {			
			$result = pg_query($this->dbConnection,
			"SELECT c.coor_cordenada_x, c.coor_cordenada_y, e.edi_nombre, est.lug_nombre, m.lug_nombre, p.lug_nombre
			FROM coordenada c, edificio e, lugar p, lugar m, lugar est
			WHERE c.fkedi_coor_id = e.pkedi_id and e.fklug_edi_id = p.pklug_id and p.fklug_lug_id = m.pklug_id and m.fklug_lug_id = est.pklug_id and e.pkedi_id = $pkedi_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$row = pg_fetch_row($result);
				return $this->result_construct("success",$row);
			}
		}

		function getTotalTrabajosProveedor() {			
			$result = pg_query($this->dbConnection,
			"SELECT 	p.prov_nombre, (
						SELECT	COUNT(pre.fkrep_pre_id) as total_trabajos_realizados
						FROM 	presupuesto pre
						WHERE	pre.fkprov_pre_id = p.pkprov_id and  pre.pre_estado = 'aprobado') 
			FROM		proveedor p
			ORDER BY 	p.prov_nombre");
			
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

		function getTotalGastosEdificio() {			
			$result = pg_query($this->dbConnection,
			"SELECT e.edi_nombre, (
					SELECT	SUM(sb.serbas_costo)
					FROM	edificio_servicio_basico esb, servicio_basico sb
					WHERE 	esb.fkedi_ediserbas_id = e.pkedi_id and esb.fkserbas_ediserbas_id = sb.pkserbas_id) as total_servicios, (
					SELECT	SUM(r.rep_monto) 
					FROM	edificio_instalacion ei, reparacion r
					WHERE 	ei.fkedi_ediins_id = e.pkedi_id and r.fkediins_rep_id = ei.pkediins_id) as total_trabajos
			FROM 	edificio e");
			
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

		function getTotalGananciaVentaApartamento($fecha_inicio,$fecha_fin) {			
			$result = pg_query($this->dbConnection,
			"SELECT SUM(v.ven_monto * v.ven_ganancia) as ganancia
			FROM 	venta v
			WHERE	v.ven_fecha BETWEEN date '$fecha_inicio' and date'$fecha_fin'");
			
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

		function getAreaConMasTrabajos($fecha_inicio,$fecha_fin) {			
			$result = pg_query($this->dbConnection,
			"SELECT 	i.ins_nombre, COUNT(r.*) as reparaciones_requeridas
			FROM		instalacion i, edificio_instalacion ei, reparacion r
			WHERE		ei.fkins_ediins_id = i.pkins_id and r.fkediins_rep_id = ei.pkediins_id and r.rep_fecha_inicio BETWEEN date '$fecha_inicio' and date'$fecha_fin'
			GROUP BY 	i.ins_nombre
			ORDER BY 	reparaciones_requeridas DESC");
			
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

		function getGastosMensuales($edificio,$propietario,$mes) {			
			$result = pg_query($this->dbConnection,
			"SELECT 	gm.descripcion, gm.monto, gm.cuota_parte, (
							SELECT 		SUM(gm1.monto) as total_monto
							FROM 		gasto_mensual gm1
							WHERE 		gm.edificio = gm1.edificio), (
							SELECT 		SUM(gm2.cuota_parte) as total_cuota_parte
							FROM 		gasto_mensual gm2
							WHERE 		gm.edificio = gm2.edificio)
			FROM 		edificio e, propietario_apartamento pa, apartamento a, propietario p, gasto_mensual gm
			WHERE 		e.pkedi_id = $edificio and e.pkedi_id = gm.edificio and a.fkedi_apa_id = e.pkedi_id and pa.fkapa_proapa_id = a.pkapa_id and pa.fkpro_proapa_id = p.pkpro_id and (gm.fecha = $mes or gm.fecha = '2015') and p.pkpro_id = $propietario
			GROUP BY 	gm.edificio, gm.descripcion, gm.monto, gm.cuota_parte");
			
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

		function getInformacionApartamento($edificio,$propietario) {			
			$result = pg_query($this->dbConnection,
			"SELECT apa.fkpis_apa_id, apa.apa_nombre, apa.apa_alicuota 
			FROM 	propietario_apartamento proapa, apartamento apa 
			WHERE 	proapa.fkapa_proapa_id = apa.pkapa_id and proapa.fkpro_proapa_id = '$propietario' and apa.fkedi_apa_id = '$edificio'");
			
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

		function getJuntaDeCondominioByEdificio($edificio) {			
			$result = pg_query($this->dbConnection,
			"SELECT jc.pkjuncon_id 
			FROM 	junta_condominio jc, edificio e
			WHERE 	jc.fkedi_juncon_id = e.pkedi_id and e.pkedi_id = $edificio");
			
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

		function getEgresos($edificio,$mes) {			
			$result = pg_query($this->dbConnection,
			"SELECT gm.descripcion as descripcion, gm.monto as monto_factura, (
					SELECT 	SUM(gm1.monto)
					FROM 	gasto_mensual gm1
					WHERE 	gm.edificio = gm1.edificio) as total_egreso
			FROM 	edificio e, gasto_mensual gm
			WHERE 	e.pkedi_id = $edificio and e.pkedi_id = gm.edificio and (gm.fecha = $mes or gm.fecha = 2015)");
			
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

		function getIngresos($edificio,$mes) {			
			$result = pg_query($this->dbConnection,
			"SELECT p.pro_primer_nombre || ' ' || p.pro_segundo_nombre || ' ' || p.pro_primer_apellido || ' ' || p.pro_segundo_apellido as nombre_propietario, r.rec_monto_total as monto_recibo, (
					SELECT 	SUM(r1.rec_monto_total)
					FROM 	recibo r1
					WHERE	r.pkrec_id = r1.pkrec_id) as total_ingreso
			FROM	recibo r, junta_condominio jc, edificio e, aviso_cobro ac, proapa_avicob paac, propietario_apartamento pa, propietario p
			WHERE 	r.fkavicob_rec_id = ac.pkavicob_id and ac.fkjuncon_avicob_id = jc.pkjuncon_id and jc.fkedi_juncon_id = e.pkedi_id and paac.fkavicob_proapa_avicob_id = ac.pkavicob_id and paac.fkproapa_proapa_avicob_id = pa.pkproapa_id and pa.fkpro_proapa_id = p.pkpro_id and e.pkedi_id = 1 and date_part('month', r.rec_fecha) = 1 and r.rec_estado = 'pagada'");
			
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
		*															*
		*			    FUNCIONES DE SQL DE USUARIOS				*
		*															*
		************************************************************/
		function registerUser($username,$email,$password,$rol) {			
			$result = pg_query($this->dbConnection,
			"INSERT INTO usuario (pkusu_id,fkusu_rol_id,usu_email,usu_username,usu_clave) 
			VALUES(nextval('usuario_pkusu_id_seq'::regclass), '$rol', '$email', '$username', '$password')");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			} else {
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

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

		function loginUsuario() {			
			$result = pg_query($this->dbConnection,
			"SELECT * FROM usuario");

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

		/************************************************************
		*															*
		*			    FUNCIONES DE SQL DE ASAMBLEAS				*
		*															*
		************************************************************/
		function getAsambleas(){
			$result = pg_query($this->dbConnection,
			"SELECT a.*, o.ofi_nombre, h.*
			FROM asamblea a LEFT JOIN oficina o ON a.fkofi_asa_id = o.pkofi_id, horario h
			WHERE a.fkhor_asa_id = h.pkhor_id
			ORDER BY a.pkasa_id");

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

		function getAsambleaById($id){
			$result = pg_query($this->dbConnection,
			"SELECT a.*, o.ofi_nombre, h.*
			FROM asamblea a LEFT JOIN oficina o ON a.fkofi_asa_id = o.pkofi_id, horario h
			WHERE a.pkasa_id = $id and a.fkhor_asa_id = h.pkhor_id
			ORDER BY a.pkasa_id");

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

		function addAsamblea($fkofi_asa_id, $fkhor_asa_id,$asa_tema,$asa_fecha,$asa_quorum,$asa_tipo){
			$result = pg_query($this->dbConnection,
			"INSERT INTO asamblea (pkasa_id,fkofi_asa_id,fkhor_asa_id,asa_tema,asa_fecha,asa_quorum, asa_tipo) 
			VALUES(nextval('asamblea_pkasa_id_seq'::regclass), '$fkofi_asa_id', '$fkhor_asa_id', '$asa_tema', '$asa_fecha', '$asa_quorum', '$asa_tipo')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->	result_construct("success","Agregado exitosamente");
			}
		}

		function updateAsamblea($id,$fkofi_asa_id, $fkhor_asa_id,$asa_tema,$asa_fecha,$asa_quorum,$asa_tipo){
			$result = pg_query($this->dbConnection,
			"UPDATE asamblea
			SET fkofi_asa_id='$fkofi_asa_id', fkhor_asa_id='$fkhor_asa_id', asa_tema='$asa_tema', asa_fecha='$asa_fecha', asa_quorum='$asa_quorum', asa_tipo='$asa_tipo'
			WHERE pkasa_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteAsamblea($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM asamblea WHERE pkasa_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*			    FUNCIONES DE SQL DE ASAMBLEAS				*
		*															*
		************************************************************/
		function addAvisoCobro($pkjuncon_id,$mes){
			$result = pg_query($this->dbConnection,
			"INSERT INTO aviso_cobro (pkavicob_id,fkjuncon_avicob_id,avicob_fecha,avicob_estado) 
			VALUES(nextval('aviso_cobro_pkavicob_id_seq'::regclass), '$pkjuncon_id', '2015-$mes-05', 'rechazado')
			RETURNING pkavicob_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				$row = pg_fetch_row($result);
				$id = $row['0'];
				return $this->result_construct("success",$id);
			}
		}


		function getProApaByPropietario($pkpro_id,$pkedi_id) {			
			$result = pg_query($this->dbConnection,
			"SELECT pa.pkproapa_id
			FROM 	propietario_apartamento pa, apartamento a, edificio e
			WHERE 	pa.fkpro_proapa_id = $pkpro_id and pa.fkapa_proapa_id = a.pkapa_id and a.fkedi_apa_id = e.pkedi_id and e.pkedi_id = $pkedi_id");
			
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

		function getAvisoCobroByProApaEdi($pkpro_id,$pkedi_id) {			
			$result = pg_query($this->dbConnection,
			"SELECT 	paac.*, date_part('month', ac.avicob_fecha) as ac_mes
			FROM 	apartamento a, edificio e, propietario_apartamento pa, proapa_avicob paac, aviso_cobro ac
			WHERE 	pa.fkpro_proapa_id = $pkpro_id and pa.fkapa_proapa_id = a.pkapa_id and a.fkedi_apa_id = e.pkedi_id and e.pkedi_id = $pkedi_id and paac.fkproapa_proapa_avicob_id = pa.pkproapa_id and paac.fkavicob_proapa_avicob_id = ac.pkavicob_id");
			
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

		function addPropietarioAvisoCobro($propietario,$aviso_cobro){
			$result = pg_query($this->dbConnection,
			"INSERT INTO proapa_avicob (pkproapa_avicob_id,fkproapa_proapa_avicob_id,fkavicob_proapa_avicob_id) 
			VALUES (nextval('proapa_avicob_pkproapa_avicob_id_seq'::regclass), '$propietario', '$aviso_cobro')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->	result_construct("success","Agregado exitosamente");
			}
		}

		function updateAvisoCobro($id){
			$result = pg_query($this->dbConnection,
			"UPDATE aviso_cobro
			SET 	avicob_estado = 'aprobado'
			WHERE 	pkavicob_id ='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		/************************************************************
		*															*
		*			FUNCIONES DE SQL DE CARTAS CONSULTA				*
		*															*
		************************************************************/
		function getCartasConsulta(){
			$result = pg_query($this->dbConnection,
			"SELECT cc.*, a.asa_quorum
			FROM carta_consulta cc LEFT JOIN asamblea a ON cc.fkasa_carcon_id = a.pkasa_id
			ORDER BY cc.pkcarcon_id");

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

		function getCartaConsultaById($id){
			$result = pg_query($this->dbConnection,
			"SELECT cc.*, a.asa_quorum
			FROM carta_consulta cc LEFT JOIN asamblea a ON cc.fkasa_carcon_id = a.pkasa_id
			WHERE cc.pkcarcon_id = $id
			ORDER BY cc.pkcarcon_id");

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

		function addCartaConsulta($carcon_tema, $carcon_fecha,$fkasa_carcon_id){
			$result = pg_query($this->dbConnection,
			"INSERT INTO carta_consulta (pkcarcon_id,carcon_tema,carcon_fecha,fkasa_carcon_id) 
			VALUES(nextval('carta_consulta_pkcarcon_id_seq'::regclass), '$carcon_tema', '$carcon_fecha', '$fkasa_carcon_id')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->	result_construct("success","Agregado exitosamente");
			}
		}

		function updateCartaConsulta($id,$carcon_tema, $carcon_fecha,$fkasa_carcon_id){
			$result = pg_query($this->dbConnection,
			"UPDATE carta_consulta
			SET carcon_tema='$carcon_tema', carcon_fecha='$carcon_fecha', fkasa_carcon_id='$fkasa_carcon_id'
			WHERE pkcarcon_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteCartaConsulta($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM carta_consulta WHERE pkcarcon_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*               FUNCIONES DE SQL DE CONTRATOS				*
		*															*
		************************************************************/
		function getContratos(){
			$result = pg_query($this->dbConnection,
			"SELECT c.*, a.adm_nombre, e.edi_nombre
			FROM contrato c, administradora a, edificio e
			WHERE c.fkadm_con_id = a.pkadm_id and c.fkedi_con_id = e.pkedi_id
			ORDER BY c.pkcon_id");

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

		function getContratoById($id){
			$result = pg_query($this->dbConnection,
			"SELECT c.*, a.adm_nombre, e.edi_nombre
			FROM contrato c, administradora a, edificio e
			WHERE c.pkcon_id = $id and c.fkadm_con_id = a.pkadm_id and c.fkedi_con_id = e.pkedi_id
			ORDER BY c.pkcon_id");

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

		function addContrato($fkedi_con_id, $fkadm_con_id, $con_fecha_inicio, $con_interes_mora, $con_llamada_asamblea, $con_trabajo_alto_valor, $con_quorum_asamblea, $con_fecha_vencimiento, $con_derecho_voto_mora, $con_supervision_trabajos, $con_mantenimiento_programado, $con_porcentaje_caja_chica, $fkunitri_con_id){
			$result = pg_query($this->dbConnection,
			"INSERT INTO contrato (pkcon_id, fkedi_con_id, fkadm_con_id, con_fecha_inicio, con_interes_mora, con_llamada_asamblea, con_trabajo_alto_valor, con_quorum_asamblea, con_fecha_vencimiento, con_derecho_voto_mora, con_supervision_trabajos, con_mantenimiento_programado, con_porcentaje_caja_chica, fkunitri_con_id) 
			VALUES (nextval('contrato_pkcon_id_seq'::regclass), '$fkedi_con_id', '$fkadm_con_id', '$con_fecha_inicio', '$con_interes_mora', '$con_llamada_asamblea', '$con_trabajo_alto_valor', '$con_quorum_asamblea', '$con_fecha_vencimiento', '$con_derecho_voto_mora', '$con_supervision_trabajos', '$con_mantenimiento_programado', '$con_porcentaje_caja_chica', '$fkunitri_con_id')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateContrato($id,$fkedi_con_id, $fkadm_con_id, $con_fecha_inicio, $con_interes_mora, $con_llamada_asamblea, $con_trabajo_alto_valor, $con_quorum_asamblea, $con_fecha_vencimiento, $con_derecho_voto_mora, $con_supervision_trabajos, $con_mantenimiento_programado, $con_porcentaje_caja_chica, $fkunitri_con_id){
			$result = pg_query($this->dbConnection,
			"UPDATE contrato
			SET fkedi_con_id='$fkedi_con_id', fkadm_con_id='$fkadm_con_id', con_fecha_inicio='$con_fecha_inicio', con_interes_mora='$con_interes_mora', con_llamada_asamblea='$con_llamada_asamblea', con_trabajo_alto_valor='$con_trabajo_alto_valor', con_quorum_asamblea='$con_quorum_asamblea', con_fecha_vencimiento='$con_fecha_vencimiento', con_derecho_voto_mora='$con_derecho_voto_mora', con_supervision_trabajos='$con_supervision_trabajos', con_mantenimiento_programado='$con_mantenimiento_programado', con_porcentaje_caja_chica='$con_porcentaje_caja_chica', fkunitri_con_id='$fkunitri_con_id'
			WHERE pkcon_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteContrato($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM contrato WHERE pkcon_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*               FUNCIONES DE SQL DE EDIFICIOS				*
		*															*
		************************************************************/
		function getEdificios(){
			$result = pg_query($this->dbConnection,
			"SELECT e.*, 	(SELECT COUNT(p.pkpis_id)
							FROM piso p
							WHERE p.fkedi_pis_id = e.pkedi_id) as pisos, 	
							(SELECT COUNT(a.pkapa_id)
							FROM apartamento a
							WHERE a.fkedi_apa_id = e.pkedi_id) as apartamentos, 
							est.lug_nombre as estado, m.lug_nombre as municipio, par.lug_nombre as parroquia
			FROM edificio e, lugar est, lugar m, lugar par
			WHERE e.fklug_edi_id = par.pklug_id and par.fklug_lug_id = m.pklug_id and m.fklug_lug_id = est.pklug_id 
			ORDER BY e.pkedi_id");

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

		function getEdificioById($id){
			$result = pg_query($this->dbConnection,
			"SELECT e.*, 	(SELECT COUNT(p.pkpis_id)
							FROM piso p
							WHERE p.fkedi_pis_id = e.pkedi_id) as pisos, 	
							(SELECT COUNT(a.pkapa_id)
							FROM apartamento a
							WHERE a.fkedi_apa_id = e.pkedi_id) as apartamentos 
			FROM edificio e
			WHERE e.pkedi_id = $id 
			ORDER BY e.pkedi_id");

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

		function addEdificio($fklug_edi_id, $edi_rif, $edi_nombre, $edi_tipo){
			$result = pg_query($this->dbConnection,
			"INSERT INTO edificio (pkedi_id, fklug_edi_id, edi_rif, edi_nombre, edi_tipo) 
			VALUES (nextval('edificio_pkedi_id_seq'::regclass), '$fklug_edi_id', '$edi_rif', '$edi_nombre', '$edi_tipo')
			RETURNING pkedi_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				$row = pg_fetch_row($result);
				$id = $row['0'];
				return $this->result_construct("success",$id);
			}
		}

		function addPiso($fkedi_pis_id, $pis_nombre){
			$result = pg_query($this->dbConnection,
			"INSERT INTO piso (pkpis_id, fkedi_pis_id, pis_nombre) 
			VALUES (nextval('piso_pkpis_id_seq'::regclass), '$fkedi_pis_id', '$pis_nombre') RETURNING pkpis_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				$row = pg_fetch_row($result);
				$id = $row['0'];
				return $this->result_construct("success",$id);
			}
		}

		function addApartamento($fkedi_apa_id, $fkpis_apa_id, $apa_nombre, $apa_alicuota){
			$result = pg_query($this->dbConnection,
			"INSERT INTO apartamento (pkapa_id, fkedi_apa_id, fkpis_apa_id, apa_nombre, apa_alicuota) 
			VALUES (nextval('apartamento_pkapa_id_seq'::regclass), '$fkedi_apa_id','$fkpis_apa_id', '$apa_nombre', '$apa_alicuota')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateEdificio($id,$fklug_edi_id, $edi_rif, $edi_nombre, $edi_tipo){
			$result = pg_query($this->dbConnection,
			"UPDATE edificio
			SET fklug_edi_id='$fklug_edi_id', edi_rif='$edi_rif', edi_nombre='$edi_nombre', edi_tipo='$edi_tipo'
			WHERE pkedi_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function updatePiso($id,$fkedi_pis_id, $pis_nombre){
			$result = pg_query($this->dbConnection,
			"UPDATE piso
			SET fkedi_pis_id='$fkedi_pis_id', pis_nombre='$pis_nombre'
			WHERE pkpis_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function updateApartamento($id,$fkapa_edi_id, $fkpis_apa_id, $apa_nombre, $apa_alicuota){
			$result = pg_query($this->dbConnection,
			"UPDATE apartamento
			SET fkapa_edi_id='$fkapa_edi_id', fkpis_apa_id='$fkpis_apa_id', apa_nombre='$apa_nombre', apa_alicuota='$apa_alicuota'
			WHERE pkapa_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteEdificio($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM edificio WHERE pkedi_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		function getEdificioByIdg($id){
			$result = pg_query($this->dbConnection,
			"SELECT e.*, 	(SELECT COUNT(p.pkpis_id)
							FROM piso p
							WHERE p.fkedi_pis_id = e.pkedi_id) as pisos, 	
							(SELECT COUNT(a.pkapa_id)
							FROM apartamento a
							WHERE a.fkedi_apa_id = e.pkedi_id) as apartamentos 
			FROM edificio e
			WHERE e.pkedi_id = $id 
			ORDER BY e.pkedi_id");

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
		*															*
		*				FUNCIONES DE SQL DE EMPLEADOS				*
		*															*
		************************************************************/
		function getEmpleados(){
			$result = pg_query($this->dbConnection,
			"SELECT e.*, o.ofi_nombre as oficina, est.lug_nombre as estado, m.lug_nombre as municipio, p.lug_nombre as parroquia
			FROM empleado e, lugar m, lugar est, lugar p, oficina o
			WHERE e.fkofi_emp_id = o.pkofi_id and e.fklug_emp_id = p.pklug_id and p.fklug_lug_id = m.pklug_id and m.fklug_lug_id = est.pklug_id
			order by pkemp_id");

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

		function getEmpleadoById($id){
			$result = pg_query($this->dbConnection,
			"SELECT e.*, o.ofi_nombre as oficina, est.lug_nombre as estado, m.lug_nombre as municipio, p.lug_nombre as parroquia
			FROM empleado e, lugar m, lugar est, lugar p, oficina o
			WHERE e.fkofi_emp_id = o.pkofi_id and e.pkemp_id = $id and e.fklug_emp_id = p.pklug_id and p.fklug_lug_id = m.pklug_id and m.fklug_lug_id = est.pklug_id
			order by pkemp_id");

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

		function addEmpleado($fklug_emp_id, $fkofi_emp_id,$emp_cedula,$emp_primer_nombre,$emp_segundo_nombre,$emp_primer_apellido,$emp_segundo_apellido,$emp_telefono,$emp_correo,$emp_salario,$emp_cargo){
			$result = pg_query($this->dbConnection,
			"INSERT INTO empleado (pkemp_id,fklug_emp_id,fkofi_emp_id,emp_cedula,emp_primer_nombre,emp_segundo_nombre,
			emp_primer_apellido,emp_segundo_apellido,emp_telefono,emp_correo,emp_salario,emp_cargo) values(nextval('empleado_pkemp_id_seq'::regclass),
			'$fklug_emp_id', '$fkofi_emp_id', '$emp_cedula', '$emp_primer_nombre', '$emp_segundo_nombre', '$emp_primer_apellido', '$emp_segundo_apellido',
			'$emp_telefono', '$emp_correo', '$emp_salario', '$emp_cargo')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->	result_construct("success","Agregado exitosamente");
			}
		}

		function updateEmpleado($id,$fklug_emp_id,$fkofi_emp_id,$emp_cedula,$emp_primer_nombre,$emp_segundo_nombre,$emp_primer_apellido,$emp_segundo_apellido,$emp_telefono,$emp_correo,$emp_salario,$emp_cargo){
			$result = pg_query($this->dbConnection,
			"UPDATE empleado 
			SET fklug_emp_id='$fklug_emp_id', fkofi_emp_id='$fkofi_emp_id', emp_cedula='$emp_cedula', emp_primer_nombre='$emp_primer_nombre', 
			emp_segundo_nombre='$emp_segundo_nombre', emp_primer_apellido='$emp_primer_apellido', emp_segundo_apellido='$emp_segundo_apellido', 
			emp_telefono='$emp_telefono', emp_correo='$emp_correo', emp_salario='$emp_salario', emp_cargo='$emp_cargo'
			WHERE pkemp_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteEmpleado($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM empleado WHERE pkemp_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*               FUNCIONES DE SQL DE FACTURAS				*
		*															*
		************************************************************/
		function getFacturas(){
			$result = pg_query($this->dbConnection,
			"SELECT f.*, 	(SELECT insu_nombre
							FROM insumo 
							WHERE f.fkinsu_fac_id = pkinsu_id),
							(SELECT man_descripcion
							FROM mantenimiento 
							WHERE f.fkman_fac_id = pkman_id),
							(SELECT serbas_nombre
							FROM edificio_servicio_basico, servicio_basico 
							WHERE pkediserbas_id = f.fkediserbas_fac_id and fkserbas_ediserbas_id = pkserbas_id),
							(SELECT rep_descripcion
							FROM reparacion 
							WHERE pkrep_id = f.fkrep_fac_id)
			FROM factura f");

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

		function getFacturaById($id){
			$result = pg_query($this->dbConnection,
			"SELECT f.*, 	(SELECT insu_nombre
							FROM insumo 
							WHERE f.fkinsu_fac_id = pkinsu_id), 
							(SELECT man_descripcion
							FROM mantenimiento 
							WHERE f.fkman_fac_id = pkman_id), 
							(SELECT serbas_nombre
							FROM edificio_servicio_basico, servicio_basico 
							WHERE pkediserbas_id = f.fkediserbas_fac_id and fkserbas_ediserbas_id = pkserbas_id), 
							(SELECT rep_descripcion
							FROM reparacion 
							WHERE pkrep_id = f.fkrep_fac_id)
			FROM factura f
			WHERE f.pkfac_id = $id");

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

		function updateFactura($id, $fkman_fac_id, $fkrep_fac_id, $fkediserbas_fac_id, $fac_fecha, $fac_iva, $fac_monto_total, $fac_estado, $fkinsu_fac_id){
			if (!empty($fkrep_fac_id)) {
				$result = pg_query($this->dbConnection,
				"UPDATE factura 
				SET fkman_fac_id =NULL, fkrep_fac_id ='$fkrep_fac_id', fkediserbas_fac_id =NULL, fac_fecha ='$fac_fecha', fac_iva ='$fac_iva', fac_monto_total ='$fac_monto_total', fac_estado ='$fac_estado', fkinsu_fac_id =NULL
				WHERE pkfac_id='$id'");
			} elseif (!empty($fkman_fac_id)) {
				$result = pg_query($this->dbConnection,
				"UPDATE factura 
				SET fkman_fac_id ='$fkman_fac_id', fkrep_fac_id =NULL, fkediserbas_fac_id =NULL, fac_fecha ='$fac_fecha', fac_iva ='$fac_iva', fac_monto_total ='$fac_monto_total', fac_estado ='$fac_estado', fkinsu_fac_id =NULL
				WHERE pkfac_id='$id'");
			} elseif (!empty($fkediserbas_fac_id)) {
				$result = pg_query($this->dbConnection,
				"UPDATE factura 
				SET fkman_fac_id =NULL, fkrep_fac_id =NULL, fkediserbas_fac_id ='$fkediserbas_fac_id', fac_fecha ='$fac_fecha', fac_iva ='$fac_iva', fac_monto_total ='$fac_monto_total', fac_estado ='$fac_estado', fkinsu_fac_id =NULL
				WHERE pkfac_id='$id'");
			} elseif (!empty($fkinsu_fac_id)) {
				$result = pg_query($this->dbConnection,
				"UPDATE factura 
				SET fkman_fac_id =NULL, fkrep_fac_id =NULL, fkediserbas_fac_id =NULL, fac_fecha ='$fac_fecha', fac_iva ='$fac_iva', fac_monto_total ='$fac_monto_total', fac_estado ='$fac_estado', fkinsu_fac_id ='$fkinsu_fac_id'
				WHERE pkfac_id='$id'");
			}
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteFactura($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM factura WHERE pkfac_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*               FUNCIONES DE SQL DE FONDOS					*
		*															*
		************************************************************/
		function getFondos(){
			$result = pg_query($this->dbConnection,
			"SELECT f.*, e.edi_nombre
			FROM fondo f, edificio e
			WHERE f.fkedi_fon_id = e.pkedi_id
			ORDER BY f.pkfon_id");

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

		function getFondoById($id){
			$result = pg_query($this->dbConnection,
			"SELECT f.*, e.edi_nombre
			FROM fondo f, edificio e
			WHERE f.pkfon_id = $id and f.fkedi_fon_id = e.pkedi_id
			ORDER BY f.pkfon_id");

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

		function addFondo($fkedi_fon_id, $fon_activos, $fon_ingreso, $fon_egreso, $fon_tipo){
			$result = pg_query($this->dbConnection,
			"INSERT INTO fondo (pkfon_id, fkedi_fon_id, fon_activos, fon_ingreso, fon_egreso, fon_tipo)
			 VALUES (nextval('fondo_pkfon_id_seq'::regclass), '$fkedi_fon_id', '$fon_activos', '$fon_ingreso', '$fon_egreso', '$fon_tipo')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateFondo($id,$fkedi_fon_id,$fon_activos,$fon_ingreso,$fon_egreso,$fon_tipo){
			$result = pg_query($this->dbConnection,
			"UPDATE fondo 
			SET fkedi_fon_id='$fkedi_fon_id', fon_activos$fon_activos', fon_ingreso='$fon_ingreso', fon_egreso='$fon_egreso', 
			fon_tipo='$fon_tipo'
			WHERE pkfon_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteFondo($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM fondo WHERE pkfon_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*			FUNCIONES DE SQL DE LAS INSTALACIONES			*
		*															*
		************************************************************/
		function getInstalaciones(){
			$result = pg_query($this->dbConnection,
			"SELECT i.*
			FROM instalacion i
			ORDER BY i.pkins_id");

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

		function getEdificioInstalacion(){	
			$result = pg_query($this->dbConnection,
			"SELECT ei.pkediins_id, e.edi_nombre, i.ins_nombre
			FROM edificio_instalacion ei, edificio e, instalacion i
			WHERE ei.fkedi_ediins_id = e.pkedi_id and ei.fkins_ediins_id = i.pkins_id
			ORDER BY ei.pkediins_id");
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

		function getInstalacionById($id){
			$result = pg_query($this->dbConnection,
			"SELECT i.*
			FROM instalacion i
			WHERE i.pkins_id= $id
			ORDER BY i.pkins_id");

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
		
		function addInstalacion($ins_nombre, $ins_descripcion){
			$result = pg_query($this->dbConnection,
			"INSERT INTO instalacion (pkins_id, ins_nombre, ins_descripcion)
			 VALUES (nextval('instalacion_pkins_id_seq'::regclass), '$ins_nombre', '$ins_descripcion')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateInstalacion($id,$ins_nombre,$ins_descripcion){
			$result = pg_query($this->dbConnection,
			"UPDATE instalacion 
			SET ins_nombre='$ins_nombre', ins_descripcion='$ins_descripcion'
			WHERE pkins_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteInstalacion($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM instalacion WHERE pkins_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*				FUNCIONES DE SQL DE LOS INSUMOS				*
		*															*
		************************************************************/
		function getInsumos(){
			$result = pg_query($this->dbConnection,
			"SELECT i.*, e.edi_nombre as edificio
			FROM insumo i, edificio e
			WHERE i.fkedi_insu_id = e.pkedi_id
			order by pkinsu_id");

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

		function getInsumoById($id){
			$result = pg_query($this->dbConnection,
			"SELECT i.*, e.edi_nombre as edificio
			FROM insumo i, edificio e
			WHERE i.pkinsu_id = $id and i.fkedi_insu_id = e.pkedi_id
			order by pkinsu_id");

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

		function addInsumo($fkedi_insu_id,$insu_nombre,$insu_cantidad, $insu_costo_unidad, $fecha_compra){
			$result = pg_query($this->dbConnection,
			"INSERT INTO insumo (pkinsu_id,fkedi_insu_id,insu_nombre,insu_cantidad, insu_costo_unidad, fecha_compra) 
			values(nextval('insumo_pkinsu_id_seq'::regclass), '$fkedi_insu_id', '$insu_nombre', '$insu_cantidad', '$insu_costo_unidad', '$fecha_compra')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateInsumo($id,$fkedi_insu_id,$insu_nombre,$insu_cantidad,$insu_costo_unidad, $fecha_compra){
			$result = pg_query($this->dbConnection,
			"UPDATE insumo 
			SET fkedi_insu_id='$fkedi_insu_id', insu_nombre='$insu_nombre', insu_cantidad='$insu_cantidad', insu_costo_unidad='$insu_costo_unidad', fecha_compra='$fecha_compra'
			WHERE pkinsu_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteInsumo($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM insumo WHERE pkinsu_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*	    FUNCIONES DE SQL DE LOS JUNTAS DE CONDOMINIOS		*
		*															*
		************************************************************/

		function getJuntasDeCondominios(){ 
			$result = pg_query($this->dbConnection,
			"SELECT jc.*, e.edi_nombre, (SELECT COUNT(m.pkmie_id) 
										FROM miembro m 
										WHERE m.fkjuncon_mie_id = jc.pkjuncon_id) as miembros
			FROM junta_condominio jc, edificio e
			WHERE jc.fkedi_juncon_id = e.pkedi_id
			ORDER BY jc.pkjuncon_id");

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

		function getJuntasDeCondominioById($id){ 
			$result = pg_query($this->dbConnection,
			"SELECT jc.*, e.edi_nombre, (SELECT COUNT(m.pkmie_id) 
										FROM miembro m 
										WHERE m.fkjuncon_mie_id = jc.pkjuncon_id) as miembros
			FROM junta_condominio jc, edificio e
			WHERE jc.pkjuncon_id = $id and jc.fkedi_juncon_id = e.pkedi_id
			ORDER BY jc.pkjuncon_id");

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

		function addJuntaDeCondominio($fkedi_juncon_id, $juncon_fecha_inicio, $juncon_fecha_fin){
			$result = pg_query($this->dbConnection,
			"INSERT INTO junta_condominio (pkjuncon_id, fkedi_juncon_id, juncon_fecha_inicio, juncon_fecha_fin)
			 VALUES (nextval('junta_condominio_pkjuncon_id_seq'::regclass),'$fkedi_juncon_id', '$juncon_fecha_inicio', '$juncon_fecha_fin')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateJuntaCondominio($id,$fkedi_juncon_id,$juncon_fecha_inicio,$juncon_fecha_fin){
			$result = pg_query($this->dbConnection,
			"UPDATE junta_condominio 
			SET fkedi_juncon_id='$fkedi_juncon_id', juncon_fecha_inicio='$juncon_fecha_inicio', juncon_fecha_fin='$juncon_fecha_fin'
			WHERE pkjuncon_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteJuntaDeCondominio($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM junta_condominio WHERE pkjuncon_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*	         FUNCIONES DE SQL DE LOS MANTENIMIENTOS			*
		*															*
		************************************************************/

		function getMantenimientos(){ 
			$result = pg_query($this->dbConnection,
			"SELECT m.*, e.edi_nombre, i.ins_nombre
			FROM mantenimiento m, edificio_instalacion ei, edificio e, instalacion i
			WHERE m.fkediins_man_id = ei.pkediins_id and ei.fkedi_ediins_id = e.pkedi_id and ei.fkins_ediins_id = i.pkins_id
			order by m.pkman_id");

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

		function getMantenimientoById($id){ 
			$result = pg_query($this->dbConnection,
			"SELECT m.*, e.edi_nombre, i.ins_nombre
			FROM mantenimiento m, edificio_instalacion ei, edificio e, instalacion i
			WHERE m.pkman_id = $id and m.fkediins_man_id = ei.pkediins_id and ei.fkedi_ediins_id = e.pkedi_id and ei.fkins_ediins_id = i.pkins_id
			order by m.pkman_id");

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

		function addMantenimiento($fkediins_man_id, $man_fecha, $man_descripcion){
			$result = pg_query($this->dbConnection,
			"INSERT INTO mantenimiento (pkman_id, fkediins_man_id, man_fecha, man_descripcion)
			 VALUES (nextval('mantenimiento_pkman_id_seq'::regclass), '$fkediins_man_id', '$man_fecha', '$man_descripcion')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateMantenimiento($id, $fkediins_man_id, $man_fecha, $man_descripcion){
			$result = pg_query($this->dbConnection,
			"UPDATE mantenimiento 
			SET fkediins_man_id='$fkediins_man_id', man_fecha='$man_fecha', man_descripcion='$man_descripcion'
			WHERE pkman_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteMantenimiento($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM mantenimiento WHERE pkman_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*	         FUNCIONES DE SQL DE LOS MIEMBROS				*
		*															*
		************************************************************/

		function getMiembros(){ 
			$result = pg_query($this->dbConnection,
			"SELECT m.*, e.edi_nombre, p.*
			FROM miembro m, junta_condominio jc, edificio e, propietario_apartamento pa, propietario p
			WHERE m.fkjuncon_mie_id = jc.pkjuncon_id and jc.fkedi_juncon_id = e.pkedi_id and m.fkproapa_mie_id = pa.pkproapa_id and pa.fkpro_proapa_id = p.pkpro_id
			ORDER BY m.pkmie_id");

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

		function getJuntaDeCondominioNombreEdificio(){ 
			$result = pg_query($this->dbConnection,
			"SELECT jc.pkjuncon_id, e.edi_nombre
			FROM junta_condominio jc, edificio e
			WHERE jc.fkedi_juncon_id = e.pkedi_id
			ORDER BY jc.pkjuncon_id");

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

		function getPropietarioApartamento(){ 
			$result = pg_query($this->dbConnection,
			"SELECT pa.pkproapa_id, p.pro_primer_nombre, p.pro_segundo_nombre, p.pro_primer_apellido, p.pro_segundo_apellido, a.apa_nombre, pis.pis_nombre, e.edi_nombre
			FROM propietario_apartamento pa, propietario p, apartamento a, piso pis, edificio e
			WHERE pa.fkpro_proapa_id = p.pkpro_id and pa.fkapa_proapa_id = a.pkapa_id and a.fkedi_apa_id = e.pkedi_id and a.fkpis_apa_id = pis.pkpis_id
			ORDER BY pa.pkproapa_id");

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

		function getMiembroById($id){ 
			$result = pg_query($this->dbConnection,
			"SELECT m.*, e.edi_nombre, p.*
			FROM miembro m, junta_condominio jc, edificio e, propietario_apartamento pa, propietario p
			WHERE m.pkmie_id = $id and m.fkjuncon_mie_id = jc.pkjuncon_id and jc.fkedi_juncon_id = e.pkedi_id and m.fkproapa_mie_id = pa.pkproapa_id and pa.fkpro_proapa_id = p.pkpro_id
			ORDER BY m.pkmie_id");

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

		function addMiembros($fkjuncon_mie_id, $fkproapa_mie_id, $mie_tipo){
			$result = pg_query($this->dbConnection,
			"INSERT INTO miembro (pkmie_id, fkjuncon_mie_id, fkproapa_mie_id, mie_tipo)
			 VALUES (nextval('miembro_pkmie_id_seq'::regclass), '$fkjuncon_mie_id', '$fkproapa_mie_id', '$mie_tipo')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateMiembro($id,$fkjuncon_mie_id,$fkproapa_mie_id,$mie_tipo){
			$result = pg_query($this->dbConnection,
			"UPDATE miembro 
			SET fkjuncon_mie_id='$fkjuncon_mie_id', fkproapa_mie_id='$fkproapa_mie_id', mie_tipo='$mie_tipo'
			WHERE pkmie_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteMiembro($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM miembro WHERE pkmie_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*	           FUNCIONES DE SQL DE LAS OFICINAS				*
		*															*
		************************************************************/

		function getOficinas(){ 
			$result = pg_query($this->dbConnection,
			"SELECT o.*, a.adm_nombre, h.hor_inicio, h.hor_fin, e.lug_nombre as estado, m.lug_nombre as municipio, p.lug_nombre as parroquia
			FROM oficina o, administradora a, oficina_horario oh, horario h, lugar e, lugar m, lugar p
			WHERE o.fkadm_ofi_id = a.pkadm_id and oh.fkofi_ofihor_id = o.pkofi_id and oh.fkhor_ofihor_id = h.pkhor_id and o.fklug_ofi_id = p.pklug_id and p.fklug_lug_id = m.pklug_id and m.fklug_lug_id = e.pklug_id
			ORDER BY o.pkofi_id");

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

		function getOficinaById($id){ 
			$result = pg_query($this->dbConnection,
			"SELECT o.*, a.adm_nombre, h.hor_inicio, h.hor_fin, e.lug_nombre as estado, m.lug_nombre as municipio, p.lug_nombre as parroquia
			FROM oficina o, administradora a, oficina_horario oh, horario h, lugar e, lugar m, lugar p
			WHERE o.pkofi_id = $id and o.fkadm_ofi_id = a.pkadm_id and oh.fkofi_ofihor_id = o.pkofi_id and oh.fkhor_ofihor_id = h.pkhor_id and o.fklug_ofi_id = p.pklug_id and p.fklug_lug_id = m.pklug_id and m.fklug_lug_id = e.pklug_id
			ORDER BY o.pkofi_id");

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

		function addOficina($fklug_ofi_id, $fkadm_ofi_id, $ofi_nombre, $ofi_telefono, $ofi_correo){
			$result = pg_query($this->dbConnection,
			"INSERT INTO oficina (pkofi_id, fklug_ofi_id, fkadm_ofi_id, ofi_nombre, ofi_telefono, ofi_correo)
			 VALUES (nextval('oficina_pkofi_id_seq'::regclass), '$fklug_ofi_id', '$fkadm_ofi_id', '$ofi_nombre', '$ofi_telefono', '$ofi_correo') 
			 RETURNING pkofi_id");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				$row = pg_fetch_row($result);
				$id = $row['0'];
				return $this->result_construct("success",$id);
			}
		}

		function addOficinaHorario($fkofi_ofihor_id, $fkhor_ofihor_id){
			$result = pg_query($this->dbConnection,
			"INSERT INTO oficina_horario (pkofihor_id, fkofi_ofihor_id, fkhor_ofihor_id)
			 VALUES (nextval('oficina_horario_pkofihor_id_seq'::regclass), '$fkofi_ofihor_id', '$fkhor_ofihor_id')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateOficina($id,$fklug_ofi_id, $fkadm_ofi_id, $ofi_nombre, $ofi_telefono, $ofi_correo){
			$result = pg_query($this->dbConnection,
			"UPDATE oficina 
			SET fklug_ofi_id='$fklug_ofi_id', fkadm_ofi_id='$fkadm_ofi_id', ofi_nombre='$ofi_nombre', ofi_telefono='$ofi_telefono', ofi_correo='$ofi_correo'
			WHERE pkofi_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function updateOficinaHorario($id,$fkofi_ofihor_id, $fkhor_ofihor_id){
			$result = pg_query($this->dbConnection,
			"UPDATE oficina_horario 
			SET fkofi_ofihor_id='$fkofi_ofihor_id', fkhor_ofihor_id='$fkhor_ofihor_id'
			WHERE pkofihor_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteOficina($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM oficina WHERE pkofi_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}
		
		/************************************************************
		*															*
		*			FUNCIONES DE SQL DE LOS PRESUPUESTOS			*
		*															*
		************************************************************/
		function getPresupuestos(){
			$result = pg_query($this->dbConnection,
			"SELECT p.*, prov.prov_nombre, r.rep_descripcion
			FROM presupuesto p, proveedor prov, reparacion r
			WHERE p.fkprov_pre_id = prov.pkprov_id and p.fkrep_pre_id = r.pkrep_id
			ORDER BY p.pkpre_id");

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

		function getPresupuestoById($id){
			$result = pg_query($this->dbConnection,
			"SELECT p.*, prov.prov_nombre, r.rep_descripcion
			FROM presupuesto p, proveedor prov, reparacion r
			WHERE p.pkpre_id = $id and p.fkprov_pre_id = prov.pkprov_id and p.fkrep_pre_id = r.pkrep_id
			ORDER BY p.pkpre_id");

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

		function addPresupuesto($fkrep_pre_id, $fkprov_pre_id, $pre_estado, $pre_fecha, $pre_monto){
			$result = pg_query($this->dbConnection,
			"INSERT INTO presupuesto (pkpre_id, fkrep_pre_id, fkprov_pre_id, pre_estado, pre_fecha, pre_monto)
			 VALUES (nextval('presupuesto_pkpre_id_seq'::regclass), '$fkrep_pre_id', '$fkprov_pre_id', '$pre_estado', '$pre_fecha', '$pre_monto')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updatePresupuesto($id,$fkrep_pre_id, $fkprov_pre_id, $pre_estado, $pre_fecha, $pre_monto){
			$result = pg_query($this->dbConnection,
			"UPDATE presupuesto 
			SET fkrep_pre_id='$fkrep_pre_id', fkprov_pre_id='$fkprov_pre_id', pre_estado='$pre_estado', pre_fecha='$pre_fecha', pre_monto='$pre_monto'
			WHERE pkpre_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deletePresupuesto($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM presupuesto WHERE pkpre_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*			FUNCIONES DE SQL DE LOS PROPIETARIOS			*
		*															*
		************************************************************/
		function getPropietarios(){
			$result = pg_query($this->dbConnection,
			"SELECT pro.*, est.lug_nombre as estado, m.lug_nombre as municipio, p.lug_nombre as parroquia
			FROM propietario pro, lugar m, lugar est, lugar p
			WHERE pro.fklug_pro_id = p.pklug_id and p.fklug_lug_id = m.pklug_id and m.fklug_lug_id = est.pklug_id
			order by pkpro_id");

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

		function getPropietarioById($id){
			$result = pg_query($this->dbConnection,
			"SELECT pro.*, est.lug_nombre as estado, m.lug_nombre as municipio, p.lug_nombre as parroquia
			FROM propietario pro, lugar m, lugar est, lugar p
			WHERE pro.pkpro_id = $id and pro.fklug_pro_id = p.pklug_id and p.fklug_lug_id = m.pklug_id and m.fklug_lug_id = est.pklug_id
			order by pkpro_id");

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

		function addPropietario($fklug_pro_id, $pro_cedula, $pro_primer_nombre, $pro_segundo_nombre, $pro_primer_apellido, $pro_segundo_apellido, $pro_telefono, $pro_correo){
			$result = pg_query($this->dbConnection,
			"INSERT INTO propietario (pkpro_id, fklug_pro_id, pro_cedula, pro_primer_nombre, pro_segundo_nombre, pro_primer_apellido, pro_segundo_apellido, pro_telefono, pro_correo) 
			VALUES(nextval('propietario_pkpro_id_seq'::regclass), '$fklug_pro_id', '$pro_cedula', '$pro_primer_nombre', '$pro_segundo_nombre', '$pro_primer_apellido', '$pro_segundo_apellido', '$pro_telefono', '$pro_correo')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updatePropietario($id,$fklug_pro_id,$pro_cedula,$pro_primer_nombre,$pro_segundo_nombre,$pro_primer_apellido,$pro_segundo_apellido,$pro_telefono,$pro_correo){
			$result = pg_query($this->dbConnection,
			"UPDATE propietario 
			SET fklug_pro_id='$fklug_pro_id', pro_cedula='$pro_cedula', pro_primer_nombre='$pro_primer_nombre', pro_segundo_nombre='$pro_segundo_nombre', 
			pro_primer_apellido='$pro_primer_apellido', pro_segundo_apellido='$pro_segundo_apellido', pro_telefono='$pro_telefono', pro_correo='$pro_correo'
			WHERE pkpro_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deletePropietario($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM propietario WHERE pkpro_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		function showPropietariosByEdificio(){
			$result = pg_query($this->dbConnection,
			"SELECT  p.pkpro_id,p.pro_primer_nombre, p.pro_segundo_nombre, p.pro_primer_apellido, p.pro_segundo_apellido, a.apa_nombre, a.apa_alicuota
			FROM 	propietario p, propietario_apartamento pa, apartamento a
			WHERE	a.fkedi_apa_id = '$_POST[id]' and pa.fkapa_proapa_id = a.pkapa_id and pa.fkpro_proapa_id = p.pkpro_id");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					$respuesta .= "<option value='$row[pkpro_id]'>$row[pro_primer_nombre] $row[pro_segundo_nombre] $row[pro_primer_apellido] $row[pro_segundo_apellido] </>";
				}
				return $respuesta;
			}
		}

		function showPropietariosById(){
			$result = pg_query($this->dbConnection,
			"SELECT  p.pkpro_id,p.pro_primer_nombre, p.pro_segundo_nombre, p.pro_primer_apellido, p.pro_segundo_apellido, a.apa_nombre, a.apa_alicuota
			FROM 	propietario p, propietario_apartamento pa, apartamento a
			WHERE	a.fkedi_apa_id = '$_POST[id]' and pa.fkapa_proapa_id = a.pkapa_id and pa.fkpro_proapa_id = p.pkpro_id");

			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}
			else {
				$respuesta = array();
				while($row = pg_fetch_assoc($result)){
					if ($row[pkpro_id]==$_POST[pkpro_id]) {
						$respuesta .= "<option selected value='$row[pkpro_id]'>$row[pro_primer_nombre] $row[pro_segundo_nombre] $row[pro_primer_apellido] $row[pro_segundo_apellido] </>";
					} else {
						$respuesta .= "<option value='$row[pkpro_id]'>$row[pro_primer_nombre] $row[pro_segundo_nombre] $row[pro_primer_apellido] $row[pro_segundo_apellido] </>";
					}
				}
				return $respuesta;
			}
		}


		/************************************************************
		*															*
		*				FUNCIONES DE SQL DE PROVEEDOR				*
		*															*
		************************************************************/
		function getProveedores(){
			$result = pg_query($this->dbConnection,
			"SELECT prov.*, est.lug_nombre as estado, m.lug_nombre as municipio, p.lug_nombre as parroquia
			FROM proveedor prov, lugar m, lugar est, lugar p
			WHERE prov.fklug_prov_id = p.pklug_id and p.fklug_lug_id = m.pklug_id and m.fklug_lug_id = est.pklug_id
			order by pkprov_id");

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

		function getProveedorById($id){
			$result = pg_query($this->dbConnection,
			"SELECT prov.*, est.lug_nombre as estado, m.lug_nombre as municipio, p.lug_nombre as parroquia
			FROM proveedor prov, lugar m, lugar est, lugar p
			WHERE prov.pkprov_id = $id and prov.fklug_prov_id = p.pklug_id and p.fklug_lug_id = m.pklug_id and m.fklug_lug_id = est.pklug_id
			order by pkprov_id");

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

		function addProveedor($fklug_prov_id,$prov_rif,$prov_nombre,$prov_telefono){
			$result = pg_query($this->dbConnection,
			"INSERT INTO proveedor (pkprov_id,fklug_prov_id,prov_rif,prov_nombre,prov_telefono) values(nextval('proveedor_pkprov_id_seq'::regclass), 
			'$fklug_prov_id', '$prov_rif', '$prov_nombre', '$prov_telefono')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateProveedor($id,$fklug_prov_id,$prov_rif,$prov_nombre,$prov_telefono){
			$result = pg_query($this->dbConnection,
			"UPDATE proveedor 
			SET fklug_prov_id='$fklug_prov_id', prov_rif='$prov_rif', prov_nombre='$prov_nombre', prov_telefono='$prov_telefono' 
			WHERE pkprov_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteProveedor($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM proveedor WHERE pkprov_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*	           FUNCIONES DE SQL DE LOS RECIBOS				*
		*															*
		************************************************************/

		function getRecibos(){ 
			$result = pg_query($this->dbConnection,
			"SELECT 	p.pro_primer_nombre || ' ' || p.pro_segundo_nombre || ' ' || p.pro_primer_apellido || ' ' || p.pro_segundo_apellido as nombre_propietario, r.*
			FROM		recibo r, aviso_cobro ac, propietario_apartamento pa, propietario p, proapa_avicob paac
			WHERE 		r.fkavicob_rec_id = ac.pkavicob_id and paac.fkavicob_proapa_avicob_id = ac.pkavicob_id and paac.fkproapa_proapa_avicob_id = pa.pkproapa_id and pa.fkpro_proapa_id = p.pkpro_id
			ORDER BY 	r.pkrec_id");

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

		function getReciboById($id){ 
			$result = pg_query($this->dbConnection,
			"SELECT r.*, a.adm_nombre, e.edi_nombre
			FROM recibo r, administradora a, junta_condominio jc, edificio e 
			WHERE r.pkrec_id = $id and r.fkadm_rec_id = a.pkadm_id and r.fkjuncon_rec_id = jc.pkjuncon_id and jc.fkedi_juncon_id = e.pkedi_id
			ORDER BY r.pkrec_id ");

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

		function addRecibo($fkavicob_rec_id_id,$rec_fecha,$rec_monto_total){
			$result = pg_query($this->dbConnection,
			"INSERT INTO recibo (pkrec_id, rec_fecha, rec_monto_total, fkavicob_rec_id) 
			VALUES(nextval('recibo_pkrec_id_seq'::regclass), '2015-$rec_fecha-05', '$rec_monto_total', '$fkavicob_rec_id_id')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateRecibo($id,$fkadm_rec_id,$fkjuncon_rec_id,$rec_fecha,$rec_iva, $rec_monto_total){
			$result = pg_query($this->dbConnection,
			"UPDATE recibo 
			SET fkadm_rec_id='$fkadm_rec_id', fkjuncon_rec_id='$fkjuncon_rec_id', rec_fecha='$rec_fecha', rec_iva='$rec_iva', rec_monto_total='$rec_monto_total'
			WHERE pkrec_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteRecibo($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM recibo WHERE pkprec_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}

		/************************************************************
		*															*
		*	       FUNCIONES DE SQL DE LAS REPARACIONES				*
		*															*
		************************************************************/

		function getReparaciones(){ 
			$result = pg_query($this->dbConnection,
			"SELECT r.*, e.edi_nombre, ed.evadia_descripcion
			FROM reparacion r, evaluacion_diagnostico ed, edificio e
			WHERE r.fkevadia_rep_id = ed.pkevadia_id and ed.fkedi_evadia_id = e.pkedi_id
			ORDER BY r.pkrep_id");

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

		function getReparacionById($id){ 
			$result = pg_query($this->dbConnection,
			"SELECT r.*, e.edi_nombre, ed.evadia_descripcion
			FROM reparacion r, evaluacion_diagnostico ed, edificio e
			WHERE r.pkrep_id = $id and r.fkevadia_rep_id = ed.pkevadia_id and ed.fkedi_evadia_id = e.pkedi_id
			ORDER BY r.pkrep_id");

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

		function getEvaluacionDiagnostico(){	
			$result = pg_query($this->dbConnection,
			"SELECT ed.*
			FROM evaluacion_diagnostico ed
			ORDER BY ed.pkevadia_id");
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

		function addReparacion($fkevadia_rep_id, $rep_fecha_inicio, $rep_fecha_fin, $rep_descripcion, $rep_monto){
			$result = pg_query($this->dbConnection,
			"INSERT INTO reparacion (pkrep_id, fkevadia_rep_id, rep_fecha_inicio, rep_fecha_fin, rep_descripcion, rep_monto)
			 VALUES (nextval('reparacion_pkrep_id_seq'::regclass), '$fkevadia_rep_id', '$rep_fecha_inicio', '$rep_fecha_fin', '$rep_descripcion', '$rep_monto')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateReparacion($id,$fkevadia_rep_id,$rep_fecha_inicio,$rep_fecha_fin,$rep_descripcion,$rep_monto){
			$result = pg_query($this->dbConnection,
			"UPDATE reparacion 
			SET fkevadia_rep_id='$fkevadia_rep_id', rep_fecha_inicio='$rep_fecha_inicio', rep_fecha_fin='$rep_fecha_fin', rep_descripcion='$rep_descripcion', rep_monto='$rep_monto'
			WHERE pkrep_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteReparacion($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM reparacion WHERE pkrep_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}


		/************************************************************
		*															*
		*	       FUNCIONES DE SQL DE LAS REUNIONES				*
		*															*
		************************************************************/

		function getReuniones(){ 
			$result = pg_query($this->dbConnection,
			"SELECT r.*, a.adm_nombre, e.edi_nombre
			FROM reunion r, administradora a, junta_condominio jc, edificio e
			WHERE r.fkadm_reu_id = a.pkadm_id and r.fkjuncon_reu_id = jc.pkjuncon_id and jc.fkedi_juncon_id = e.pkedi_id
			ORDER BY r.pkreu_id");

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

		function getReunionById($id){ 
			$result = pg_query($this->dbConnection,
			"SELECT r.*, a.adm_nombre, e.edi_nombre
			FROM reunion r, administradora a, junta_condominio jc, edificio e
			WHERE r.pkreu_id = $id and r.fkadm_reu_id = a.pkadm_id and r.fkjuncon_reu_id = jc.pkjuncon_id and jc.fkedi_juncon_id = e.pkedi_id
			ORDER BY r.pkreu_id");

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
		
		function addReunion($fkadm_reu_id, $fkjuncon_reu_id, $reu_fecha, $reu_descripcion){
			$result = pg_query($this->dbConnection,
			"INSERT INTO reunion (pkreu_id, fkadm_reu_id, fkjuncon_reu_id, reu_fecha, reu_descripcion)
			 VALUES (nextval('reunion_pkreu_id_seq'::regclass), '$fkadm_reu_id', '$fkjuncon_reu_id', '$reu_fecha', '$reu_descripcion')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateReunion($id,$fkadm_reu_id,$fkjuncon_reu_id,$reu_fecha,$reu_descripcion){
			$result = pg_query($this->dbConnection,
			"UPDATE reunion 
			SET fkadm_reu_id ='$fkadm_reu_id', fkjuncon_reu_id ='$fkjuncon_reu_id', reu_fecha ='$reu_fecha', reu_descripcion='$reu_descripcion'
			WHERE pkreu_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteReunion($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM reunion WHERE pkreu_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}


		/************************************************************
		*															*
		*	      FUNCIONES DE SQL DE LAS SUPERVISIONES				*
		*															*
		************************************************************/

		function getSupervisiones(){ 
			$result = pg_query($this->dbConnection,
			"SELECT s.*, a.adm_nombre, emp.emp_primer_nombre, emp.emp_segundo_nombre, emp.emp_primer_apellido, emp.emp_segundo_apellido
			FROM supervision s, administradora a, empleado_reparación er, empleado emp
			WHERE s.fkadm_sup_id = a.pkadm_id and s.fkemprep_sup_id = er.pkemprep_id and er.fkemp_emprep_id = emp.pkemp_id
			ORDER BY s.pksup_id");

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

		function getSupervisores(){ 
			$result = pg_query($this->dbConnection,
			"SELECT er.pkemprep_id, e.emp_primer_nombre, e.emp_segundo_nombre, e.emp_primer_apellido, e.emp_segundo_apellido
			FROM supervision s, empleado_reparación er, empleado e
			WHERE s.fkemprep_sup_id = er.pkemprep_id and er.fkemp_emprep_id = e.pkemp_id
			ORDER BY er.pkemprep_id");

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

		function getSupervisionById($id){ 
			$result = pg_query($this->dbConnection,
			"SELECT s.*, a.adm_nombre, emp.emp_primer_nombre, emp.emp_segundo_nombre, emp.emp_primer_apellido, emp.emp_segundo_apellido
			FROM supervision s, administradora a, empleado_reparación er, empleado emp
			WHERE s.pksup_id = $id and s.fkadm_sup_id = a.pkadm_id and s.fkemprep_sup_id = er.pkemprep_id and er.fkemp_emprep_id = emp.pkemp_id
			ORDER BY s.pksup_id");

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

		function addSupervision($fkadm_sup_id, $fkemprep_sup_id, $sup_fecha_supervision, $sup_descripcion){
			$result = pg_query($this->dbConnection,
			"INSERT INTO supervision (pksup_id, fkadm_sup_id, fkemprep_sup_id, sup_fecha_supervision, sup_descripcion)
			 VALUES (nextval('supervision_pksup_id_seq'::regclass), '$fkadm_sup_id', '$fkemprep_sup_id', '$sup_fecha_supervision', '$sup_descripcion')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateSupervision($id,$fkadm_sup_id,$fkemprep_sup_id,$sup_fecha_supervision,$sup_descripcion){
			$result = pg_query($this->dbConnection,
			"UPDATE supervision 
			SET fkadm_sup_id ='$fkadm_sup_id', fkemprep_sup_id ='$fkemprep_sup_id', sup_fecha_supervision ='$sup_fecha_supervision', sup_descripcion='$sup_descripcion'
			WHERE pksup_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteSupervision($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM supervision WHERE pksup_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}


		/************************************************************
		*															*
		*	             FUNCIONES DE SQL DE LAS VENTAS				*
		*															*
		************************************************************/

		function getVentas(){ 
			$result = pg_query($this->dbConnection,
			"SELECT v.*, a.adm_nombre, p.pro_primer_nombre, p.pro_segundo_nombre, p.pro_primer_apellido, p.pro_segundo_apellido, apa.apa_nombre, pis.pis_nombre, e.edi_nombre, est.lug_nombre as estado, m.lug_nombre as municipio, par.lug_nombre as parroquia
			FROM venta v, administradora a, propietario_apartamento pa, propietario p, apartamento apa, piso pis, edificio e, lugar est, lugar m, lugar par
			WHERE v.fkadm_ven_id = a.pkadm_id and v.fkproapa_ven_id = pa.pkproapa_id and pa.fkpro_proapa_id = p.pkpro_id and pa.fkapa_proapa_id = apa.pkapa_id and apa.fkpis_apa_id = pis.pkpis_id and apa.fkedi_apa_id = e.pkedi_id and e.fklug_edi_id = par.pklug_id and par.fklug_lug_id = m.pklug_id and m.fklug_lug_id = est.pklug_id
			ORDER BY v.pkven_id");

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

		function getVentaById($id){ 
			$result = pg_query($this->dbConnection,
			"SELECT v.*, a.adm_nombre, p.pro_primer_nombre, p.pro_segundo_nombre, p.pro_primer_apellido, p.pro_segundo_apellido, apa.apa_nombre, pis.pis_nombre, e.edi_nombre, est.lug_nombre as estado, m.lug_nombre as municipio, par.lug_nombre as parroquia
			FROM venta v, administradora a, propietario_apartamento pa, propietario p, apartamento apa, piso pis, edificio e, lugar est, lugar m, lugar par
			WHERE v.pkven_id = $id and v.fkadm_ven_id = a.pkadm_id and v.fkproapa_ven_id = pa.pkproapa_id and pa.fkpro_proapa_id = p.pkpro_id and pa.fkapa_proapa_id = apa.pkapa_id and apa.fkpis_apa_id = pis.pkpis_id and pis.fkedi_pis_id = e.pkedi_id and e.fklug_edi_id = par.pklug_id and par.fklug_lug_id = m.pklug_id and m.fklug_lug_id = est.pklug_id
			ORDER BY v.pkven_id");

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

		function addVenta($fkadm_ven_id, $fkproapa_ven_id, $ven_fecha, $ven_monto, $ven_ganancia_adminitradora){
			$result = pg_query($this->dbConnection,
			"INSERT INTO venta (pkven_id, fkadm_ven_id, fkproapa_ven_id, ven_fecha, ven_monto, ven_ganancia_adminitradora)
			 VALUES (nextval('venta_pkven_id_seq'::regclass), '$fkadm_ven_id', '$fkproapa_ven_id', '$ven_fecha', '$ven_monto', '$ven_ganancia_adminitradora')");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Agregado exitosamente");
			}
		}

		function updateVenta($id,$fkadm_ven_id,$fkproapa_ven_id,$ven_fecha,$ven_monto,$ven_ganancia_administradora){
			$result = pg_query($this->dbConnection,
			"UPDATE venta 
			SET fkadm_ven_id ='$fkadm_ven_id', fkproapa_ven_id ='$fkproapa_ven_id', ven_fecha ='$ven_fecha', ven_monto = '$ven_monto', ven_ganancia_adminitradora = '$ven_ganancia_administradora'
			WHERE pkven_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Actualizado exitosamente");
			}
		}

		function deleteVenta($id){
			$result = pg_query($this->dbConnection,
				"DELETE FROM venta WHERE pkven_id='$id'");
			if(pg_last_error()){
				return $this->result_construct("error",pg_last_error());
			}else{
				return $this->result_construct("success","Eliminado exitosamente");
			}
		}
	}
?>