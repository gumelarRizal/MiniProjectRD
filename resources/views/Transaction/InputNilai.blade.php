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
                    <th data-orderable="true" data-data="nilai_ekskul_wajib">Nilai Ekskul Wajib</th>
                    <th data-orderable="true" data-data="nama_ekskul_opt">Ekskul Optional</th>
                    <th data-orderable="true" data-data="nilai_ekskul_opt">Nilai Ekskul Optional</th>
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
<div id="modal-input-nilai" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h3 class="modal-title" id="modal-title"> Input Nilai </h3> 
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
                <input type="hidden" name="tipe_nilai" id="tipe-nilai">
                <div class="form-group col-sm-12">
                  <label for="daftar-nis">Masukan Nilai</label>
                  <input type="number" class="form-control" name="input_nilai" id="input-nilai" placeholder="Nilai">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
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
          input_nilai: {required: true}
        },
        submitHandler: function(form) {
          ajaxData("{{ url('input_nilai') }}/"+action+"", new FormData(form), refresh, true);
        }
      });

      function displayInputNilaiModal(id, type){
        resetForm('#form-data');
        action = "store";
        
        if(type == 1){
          $("#modal-title").html("Input Nilai Ekskul Wajib");
        }
        else{
          $("#modal-title").html("Input Nilai Ekskul Optional");
        }
        $("#id-pendaftaran").val(id);
        $("#tipe-nilai").val(type);
        $('#modal-input-nilai').modal();
      }

      function refresh(result) {
          $('#modal-input-nilai').modal('hide');

          alertSuccess(result.message);
          tableData.draw(false);
      }

      function setTableData() {
          var reqOrder = [[1, 'asc']];
          var reqData = null;
          var colDef = [
              { render: renderActionButton, targets: -1 },
              { render: renderNilaiEkskulWajib, targets: 4 },
              { render: renderEkskulOpt, targets: 5 },
              { render: renderNilaiEkskulOpt, targets: 6 },
          ];

          tableData = setDataTable('#table-data', "{{url('input_nilai/read')}}", colDef, reqData, reqOrder);
      }

      function renderActionButton(data, type, row){
        var button = '<button type="button" class="btn btn-info btn-xs" onclick="displayInputNilaiModal(\'' + row.id_pendaftaran + '\', 1)"><i class="far fa-edit"></i> Ekskul Wajib</button>'+
                     '<button type="button" class="btn btn-warning btn-xs ml-1" onclick="displayInputNilaiModal(\'' + row.id_pendaftaran + '\', 2)"><i class="far fa-edit"></i> Ekskul Optional</button>';
        return button;
      }

      function renderNilaiEkskulWajib(data, type, row){
        if(!row.nilai_ekskul_wajib)
          return 'Tidak Ada';
          
        return row.nilai_ekskul_wajib;
      }

      function renderNilaiEkskulOpt(data, type, row){
        if(!row.nilai_ekskul_optional)
          return 'Tidak Ada';
          
        return row.nilai_ekskul_optional;
      }

      function renderEkskulOpt(data, type, row){
        if(!row.nama_ekskul_opt)
          return 'Tidak Ada';
          
        return row.nama_ekskul_opt;
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

        $('#modal-input-nilai').modal();
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