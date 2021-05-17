
<div id="modal-mm-ekskul" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                <input type="hidden" name="id_pendaftaran" id="id-pendaftaran">
                <input type="hidden" name="id_siswa" id="id-siswa">
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
                <div class="form-group col-sm-6">
                  <label for="daftar-tgl-lahir">Ekskul Wajib</label>
                  <select class="form-control" name="daftar_ekskul" id="daftar-ekskul" placeholder="Pilih Ekskul">
                    <option value="">--Pilih--</option>
                    {{-- @foreach ($ekskuls as $item)
                    <option value="<?php echo $item->id; ?>">
                      Ekskul: <?php echo $item->nama_ekskul; ?> - Hari: <?php echo $item->hari; ?> - Pelatih: <?php echo $item->nama_pelatih; ?>
                    </option>
                    @endforeach --}}
                  </select>
                </div>
                <div class="form-group col-sm-6">
                  <label for="daftar-ekskul">Ekskul optional</label>
                  <select class="form-control" name="daftar_ekskul" id="daftar-ekskul" placeholder="Pilih Ekskul">
                    <option value="">--Pilih--</option>
                    {{-- @foreach ($ekskuls as $item)
                    <option value="<?php echo $item->id; ?>">
                      Ekskul: <?php echo $item->nama_ekskul; ?> - Hari: <?php echo $item->hari; ?> - Pelatih: <?php echo $item->nama_pelatih; ?>
                    </option>
                    @endforeach --}}
                  </select>
                </div>
                <div class="form-group col-sm-3">
                  <label for="daftar-tgl-lahir">Foto</label>
                  <p><img src="" class="img img-rounded" id="upload-target" width="100%"></p>
                  <label class="form-control btn btn-info">
                  <input type="file" class="form-control" name="image" id="daftar-foto" data-target="#upload-target" 
                    data-default="{{asset('assets/img/avatar/avatar-1.png')}}" style="display: none;"> Unggah Foto
                  </label>
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