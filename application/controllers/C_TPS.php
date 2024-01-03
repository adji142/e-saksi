<?php 
	class C_TPS extends CI_Controller {
		private $table = 'mastertps';

		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
		}

		public function Read()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$KodeTPS = $this->input->post('KodeTPS');
			
			if ($KodeTPS == "") {
				 $rs = $this->ModelsExecuteMaster->GetData($this->table);
			}
			else{
				$rs = $this->ModelsExecuteMaster->FindData(array('KodeTPS'=>$KodeTPS),$this->table);	
			}

			if ($rs->num_rows() > 0) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			echo json_encode($data);
		}

		public function CRUD()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$KodeTPS = $this->input->post('KodeTPS');
			$NamaTPS = $this->input->post('NamaTPS');
			$AlamatTPS = $this->input->post('AlamatTPS');
			$CreatedOn = date("y-m-d h:i:s");
			$CreatedBy = $this->input->post('CreatedBy');

			$formtype = $this->input->post('formtype');

			$param = array(
				'KodeTPS' => $KodeTPS,
				'NamaTPS' => $NamaTPS,
				'AlamatTPS' => $AlamatTPS,
				'CreatedOn' => $CreatedOn,
				'CreatedBy' => $CreatedBy
			);

			$errormessage = '';
			if ($formtype == 'add') {
				$rs = $this->ModelsExecuteMaster->ExecInsert($param,$this->table);
				if ($rs) {
					$data['success'] = true;
					$data['message'] = "Data Berhasil Disimpan";
				}
				else{
					$data['message'] = "Gagal Tambah data TPS";
				}
			}
			elseif ($formtype == 'edit') {
				$oWhere = array(
					'KodeTPS' => $KodeTPS
				);
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,$oWhere,$this->table);
				if ($rs) {
					$data['success'] = true;
					$data['message'] = "Data Berhasil Disimpan";
				}
				else{
					$data['message'] = "Gagal Edit data TPS";
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
					'C_TPS' => $C_TPS
				);
				$rs = $this->ModelsExecuteMaster->DeleteData($oWhere,$this->table);
				if ($rs) {
					$data['success'] = true;
					$data['message'] = "Data Berhasil Disimpan";
				}
				else{
					$data['message'] = "Gagal Delete data TPS";
				}
			}
			else{
				$data['message'] = "Invalid Form Type";
			}
			jump:
			echo json_encode($data);

		}

	}
?>