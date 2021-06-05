@extends('Layouts.MainLayouts')
@section('title')
    {{-- <h1>{{$pages}}</h1> --}}
@endsection
@section('content')
<div class="card">
    <div class="row">
      <div class="col-12">
        <div class="card-header">
          <h4>Tambah - Data Ekskul</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Ekskul</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{url('ekskul/addProcess')}}" method="post" enctype="multipart/form-data" onsubmit="return confirm('Apakah Data Akan Disimpan ? ')">
                                @csrf
                                <div class="form-group">
                                    <label for="">Nama Ekskul</label>
                                    <input type="text" name="nama_ekskul" class="form-control @error('nama_ekskul') is-invalid @enderror" value="{{ old('nama_ekskul') }}" autofocus>
                                    @error('nama_ekskul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="Wajib">Wajib</option>
                                        <option value="Optional">Optional</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Pembina</label>
                                    <select name="id_pembina" id="id_pembina" class="form-control">
                                        @foreach ($pembinas as $item)
                                        <option value="{{$item->id}}">{{$item->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ url('ekskul') }}" class="btn btn-danger btn-block">
                                            <i class="fas fa-times-circle"></i> Cancel
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection
