@extends('Layouts.MainLayouts')
@section('title')
    <h1>{{$pages}}</h1>
@endsection
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
                <label for="">NIS</label>
                <input type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Nama Siswa</label>
                <input type="text" class="form-control">
              </div>
            </div>
          </div>  
        </form>
        <div class="text-right">
          <a href="" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
          <a href="" class="btn btn-info"><i class="fa fa-search"></i> Search</a>
          <a href="" class="btn btn-secondary"><i class="fa fa-redo-alt"></i> Reset</a>
        </div>
        <hr>
        <div class="table-responsive">
          <table class="table table-striped table-md">
            <tbody><tr>
              <th>#</th>
              <th>NIS</th>
              <th>Nama Siswa</th>
              <th>Kelas</th>
              <th>Alamat</th>
              <th>Tempat Tanggal Lahir</th>
              <th>Jenis Kelamin</th>
              <th>No Telfon</th>
              <th>Action</th>
            </tr>
            @foreach ($siswa as $item)<?php $no = 0?>
              <tr>
                  <?php $no++?>
                  <td> {{$no}} </td>
                  <td>{{$item->NIS}}</td>
                  <td>{{$item->nama_siswa}}</td>
                  <td>{{$item->kelas_siswa}}</td>
                  <td>{{$item->alamat_siswa}}</td>
                  <td>{{$item->tempat_lahir .' '.$item->tanggal_lahir}}</td>
                  @if ($item->jenis_kelamin == "L")
                      <td>Laki-laki</td>
                  @else
                      <td>Perempuan</td>
                  @endif
                  <td>{{$item->no_telp}}</td>
                  <td><a href="#" data-id="{{$item->ID}}" data-name="{{$item->nama_siswa}}" class="btn btn-secondary swal-confirm">
                    <form action="{{route('siswa.delete',$item->ID)}}" id="delete{{$item->ID}}" method="POST">
                    @csrf
                    @method('delete')
                    </form>
                    Delete</a></td>
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
@push('page-scripts')
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
@endpush

@push('after-script')
    <script>
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