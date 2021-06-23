@extends('Layouts.MainLayouts')
@section('title')
    {{-- <h1>{{$pages}}</h1> --}}
@endsection
@section('content')
<div class="card">
    <div class="row">
      <div class="col-12">
        <div class="card-header">
          <h4>Edit - Data Jadwal Ekskul</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit Jadwal Ekskul</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{url('jadwal_ekskul/editProcess/' .$jadwal_eksulss->id)}}" method="post" enctype="multipart/form-data" onsubmit="return confirm('Apakah Data Akan diUbah ? ')">
                                @csrf
                                <div class="form-group">
                                    <label for="">Nama Pelatih</label>
                                    <input type="text" name="nip" class="form-control" value="{{ $jadwal_eksulss->nama }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Ekskul</label>
                                    <select name="id_ekskul" id="id_ekskul" class="form-control">
                                        @foreach ($ekskuls as $item)
                                        <option value="{{$item->id }}" {{old('id_ekskul', $item->id) == $jadwal_eksulss->id_ekskul ? 'selected' : ''}}>{{$item->id }} : {{$item->nama_ekskul}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Hari</label>
                                    <select name="hari" id="hari" class="form-control">
                                        <option value="Senin" {{old('hari', $jadwal_eksulss->hari) == "Senin" ? 'selected' : ''}}>Senin</option>
                                        <option value="Selasa" {{old('hari', $jadwal_eksulss->hari) == "Selasa" ? 'selected' : ''}}>Selasa</option>
                                        <option value="Rabu" {{old('hari', $jadwal_eksulss->hari) == "Rabu" ? 'selected' : ''}}>Rabu</option>
                                        <option value="Kamis" {{old('hari', $jadwal_eksulss->hari) == "Kamis" ? 'selected' : ''}}>Kamis</option>
                                        <option value="Jumat" {{old('hari', $jadwal_eksulss->hari) == "Jumat" ? 'selected' : ''}}>Jumat</option>
                                        <option value="Sabtu" {{old('hari', $jadwal_eksulss->hari) == "Sabtu" ? 'selected' : ''}}>Sabtu</option>
                                        <option value="Minggu" {{old('hari', $jadwal_eksulss->hari) == "Minggu" ? 'selected' : ''}}>Minggu</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Tempat</label>
                                    <input type="text" name="tempat" class="form-control @error('tempat') is-invalid @enderror" value="{{ old('tempat', $jadwal_eksulss->tempat) }}" autofocus>
                                    @error('tempat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr style="border: 1px solid;" class="text-danger">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ url('jadwal_ekskul') }}" class="btn btn-danger btn-block">
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
