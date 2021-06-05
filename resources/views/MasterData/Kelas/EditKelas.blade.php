@extends('Layouts.MainLayouts')
@section('title')
    {{-- <h1>{{$pages}}</h1> --}}
@endsection
@section('content')
<div class="card">
    <div class="row">
      <div class="col-12">
        <div class="card-header">
          <h4>Edit - Data Kelas</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit Kelas</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{url('kelas/editProcess/' .$kelasa->id)}}" method="post" enctype="multipart/form-data" onsubmit="return confirm('Apakah Data Akan diUbah ? ')">
                                @csrf
                                <div class="form-group">
                                    <label for="">Nama Kelas</label>
                                    <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" value="{{ old('nama_kelas', $kelasa->nama_kelas) }}" autofocus>
                                    @error('nama_kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr style="border: 1px solid;" class="text-danger">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ url('kelas') }}" class="btn btn-danger btn-block">
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
