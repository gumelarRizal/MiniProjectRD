@extends('Layouts.MainLayouts')

@section('title')
    <h1>{{$pages}}</h1>
@endsection

@push('page-style')
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
@endpush

@section('content')
<div class="card">
  <div class="row">
    <div class="col-12">
      <div class="card-body">
        {{-- <form action="">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Nama Siswa</label>
                <input type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Ekskul</label>
                <input type="text" class="form-control">
              </div>
            </div>
          </div>  
        </form> --}}
        <div class="text-left">
          <button type="button" id="button-daftar-ekskul" class="btn btn-primary" onclick="displayModalDaftar()"><i class="fa fa-plus"></i> Daftar</button>
          
          {{-- <a href="" class="btn btn-info"><i class="fa fa-search"></i> Search</a> --}}
          {{-- <a href="" class="btn btn-secondary"><i class="fa fa-redo-alt"></i> Reset</a> --}}
        </div>
        <hr>
        <table id="table-data" class="display table table-striped table-hover" width="100%">
            <thead>
                <tr>
                    <th data-orderable="false">#</th>
                    <th data-orderable="false" data-data="id_pendaftaran" data-visible="false">ID</th>
                    <th data-orderable="true" data-data="nama_siswa">Siswa</th>
                    <th data-orderable="true" data-data="nama_ekskul">Ekskul</th>
                    <th data-orderable="true" data-data="nama_pembina">Pembina</th>
                    <th data-orderable="true" data-data="nama_pelatih">Pelatih</th>
                    <th data-orderable="false">Aksi</th>
                </tr>
            </thead>
        </table>
        
      </div>
    </div>
  </div>
  <div class="card-footer text-right">
  </div>
</div>
@endsection

@section('modal')
<div id="modal-daftar-ekskul" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h3 class="modal-title"> Daftar Eskskul</h3> 
              <button type="button" class="close" data-dismiss="modal">
                  <span>&times;</span>
              </button>                  
          </div>
          {{-- <form  method="post" action ="{{ Route('daftar_ekskul.daftar')}}"> --}}
            {{-- {{csrf_field()}} --}}
          <form class="form" id="form-data">
            <div class="modal-body">
              <div class="row">
                <input type="hidden" name="id_pendaftaran" id="id-pendaftaran">
                <input type="hidden" name="id_siswa" id="id-siswa">
                <div class="form-group col-sm-6">
                  <label for="daftar-nis">NIS</label>
                  <input type="text" class="form-control" name="daftar_nis" id="daftar-nis" placeholder="NIS">
                </div>
                <div class="form-group col-sm-6">
                  <label for="daftar-nama">Nama</label>
                  <input type="text" class="form-control" name="daftar_nama" id="daftar-nama" placeholder="Nama">
                </div>
                <div class="form-group col-sm-6">
                  <label for="daftar-kelas">Kelas</label>
                  <input type="text" class="form-control" name="daftar_kelas" id="daftar-kelas" placeholder="Kelas">
                </div>
                <div class="form-group col-sm-6">
                  <label for="daftar-alamat">Alamat</label>
                  <textarea class="form-control" name="daftar_alamat" id="daftar-alamat" placeholder="Alamat" rows="3" style="height: 100px;"></textarea>
                </div>
                <div class="form-group col-sm-6">
                  <label for="daftar-tgl-lahir">No Telepon</label>
                  <input type="text" class="form-control" name="daftar_no_telp" id="daftar-no-telp" placeholder="No Telepon">
                </div>
                <div class="form-group col-sm-6">
                  <label for="daftar-jk">Jenis Kelamin</label>
                  {{-- <input type="text" class="form-control" id="daftar-jk" placeholder="NIS"> --}}
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="daftar_jk" id="daftar-jk-laki" value="L">
                    <label class="form-check-label" for="daftar-jk-laki">Laki-laki</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="daftar_jk" id="daftar-jk-perempuan" value="P">
                    <label class="form-check-label" for="daftar-jk-perempuan">Perempuan</label>
                  </div>
                </div>
                <div class="form-group col-sm-6">
                  <label for="daftar-tempat-lahir">Tempat Lahir</label>
                  <input type="text" class="form-control" name="daftar_tempat_lahir" id="daftar-tempat-lahir" placeholder="Tempat Lahir">
                </div>
                <div class="form-group col-sm-6">
                  <label for="daftar-tgl-lahir">Tgl Lahir</label>
                  <input type="date" class="form-control" name="daftar_tgl_lahir" id="daftar-tgl-lahir" placeholder="Tgl Lahir">
                </div>
                <div class="form-group col-sm-3">
                  <label for="daftar-tgl-lahir">Foto</label>
                  <p><img src="" class="img img-rounded" id="upload-target" width="100%"></p>
                  <label class="form-control btn btn-info">
                  <input type="file" class="form-control" name="image" id="daftar-foto" data-target="#upload-target" 
                    data-default="{{asset('assets/img/avatar/avatar-1.png')}}" style="display: none;"> Unggah Foto
                  </label>
                </div>
                <div class="form-group col-sm-9">
                  <label for="daftar-ekskul">Ekskul</label>
                  <select class="form-control" name="daftar_ekskul" id="daftar-ekskul" placeholder="Pilih Ekskul">
                    <option value="">--Pilih--</option>
                    @foreach ($ekskuls as $item)
                      <option value="<?php echo $item->id; ?>">
                        Ekskul: <?php echo $item->nama_ekskul; ?> - Hari: <?php echo $item->hari; ?> - Pelatih: <?php echo $item->nama_pelatih; ?>
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Daftar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
          </form>
      </div>
  </div>
</div>
@endsection

@push('page-scripts')
  {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>  --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
@endpush

@push('after-script')
    <script>
      $('#form-data').validate({
        rules: {
          daftar_nis: {required: true, minlength: 8},
          daftar_nama: {required: true, maxlength: 50},
          daftar_kelas: {required: true, maxlength: 8},
          daftar_alamat: {required: true, maxlength: 200},
          daftar_no_telp: {required: true, maxlength: 12},
          daftar_jk: {required: true},
          daftar_tempat_lahir: {required: true, maxlength: 20},
          daftar_tgl_lahir: {required: true},
          daftar_ekskul: {required: true},
        },
        submitHandler: function(form) {
          ajaxData("{{ url('daftar_ekskul') }}/"+action+"", new FormData(form), refresh, true);
        }
      });

      function displayModalDaftar(){
        resetForm('#form-data');
        action = "daftar";
        $('#modal-daftar-ekskul').modal();
      }

      function refresh(result) {
          $('#modal-daftar-ekskul').modal('hide');

          alertSuccess(result.message);
          tableData.draw(false);
      }

      function setTableData() {
          var reqOrder = [[1, 'asc']];
          var reqData = null;
          var colDef = [
              { render: renderActionButton, targets: -1 },
          ];

          tableData = setDataTable('#table-data', "{{url('daftar_ekskul/read')}}", colDef, reqData, reqOrder);
      }

      function renderActionButton(data, type, row){
        var button = '<button type="button" class="btn btn-info btn-xs" onclick="detailData(\'' + row.id_pendaftaran + '\')"><i class="far fa-edit"></i></button>'+
                     '<button type="button" class="btn btn-danger btn-xs ml-1" onclick="swalDeleteConfirm(\'' + row.id_pendaftaran + '\')"><i class="far fa-trash-alt"></i></button>';
        return button;
      }

      function deleteData(id){

      }
      
      function detailData(id){
        var dataSet = tableData.rows().data();
        var data = dataSet.filter(function (index) {
          return index.id_pendaftaran == id;
        });

        resetForm('#form-data');
        action = "update_daftar";
        $("#id-siswa").val(data[0].id_siswa);
        $("#id-pendaftaran").val(data[0].id_pendaftaran);
        $("#daftar-nis").val(data[0].nis);
        $("#daftar-nama").val(data[0].nama_siswa);
        $("#daftar-kelas").val(data[0].kelas);
        $("#daftar-alamat").val(data[0].alamat);
        $("#daftar-no-telp").val(data[0].no_telp);
        $('input[name="daftar_jk"][value="' + data[0].jenis_kelamin + '"]').prop('checked', true);
        $("#daftar-tempat-lahir").val(data[0].tempat_lahir);
        $("#daftar-tgl-lahir").val(data[0].tanggal_lahir);
        $("#daftar-ekskul").val(data[0].id_ekskul);
        $("#upload-target").prop('src', "{{url('/')}}/images/" + data[0].gen_foto);

        $('#modal-daftar-ekskul').modal();
      }

      $(document).ready(function () {
        setTableData();

      });

      function swalDeleteConfirm(id){
        var dataSet = tableData.rows().data();
        var data = dataSet.filter(function (index) {
          return index.id_pendaftaran == id;
        });
       
        swal({
            title: 'Apakah kamu yakin akan menghapus data pendaftaran siswa ' + data[0].nama_siswa + '?',
            text: 'Setelah data dihapus, data tidak bisa di kembalikan',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                // $(`#delete${id}`).submit();
                ajaxData("{{ url('daftar_ekskul/delete_daftar') }}", { id_pendaftaran: id }, refresh);
            } else {
              swal('Your imaginary file is safe!');
            }
          });
      }

      // $(".swal-confirm").click(function(e) {
      //   let id = e.target.dataset.id;
      //   let name = e.target.dataset.name;
      //     swal({
      //         title: 'Apakah kamu yakin akan menghapus data ' + name + '?',
      //         text: 'Setelah data dihapus, data tidak bisa di kembalikan',
      //         icon: 'warning',
      //         buttons: true,
      //         dangerMode: true,
      //       })
      //       .then((willDelete) => {
      //         if (willDelete) {
      //             swal('Poof! Your imaginary file has been deleted!', {
      //               icon: 'success',
      //             });
      //             $(`#delete${id}`).submit();
      //         } else {
      //         swal('Your imaginary file is safe!');
      //         }
      //       });
      //   });
    </script>
@endpush