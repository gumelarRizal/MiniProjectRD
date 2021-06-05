@extends('Layouts.MainLayouts')
@section('title')
    {{-- <h1>{{$pages}}</h1> --}}
@endsection
@section('content')
<div class="card">
    <div class="row">
      <div class="col-12">
        <div class="card-header">
          <h4>Edit - Data Siswa</h4>
        </div>
        <div class="card-body">
            <form action="{{url('siswa/editProcess/' .$siswaa->id)}}" method="post" enctype="multipart/form-data" onsubmit="return confirm('Apakah Data Akan Disimpan ? ')">
            @csrf
                <div class="row">{{-- Row Start--}}
                    {{-- Bagian Kiri--}}
                    <div class="col-md-6">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                              <h3 class="card-title">Data 1</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">NIS Siswa</label>
                                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $siswaa->nis) }}" autofocus maxlength="8">
                                    @error('nis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Siswa</label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $siswaa->nama) }}" autofocus>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Kelas</label>
                                    <select name="kelas" id="kelas" class="form-control">
                                        @foreach ($kelass as $item)
                                        <option value="{{$item->nama_kelas}}" {{old('kelas', $item->nama_kelas) == $siswaa->kelas ? 'selected' : ''}}>{{$item->nama_kelas}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Jenis Kelamin</label>
                                    <div class="form-group">
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                              <input type="radio" name="jenis_kelamin" value="L" class="selectgroup-input" {{ ($siswaa->jenis_kelamin=="L")? "checked" : "" }}>
                                              <span class="selectgroup-button">Laki-laki</span>
                                            </label>
                                            <label class="selectgroup-item">
                                              <input type="radio" name="jenis_kelamin" value="P" class="selectgroup-input" {{ ($siswaa->jenis_kelamin=="P")? "checked" : "" }}>
                                              <span class="selectgroup-button">Perempuan</span>
                                            </label>
                                          </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <textarea name="alamat" class="form-control" value="{{ old('alamat', $siswaa->alamat) }}" rows="3" placeholder="Alamat Siswa" autofocus required>{{ $siswaa->alamat }}</textarea>
                                </div>
                                <hr style="border: 1px solid;" class="text-danger">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ url('siswa') }}" class="btn btn-danger btn-block">
                                            <i class="fas fa-times-circle"></i> Cancel
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>{{-- Bagian Kiri End--}}
        
                    {{-- Bagian Kanan--}}
                    <div class="col-md-6">
                        <div class="card card-danger card-outline">
                            <div class="card-header">
                              <h3 class="card-title">Data 2</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">No Handphone</label>
                                    <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $siswaa->no_telp) }}" autofocus oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g);" maxlength="12">
                                    @error('no_telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $siswaa->tempat_lahir) }}" autofocus>
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" autofocus required value="{{ old('tanggal_lahir', $siswaa->tanggal_lahir) }}">
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Foto</label>
                                    <p><img src="{{asset('images/' .$siswaa->ori_foto)}}" class="img img-rounded" id="upload-target" width="100%" style="border: 1px solid #555;"></p>
                                    <label class="form-control btn btn-info">
                                    <input type="file" class="form-control" name="image" id="daftar-foto" data-target="#upload-target" value="{{ old('image', $siswaa->ori_foto) }}" style="display: none;"> Unggah Foto
                                    </label>
                                  </div>
                            </div>
                        </div>
                    </div>{{-- Bagian Kanan End--}}
                </div>{{-- Row End--}}
            </form>
            

        </div>
      </div>
    </div>
</div>
@endsection
