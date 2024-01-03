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
              <h2>Data TPS</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
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
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode TPS <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <input type="hidden" name="formtype" id="formtype" value="add">
                <input type="text" name="KodeTPS" id="KodeTPS" required="" placeholder="Kode TPS" class="form-control ">
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama TPS <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <input type="text" name="NamaTPS" id="NamaTPS" required="" placeholder="Nama TPS" class="form-control ">
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Alamat TPS <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <textarea id="AlamatTPS" name="AlamatTPS" class="resizable_textarea form-control" placeholder="Alamat"></textarea>
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
<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

<script type="text/javascript">
  $(function () {
    $(document).ready(function () {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_TPS/Read",
        data: {'KodeTPS':''},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
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
        url     : '<?=base_url()?>C_TPS/CRUD',
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
    
    function GetData(id) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_TPS/Read",
        data: {'KodeTPS':id},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            // $('#KodePenyakit').val(v.KodePenyakit).change;
            $('#KodeTPS').val(v.KodeTPS);
            $('#NamaTPS').val(v.NamaTPS);
            $('#AlamatTPS').val(v.AlamatTPS);

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
        keyExpr: "KodeTPS",
        showBorders: true,
        allowColumnReordering: true,
        allowColumnResizing: true,
        columnAutoWidth: true,
        showBorders: true,
        paging: {
            enabled: false
        },
        editing: {
            mode: "row",
            allowAdding:true,
            allowUpdating: true,
            allowDeleting: true,
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
            fileName: "Daftar TPS"
        },
        columns: [
            {
                dataField: "KodeTPS",
                caption: "Kode TPS",
                allowEditing:false,
            },
            {
                dataField: "NamaTPS",
                caption: "Nama TPS",
                allowEditing:false
            },
            {
                dataField: "AlamatTPS",
                caption: "Alamat TPS",
                allowEditing:false
            }
        ],
        onEditingStart: function(e) {
            GetData(e.data.KodeTPS);
        },
        onInitNewRow: function(e) {
            // logEvent("InitNewRow");
            $('#modal_').modal('show');
        },
        onRowRemoving: function(e) {
          id = e.data.KodeTPS;
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
  });
</script>