<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<!-- page content -->
  <div class="right_col" role="main">
    <div class="">

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12  ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Data Saksi</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-md-12 col-sm-12  ">
                  <!-- filter -->
                  <div class="row">
                    <div class="col-md-2 col-sm-12 ">
                      <select id="filter_prov_id" name="filter_prov_id" class="form-control">
                        <?php 
                          $data = $this->ModelsExecuteMaster->FindData(array('prov_id'=> 1),"dem_provinsi");
                          foreach ($data->result() as $key) {
                            echo "<option value = '".$key->prov_id."' >".$key->prov_name."</option>";
                          }
                        ?>
                      </select>
                    </div>

                    <div class="col-md-2 col-sm-12 ">
                      <select id="filter_kota_id" name="filter_kota_id" class="form-control">
                        <option value="">Pilih Kota</option>
                        <?php 
                          $data = $this->ModelsExecuteMaster->FindData(array('prov_id'=>1),"dem_kota");
                          foreach ($data->result() as $key) {
                            echo "<option value = '".$key->city_id."' >".$key->city_name."</option>";
                          }
                        ?>
                      </select>
                    </div>


                    <div class="col-md-2 col-sm-12 ">
                      <select id="filter_kecamatan_id" name="filter_kecamatan_id" class="form-control">
                        <!-- <option value="-1">Pilih Kecamatan</option> -->
                      </select>
                    </div>

                    <div class="col-md-2 col-sm-12 ">
                      <select id="filter_kelurahan_id" name="filter_kelurahan_id" class="form-control">
                        <!-- <option value="-1">Pilih Kelurahan</option> -->
                      </select>
                    </div>
                    <div class="col-md-3 col-sm-12 ">
                      <button class="btn btn-secondary" id="btn_filter">Filter</button>
                    </div>

                  </div>
                </div>
                <div class="col-md-12 col-sm-12  ">
                  <div class="dx-viewport demo-container">
                    <div id="data-grid-demo">
                      <div id="gridContainer">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->

  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">TPS</h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">NIK <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <input type="hidden" name="formtype" id="formtype" value="add">
                <input type="hidden" name="id" id="id">
                <input type="text" name="NIK" id="NIK" required="" placeholder="NIK" class="form-control ">
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No. KTAB <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <input type="text" name="NoKTAB" id="NoKTAB" required="" placeholder="No. KTAB " class="form-control ">
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Saksi <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <input type="text" name="FullName" id="FullName" required="" placeholder="Nama Saksi" class="form-control ">
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Alamat Saksi <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <textarea id="Alamat" name="Alamat" class="resizable_textarea form-control" placeholder="Alamat Saksi"></textarea>
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">tanggal Lahir Saksi <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <input type="date" name="TanggalLahir" id="TanggalLahir" required="" class="form-control ">
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Provinsi <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <select id="prov_id" name="prov_id" class="form-control">
                  <?php 
                    $data = $this->ModelsExecuteMaster->FindData(array('prov_id'=> 1),"dem_provinsi");
                    foreach ($data->result() as $key) {
                      echo "<option value = '".$key->prov_id."' >".$key->prov_name."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kota <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <select id="kota_id" name="kota_id" class="form-control">
                  <option value="">Pilih Kota</option>
                  <?php 
                    $data = $this->ModelsExecuteMaster->FindData(array('prov_id'=>1),"dem_kota");
                    foreach ($data->result() as $key) {
                      echo "<option value = '".$key->city_id."' >".$key->city_name."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kecamatan <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <select id="kecamatan_id" name="kecamatan_id" class="form-control">
                  <!-- <option value="-1">Pilih Kecamatan</option> -->
                </select>
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kelurahan <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <select id="kelurahan_id" name="kelurahan_id" class="form-control">
                  <!-- <option value="-1">Pilih Kelurahan</option> -->
                </select>
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">TPS <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <select id="TPS" name="TPS" class="form-control">
                  <option value="-1">Pilih TPS</option>
                  <?php 
                    $data = $this->ModelsExecuteMaster->GetData("mastertps");
                    foreach ($data->result() as $key) {
                      echo "<option value = '".$key->KodeTPS."' >".$key->NamaTPS."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No. Telp <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <input type="text" name="NoTlp" id="NoTlp" required="" placeholder="No. Telp" class="form-control ">
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Foto <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <div id="image_result"></div>
                <textarea id = "image_base64" name = "image_base64" style="display:none"> </textarea>

                <input type="file" id="Attachment" name="Attachment" accept=".jpg" class="btn btn-warning"/>
              </div>
            </div>

            <div class="item" form-group>
              <button class="btn btn-primary" id="btn_Save">Save</button>
            </div>
          </form>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          
        </div> -->

      </div>
    </div>
  </div>
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
  $(function () {
    var _URL = window.URL || window.webkitURL;
    var _URLePub = window.URL || window.webkitURL;
    $(document).ready(function () {
      $('#prov_id').select2({
        width: '200px'
      });
      $('#kota_id').select2({
        width: '200px'
      });
      $('#kecamatan_id').select2({
        width: '200px'
      });
      $('#kelurahan_id').select2({
        width: '200px'
      });
      $('#TPS').select2({
        width: '200px'
      });


      $('#filter_prov_id').select2({
        width: '150px'
      });
      $('#filter_kota_id').select2({
        width: '150px'
      });
      $('#filter_kecamatan_id').select2({
        width: '150px'
      });
      $('#filter_kelurahan_id').select2({
        width: '150px'
      });

      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Saksi/Read",
        data: {'NIK':'','prov_id': $('#filter_prov_id').val(), 'kota_id': $('#filter_kota_id').val(),'kecamatan_id': $('#filter_kecamatan_id').val(), 'kelurahan_id': $('#filter_kelurahan_id').val(),'Kriteria':''},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    });

    $('#kota_id').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>C_Saksi/ReadDemografi",
        data: {'demografilevel':'dem_kecamatan', 'wherefield': 'kota_id', 'wherevalue': $('#kota_id').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#kecamatan_id').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Kecamatan"
          });

          $('#kecamatan_id').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.dis_id,
              text: v.dis_name
            });

            $('#kecamatan_id').append(newOption);
          });
        }
      });
    });

    $('#kecamatan_id').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>C_Saksi/ReadDemografi",
        data: {'demografilevel':'dem_kelurahan', 'wherefield': 'kec_id', 'wherevalue': $('#kecamatan_id').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#kelurahan_id').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Kelurahan"
          });

          $('#kelurahan_id').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.subdis_id,
              text: v.subdis_name
            });

            $('#kelurahan_id').append(newOption);
          });
        }
      });
    });


    $('#filter_kota_id').change(function () {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Saksi/ReadDemografi",
        data: {'demografilevel':'dem_kecamatan', 'wherefield': 'kota_id', 'wherevalue': $('#filter_kota_id').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#filter_kecamatan_id').empty();
          var newOption = $('<option>', {
            value: '',
            text: "Pilih Kecamatan"
          });

          $('#filter_kecamatan_id').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.dis_id,
              text: v.dis_name
            });

            $('#filter_kecamatan_id').append(newOption);
          });
        }
      });
    });

    $('#filter_kecamatan_id').change(function () {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Saksi/ReadDemografi",
        data: {'demografilevel':'dem_kelurahan', 'wherefield': 'kec_id', 'wherevalue': $('#filter_kecamatan_id').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#filter_kelurahan_id').empty();
          var newOption = $('<option>', {
            value: '',
            text: "Pilih Kelurahan"
          });

          $('#filter_kelurahan_id').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.subdis_id,
              text: v.subdis_name
            });

            $('#filter_kelurahan_id').append(newOption);
          });
        }
      });
    });

    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);

      e.preventDefault();
      var me = $(this);

      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>C_Saksi/CRUD',
        data    : me.serialize(),
        dataType: 'json',
        success : function (response) {
          if(response.success == true){
            $('#modal_').modal('toggle');
            Swal.fire({
              type: 'success',
              title: 'Horay..',
              text: 'Data Berhasil disimpan!',
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              location.reload();
            });
          }
          else{
            $('#modal_').modal('toggle');
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: response.message,
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              $('#modal_').modal('show');
              $('#btn_Save').text('Save');
              $('#btn_Save').attr('disabled',false);
            });
          }
        }
      });
    });
    $('.close').click(function() {
      location.reload();
    });

    $('#btn_filter').click(function () {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Saksi/Read",
        data: {'NIK':'','prov_id': $('#filter_prov_id').val(), 'kota_id': $('#filter_kota_id').val(),'kecamatan_id': $('#filter_kecamatan_id').val(), 'kelurahan_id': $('#filter_kelurahan_id').val(),'Kriteria':''},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    })
    
    function GetData(id) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>C_Saksi/Read",
        data: {'NIK':id},
        dataType: "json",
        success: function (response) {
          // console.log(response);
          $.each(response.data,function (k,v) {

            $('#id').val(v.id);
            $('#NIK').val(v.NIK);
            $('#NIK').prop('readonly', true);
            $('#NoKTAB').val(v.NoKTAB);
            $('#FullName').val(v.FullName);
            $('#Alamat').val(v.Alamat);
            $('#TanggalLahir').val(v.TanggalLahir);
            $('#prov_id').val(v.prov_id).change();
            $('#kota_id').val(v.kota_id).change();
            // $('#kota_id').trigger('change');
            $('#kecamatan_id').val(v.kecamatan_id).change();
            $('#kelurahan_id').val(v.kelurahan_id).change();
            $('#TPS').val(v.TPS).change();
            $('#NoTlp').val(v.NoTlp);
            $('#image_base64').val(v.Image);
            $('#image_result').html("<img src ='"+v.Image+"' width = '50%'> ");

            $('#formtype').val("edit");
            $('#modal_').modal('show');
          });
        }
      });
    }
    function bindGrid(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "NIK",
        showBorders: true,
        allowColumnReordering: true,
        allowColumnResizing: true,
        columnAutoWidth: true,
        showBorders: true,
        paging: {
            enabled: true
        },
        editing: {
            mode: "row",
            allowAdding:true,
            allowUpdating: true,
            // allowDeleting: true,
            texts: {
                confirmDeleteMessage: ''  
            }
        },
        searchPanel: {
            visible: true,
            width: 240,
            placeholder: "Search..."
        },
        export: {
            enabled: true,
            fileName: "Daftar Saksi"
        },
        columns: [
            {
                dataField: "FullName",
                caption: "Nama Saksi",
                allowEditing:false,
            },
            {
                dataField: "NIK",
                caption: "NIK",
                allowEditing:false
            },
            {
                dataField: "TanggalLahir",
                caption: "Tanggal Lahir",
                allowEditing:false
            },
            {
                dataField: "NoKTAB",
                caption: "No. KTAB",
                allowEditing:false
            },
            {
                dataField: "Alamat",
                caption: "Alamat",
                allowEditing:false
            },
            {
                dataField: "Kecamatan",
                caption: "Kecamatan",
                allowEditing:false
            },
            {
                dataField: "Kelurahan",
                caption: "Kelurahan",
                allowEditing:false
            },
            {
                dataField: "NamaTPS",
                caption: "TPS",
                allowEditing:false
            },
            {
                dataField: "AlamatTPS",
                caption: "Alamat TPS",
                allowEditing:false
            },
            {
                dataField: "NoTlp",
                caption: "NoTlp",
                allowEditing:false
            }
        ],
        onEditingStart: function(e) {
            GetData(e.data.NIK);
        },
        onInitNewRow: function(e) {
            // logEvent("InitNewRow");
            $('#modal_').modal('show');
        },
        onRowRemoving: function(e) {
          id = e.data.NIK;
          Swal.fire({
            title: 'Apakah anda yakin?',
            text: "anda akan menghapus data di baris ini !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {

              $.ajax({
                  type    :'post',
                  url     : '<?=base_url()?>C_TPS/CRUD',
                  data    : {'C_TPS':id,'formtype':'delete'},
                  dataType: 'json',
                  success : function (response) {
                    if(response.success == true){
                      Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      ).then((result)=>{
                        location.reload();
                      });
                    }
                    else{
                      Swal.fire({
                        type: 'error',
                        title: 'Woops...',
                        text: response.message,
                        // footer: '<a href>Why do I have this issue?</a>'
                      }).then((result)=>{
                        location.reload();
                      });
                    }
                  }
                });
              
            }
            else{
              location.reload();
            }
          })
        },
    });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }

    $("#Attachment").change(function(){
      var file = $(this)[0].files[0];
      img = new Image();
      img.src = _URL.createObjectURL(file);
      var imgwidth = 0;
      var imgheight = 0;
      img.onload = function () {
        imgwidth = this.width;
        imgheight = this.height;
        $('#width').val(imgwidth);
        $('#height').val(imgheight);
      }
      readURL(this);
      encodeImagetoBase64(this);
      // alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
          
        reader.onload = function (e) {
          console.log(e.target.result);
            // $('#image_result').attr('src', e.target.result);
            $('#image_result').html("<img src ='"+e.target.result+"' width = '50%'> ");
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    function encodeImagetoBase64(element) {
      $('#image_base64').val('');
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
          // $(".link").attr("href",reader.result);
          // $(".link").text(reader.result);
          $('#image_base64').val(reader.result);
        }
        reader.readAsDataURL(file);
    }
  });
</script>