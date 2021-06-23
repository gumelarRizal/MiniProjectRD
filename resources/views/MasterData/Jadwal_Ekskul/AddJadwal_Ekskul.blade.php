@extends('Layouts.MainLayouts')
@section('title')
    {{-- <h1>{{$pages}}</h1> --}}
@endsection
@section('content')
<div class="card">
    <div class="row">
      <div class="col-12">
        <div class="card-header">
          <h4>Tambah - Data Jadwal Ekskul</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Jadwal Ekskul</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{url('jadwal_ekskul/addProcess')}}" method="post" enctype="multipart/form-data" onsubmit="return confirm('Apakah Data Akan Disimpan ? ')">
                                @csrf
                                <div class="form-group">
                                    <label for="">Nama Pelatih</label>
                                    <select name="id_pelatih" id="barang" class="form-control">
                                        @foreach ($pelatihs as $item)
                                        <option value="{{$item->id }}">{{$item->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Ekskul</th>
                                            <th>Hari</th>
                                            <th>Tempat</th>
                                            <th class="text-center">
                                                <a href="javascript:;" class="btn btn-info addRow" id="addRow"><i class="fas fa-plus"></i></a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="id_ekskul[]" id="id_ekskul" class="form-control">
                                                    @foreach ($ekskuls as $item)
                                                    <option value="{{$item->id }}">{{$item->id }} : {{$item->nama_ekskul}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="hari[]" id="hari" class="form-control">
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                    <option value="Sabtu">Sabtu</option>
                                                    <option value="Minggu">Minggu</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="tempat[]" class="form-control" value="{{ old('tempat') }}" required autofocus>
                                            </td>
                                            <td class="text-center"><a href="javascript:;" class="btn btn-danger deleteRow"><i class="far fa-trash-alt"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
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
                <div class="col-md-1"></div>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection

@push('after-script')
<script>
    $(function () {


    $('#addRow').on('click', function(){
            var tr = 
            '<tr>'+
                '<td>'+
                    '<select name="id_ekskul[]" id="id_ekskul" class="form-control">'+
                        @foreach ($ekskuls as $item)
                        '<option value="{{$item->id }}">{{$item->id }} : {{$item->nama_ekskul}}</option>'+
                        @endforeach
                    '</select>'+
                '</td>'+
                '<td>'+
                    '<select name="hari[]" id="hari" class="form-control">'+
                        '<option value="Senin">Senin</option>'+
                        '<option value="Selasa">Selasa</option>'+
                        '<option value="Rabu">Rabu</option>'+
                        '<option value="Kamis">Kamis</option>'+
                        '<option value="Jumat">Jumat</option>'+
                        '<option value="Sabtu">Sabtu</option>'+
                        '<option value="Minggu">Minggu</option>'+
                    '</select>'+
                '</td>'+
                '<td>'+
                    '<input type="text" name="tempat[]" class="form-control" value="{{ old('tempat') }}" required autofocus>'+
                '</td>'+
                '<td class="text-center"><a href="javascript:;" class="btn btn-danger deleteRow"><i class="far fa-trash-alt"></i></a></td>'+
            '</tr>';
            
            $('table tbody').append(tr);
        });

        $('tbody').on('click', '.deleteRow', function(){
            $(this).parent().parent().remove();
        });
    });
</script>
@endpush
