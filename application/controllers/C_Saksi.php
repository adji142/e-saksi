<?php 
	class C_Saksi extends CI_Controller {
		private $table = 'saksi';

		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
		}

		public function Read()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$NIK = $this->input->post('NIK');
			$prov_id = $this->input->post('prov_id');
			$kota_id = $this->input->post('kota_id');
			$kecamatan_id = $this->input->post('kecamatan_id');
			$kelurahan_id = $this->input->post('kelurahan_id');
			$Kriteria = $this->input->post('Kriteria');

			$SQL = "
				SELECT 
					a.FullName,
					a.NIK,
					a.TanggalLahir,
					a.NoKTAB,
					a.Alamat,
					COALESCE(d.dis_name,'')		as Kecamatan,
					COALESCE(e.subdis_name,'') as Kelurahan,
					COALESCE(c.city_name,'') as Kota,
					f.NamaTPS,
					f.AlamatTPS,
					a.NoTlp,
					a.prov_id,
					a.kota_id,
					a.kecamatan_id,
					a.kelurahan_id,
					a.TPS,
					COALESCE(a.Image,'') AS Image
				FROM saksi a
				LEFT JOIN dem_provinsi b on a.prov_id = b.prov_id
				LEFT JOIN dem_kota c on a.kota_id =c.city_id and b.prov_id = c.prov_id
				LEFT JOIN dem_kecamatan d on d.kota_id = c.city_id and a.kecamatan_id = d.dis_id
				LEFT JOIN dem_kelurahan e on e.kec_id = d.dis_id and a.kelurahan_id = e.subdis_id
				LEFT JOIN mastertps f on a.TPS = f.KodeTPS
				WHERE CONCAT(a.FullName,' ', a.NIK, ' ',a.NoKTAB) LIKE '%".$Kriteria."%'
			";

			if ($NIK != "") {
				$SQL .= " AND a.NIK = '".$NIK."'";
			}
			else{
				if($prov_id != ""){
					$SQL .= " AND a.prov_id = '".$prov_id."'";
				}

				if($kota_id != ""){
					$SQL .= " AND a.kota_id = '".$kota_id."'";
				}

				if($kecamatan_id != ""){
					$SQL .= " AND a.kecamatan_id = '".$kecamatan_id."'";
				}

				if($kelurahan_id != ""){
					$SQL .= " AND a.kelurahan_id = '".$kelurahan_id."'";
				}
			}

			$rs = $this->db->query($SQL);

			if ($rs->num_rows() > 0) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			echo json_encode($data);
		}

		public function CRUD()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$id = $this->input->post('id');
			$NIK = $this->input->post('NIK');
			$NoKTAB = $this->input->post('NoKTAB');
			$FullName = $this->input->post('FullName');
			$Alamat = $this->input->post('Alamat');
			$TanggalLahir = $this->input->post('TanggalLahir');
			$prov_id = $this->input->post('prov_id');
			$kota_id = $this->input->post('kota_id');
			$kecamatan_id = $this->input->post('kecamatan_id');
			$kelurahan_id = $this->input->post('kelurahan_id');
			$TPS = $this->input->post('TPS');
			$NoTlp = $this->input->post('NoTlp');
			$Image = $this->input->post('image_base64');

			$CreatedOn = date("y-m-d h:i:s");
			$CreatedBy = $this->input->post('CreatedBy');

			$formtype = $this->input->post('formtype');

			$oFindNIK = $this->ModelsExecuteMaster->FindData(array('NIK'=>$NIK),$this->table);
			$source = $this->input->post('source');

			if ($oFindNIK->num_rows() > 0 && $formtype == "add") {
				$data['success'] = false;
				$data['message'] = 'Nik Sudah dipakai oleh : ' . $oFindNIK->row()->FullName;
				goto jump;
			}

			// $extension = explode('/', mime_content_type($Image))[1];
			$fileExt = "";
			if ($source == "web") {
				$fileExt = pathinfo($_FILES["Attachment"]["name"], PATHINFO_EXTENSION);
			}
			$baseDir = FCPATH.'Assets/images/profile/';
			$config = array(
				'upload_path' => $baseDir,
				'allowed_types' => "gif|jpg|png|jpeg|pdf",
				'overwrite' => TRUE,
				'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				'file_name' => $NIK.'.'.$fileExt
			);
			try {

				// file_put_contents($baseDir,base64_decode($Image));
				$param = array();
				if ($source == "web") {
					$param = array(
						'NIK' => $NIK,
						'NoKTAB' => $NoKTAB,
						'FullName' => $FullName,
						'Alamat' => $Alamat,
						'TanggalLahir' => $TanggalLahir,
						'prov_id' => $prov_id,
						'kota_id' => $kota_id,
						'kecamatan_id' => $kecamatan_id,
						'kelurahan_id' => $kelurahan_id,
						'TPS' => $TPS,
						'NoTlp' => $NoTlp,
						'Image' => $NIK.'.'.$fileExt,
						'CreatedBy' => $CreatedBy,
						'CreatedOn' => $CreatedOn,
					);
				}
				else{
					$param = array(
						'NIK' => $NIK,
						'NoKTAB' => $NoKTAB,
						'FullName' => $FullName,
						'Alamat' => $Alamat,
						'TanggalLahir' => $TanggalLahir,
						'prov_id' => $prov_id,
						'kota_id' => $kota_id,
						'kecamatan_id' => $kecamatan_id,
						'kelurahan_id' => $kelurahan_id,
						'TPS' => $TPS,
						'NoTlp' => $NoTlp,
						'CreatedBy' => $CreatedBy,
						'CreatedOn' => $CreatedOn,
					);
				}

				$errormessage = '';
				if ($formtype == 'add') {
					$rs = $this->ModelsExecuteMaster->ExecInsert($param,$this->table);
					if ($rs) {
						$data['success'] = true;
						$data['message'] = "Data Berhasil Disimpan";
					}
					else{
						$data['message'] = "Gagal Tambah data Saksi";
					}
				}
				elseif ($formtype == 'edit') {
					$oWhere = array(
						'NIK' => $NIK
					);
					$rs = $this->ModelsExecuteMaster->ExecUpdate($param,$oWhere,$this->table);
					if ($rs) {
						$data['success'] = true;
						$data['message'] = "Data Berhasil Disimpan";
					}
					else{
						$data['message'] = "Gagal Edit data Saksi";
					}
				}
				elseif ($formtype == 'delete') {
					// $oCheckPoint = $this->ModelsExecuteMaster->FindData(array('LocationID'=>$id,'RecordOwnerID'=> $RecordOwnerID),'tcheckpoint');

					// if ($oCheckPoint->num_rows() > 0) {
					// 	$data['success'] = false;
					// 	$data['message'] = "Data Lokasi Sudah Dipakai";
					// 	goto jump;
					// }
					$oWhere = array(
						'id' => $id
					);
					$rs = $this->ModelsExecuteMaster->DeleteData($oWhere,$this->table);
					if ($rs) {
						$data['success'] = true;
						$data['message'] = "Data Berhasil Disimpan";
					}
					else{
						$data['message'] = "Gagal Delete data Saksi";
					}
				}
				else{
					$data['message'] = "Invalid Form Type";
				}

			} catch (Exception $e) {
				$data['message'] = $e->getMessage();
			}

			if ($source == 'web') {
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('Attachment')) {
					$data['message'] = $this->upload->display_errors();
		        } else {
		        	$data['message'] = $this->upload->data();
		        }
			}

			jump:
			echo json_encode($data);

		}

		public function ReadDemografi()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$demografilevel = $this->input->post('demografilevel');
			$wherefield = $this->input->post('wherefield');
			$wherevalue = $this->input->post('wherevalue');

			$rs = $this->ModelsExecuteMaster->FindData(array($wherefield=> $wherevalue), $demografilevel);

			if ($rs->num_rows() > 0) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			jump:
			echo json_encode($data);
		}

		public function LookupProvinsi()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$Kriteria = $this->input->post('Kriteria');

			$SQL = "
				SELECT 
					prov_id		AS ID,
					prov_name 	AS Title
				FROM dem_provinsi where prov_name like '%".$Kriteria."%'
			";

			$rs = $this->db->query($SQL);

			if ($rs->num_rows() > 0) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			jump:
			echo json_encode($data);
		}

		public function LookupKota()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$Kriteria = $this->input->post('Kriteria');
			$prov_id = $this->input->post('prov_id');

			$SQL = "
				SELECT 
					city_id		AS ID,
					city_name 	AS Title
				FROM dem_kota where city_name like '%".$Kriteria."%'
				AND prov_id	= '".$prov_id."'
			";

			$rs = $this->db->query($SQL);

			if ($rs->num_rows() > 0) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			jump:
			echo json_encode($data);
		}

		public function LookupKecamatan()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$Kriteria = $this->input->post('Kriteria');
			$kota_id = $this->input->post('kota_id');

			$SQL = "
				SELECT 
					dis_id		AS ID,
					dis_name 	AS Title
				FROM dem_kecamatan where dis_name like '%".$Kriteria."%'
				AND kota_id = '".$kota_id."'
			";

			$rs = $this->db->query($SQL);

			if ($rs->num_rows() > 0) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			jump:
			echo json_encode($data);
		}

		public function LookupKelurahan()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$Kriteria = $this->input->post('Kriteria');
			$kec_id = $this->input->post('kec_id');

			$SQL = "
				SELECT 
					subdis_id		AS ID,
					subdis_name 	AS Title
				FROM dem_kelurahan where subdis_name like '%".$Kriteria."%'
				AND kec_id = '".$kec_id."'
			";

			$rs = $this->db->query($SQL);

			if ($rs->num_rows() > 0) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			jump:
			echo json_encode($data);
		}

	}
?>