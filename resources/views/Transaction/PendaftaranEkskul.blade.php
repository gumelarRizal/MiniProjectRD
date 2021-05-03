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
      <div class="card-header">
        <h4>Table Siswa</h4>
      </div>
      <div class="card-body">
        <form action="">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Nama Ekskul</label>
                <input type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Kategori</label>
                <input type="text" class="form-control">
              </div>
            </div>
          </div>  
        </form>
        <div class="text-right">
          <a href="" id="button-daftar-ekskul" data-toggle="modal" data-target="#modal-daftar-ekskul" class="btn btn-primary"><i class="fa fa-plus"></i> Daftar</a>
          <a href="" class="btn btn-info"><i class="fa fa-search"></i> Search</a>
          {{-- <a href="" class="btn btn-secondary"><i class="fa fa-redo-alt"></i> Reset</a> --}}
        </div>
        <hr>
        <div class="table-responsive">
          <table class="table table-striped table-md">
            <tbody><tr>
              <th>#</th>
              <th>Siswa</th>
              <th>Ekskul</th>
              <th>Pembina</th>
              <th>Nilai</th>
              <th>Action</th>
            </tr>
            @foreach ($pendaftaran_ekskuls as $item)<?php $no = 0?>
              <tr>
                  <?php $no++?>
                  <td> {{$no}} </td>
                  <td>{{$item->nama_siswa}}</td>
                  <td>{{$item->nama_ekskul}}</td>
                  <td>{{$item->nama_pembina}}</td>
                  <td>{{$item->nilai}}</td>
                  <td>
                      <form  method="post" action ="{{ Route('daftar_ekskul.daftar')}}">
                      {{csrf_field()}}
                      <button type="submit" class="btn-xd btn-primary">Daftar</button>
                      </form>
                  </td>
              </tr>
            @endforeach
            
          </tbody></table>
        </div>
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
                  <p><img src="{{asset('assets/img/avatar/avatar-1.png')}}" class="img img-rounded" id="upload-target" width="100%"></p>
                  <label class="form-control btn btn-info">
                  <input type="file" class="form-control" name="image" id="daftar-foto" data-target="#upload-target" 
                    data-default="{{asset('assets/img/avatar/avatar-1.png')}}" style="display: none;"> Unggah Foto
                  </label>
                </div>
                <div class="form-group col-sm-9">
                  <label for="daftar-ekskul">Ekskul</label>
                  <select class="form-control" name="daftar_ekskul" id="daftar-ekskul" placeholder="Pilih Ekskul">
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
        },
        submitHandler: function(form) {
          ajaxData("{{ url('daftar_ekskul/daftar') }}", new FormData(form), refresh, true);
        }
      });

      function refresh(result) {
          $('#modal-daftar-ekskul').modal('hide');

          alertSuccess(result.message);
      }
      
      $(document).ready(function () {
        

        // $("#daftar_ekskul").select2({
        //     placeholder: 'Pilih Eskul',
        //     minimumInputLength: 1,
        //     multiple: false,
        //     ajax: {
        //         url: "{{route('daftar_ekskul.get_ekskul')}}",
        //         type: "GET",
        //         dataType: 'json',
        //         data: function (params) {
        //           return {
        //             // _token: CSRF_TOKEN,
        //             search: params.term // search term
        //           };
        //         },
        //         processResults: function (response) {
        //           return {
        //             results: response
        //           };
        //         },
        //         cache: true
        //     }
        // });
      });

      

      $(".swal-confirm").click(function(e) {
        let id = e.target.dataset.id;
        let name = e.target.dataset.name;
          swal({
              title: 'Apakah kamu yakin akan menghapus data ' + name + '?',
              text: 'Setelah data dihapus, data tidak bisa di kembalikan',
              icon: 'warning',
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                  swal('Poof! Your imaginary file has been deleted!', {
                    icon: 'success',
                  });
                  $(`#delete${id}`).submit();
              } else {
              swal('Your imaginary file is safe!');
              }
            });
        });
    </script>
@endpush