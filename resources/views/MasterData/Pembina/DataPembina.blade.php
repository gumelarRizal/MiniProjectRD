@extends('Layouts.MainLayouts')
@section('title')
    {{-- <h1>{{$pages}}</h1> --}}
@endsection
@section('content')
<div class="card">
    <div class="row">
      <div class="col-12">
        <div class="card-header">
          <h4>Data Pembina</h4>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    <span class="badge badge-pill badge-primary">Success</span>
                    {{ session('status') }} 
                    </div>
                </div>
            @endif

            <div class="">
                <a href="{{ url('pembina/add') }}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Data</a>
            </div>
            <br>
            <table id="table-data" class="table table-bordered table-striped">
                <thead>
                    <tr class="font-weight-bold">
                        <td>#</td>
                        <td>NIP</td>
                        <td>Nama</td>
                        <td>Jenis Kelamin</td>
                        <td>Jabatan</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembinas as $item)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$item->nip}}</td>
                        <td>{{$item->nama}}</td>
                        <td>{{$item->jenis_kelamin}}</td>
                        <td>{{$item->jabatan}}</td>
                        <td class="text-center">
                            <a href="{{ url('pembina/edit/' .$item->nip ) }}" class="btn btn-primary btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a> |
                            <form action="{{ url('pembina/delete/' .$item->nip ) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin Hapus Pembina Nip: <?=$item->nip?> & Nama: <?=$item->nama?> ? ')">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>
</div>
@endsection

@push('after-script')
<script>
    $(document).ready(function () {
        $("#table-data").DataTable();
    });
</script>
@endpush