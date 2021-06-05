@extends('Layouts.MainLayouts')
@section('title')
    {{-- <h1>{{$pages}}</h1> --}}
@endsection
@section('content')
<div class="card">
    <div class="row">
      <div class="col-12">
        <div class="card-header">
          <h4>Data Ekskul</h4>
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
                <a href="{{ url('ekskul/add') }}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Data</a>
            </div>
            <br>
            <table id="table-data" class="table table-bordered table-striped">
                <thead>
                    <tr class="font-weight-bold">
                        <td>#</td>
                        <td>Nama Ekskul</td>
                        <td>Pembina</td>
                        <td>Kategori</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ekskuls as $item)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$item->nama_ekskul}}</td>
                        <td>{{$item->nama}}</td>
                        <td>{{$item->kategori}}</td>
                        <td class="text-center">
                            <a href="{{ url('ekskul/edit/' .$item->id ) }}" class="btn btn-primary btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a> |
                            <form action="{{ url('ekskul/delete/' .$item->id ) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin Hapus Ekskul: <?=$item->nama_ekskul?> ? ')">
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