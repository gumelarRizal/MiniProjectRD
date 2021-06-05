@extends('Layouts.MainLayouts')
@section('title')
    {{-- <h1>{{$pages}}</h1> --}}
@endsection
@section('content')
<div class="card">
    <div class="row">
      <div class="col-12">
        <div class="card-header">
          <h4>Edit - Data Pembina</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit Pembina</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{url('pembina/editProcess/' .$pembinaa->nip)}}" method="post" enctype="multipart/form-data" onsubmit="return confirm('Apakah Data Akan diUbah ? ')">
                                @csrf
                                <div class="form-group">
                                    <label for="">NIP Pembina</label>
                                    <input type="text" name="nip" class="form-control" value="{{ $pembinaa->nip }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Pembina</label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $pembinaa->nama) }}" autofocus>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Jenis Kelamin</label>
                                    <div class="form-group">
                                        <div class="selectgroup w-100">
                                          <label class="selectgroup-item">
                                            <input type="radio" name="jenis_kelamin" value="L" class="selectgroup-input" {{ ($pembinaa->jenis_kelamin=="L")? "checked" : "" }}>
                                            <span class="selectgroup-button">Laki-laki</span>
                                          </label>
                                          <label class="selectgroup-item">
                                            <input type="radio" name="jenis_kelamin" value="P" class="selectgroup-input" {{ ($pembinaa->jenis_kelamin=="P")? "checked" : "" }}>
                                            <span class="selectgroup-button">Perempuan</span>
                                          </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Jabatan Pembina</label>
                                    <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $pembinaa->jabatan) }}" autofocus>
                                    @error('jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ url('pembina') }}" class="btn btn-danger btn-block">
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
