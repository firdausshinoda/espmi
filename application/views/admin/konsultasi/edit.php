<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 mt-3">
				<form id="formValidate" class="formValidate">
					<div class="card shadow">
						<div class="card-header">
							<b>Edit Dokumen Konsultasi</b>
						</div>
						<div class="card-body">
							<input type='hidden' class="csrf" />
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Judul</b></small></label>
								<input type="text" class="form-control form-control-sm" id="judul" name="judul" value="<?= $detail->nama_dokumen; ?>" placeholder="Silahkan diisi..."/>
								<input type="hidden" id="id" name="id" value="<?= $detail->id_tb_konsultasi; ?>"/>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Deskripsi</b></small></label>
								<textarea class="form-control form-control-sm" id="deskripsi" name="deskripsi" placeholder="Silahkan diisi..." rows="7"><?= $detail->deskripsi_dokumen; ?></textarea>
							</div>
							<hr>
							<div class="card bg-light">
								<div class="card-body">
									<div class="row">
										<div class="col-sm-2">
											<center><i class="far fa-file-pdf" style="font-size: 68px;"></i></center>
										</div>
										<div class="col-sm-10">
											<div class="row">
												<div class="col-sm-12 col-md-7">
													<div class="form-group">
														<label><small>Nama File</small></label>
														<input type="text" class="form-control form-control-sm" id="nama_file" name="nama_file" placeholder="Silahkan diisi..." value="<?= $detail->file_nama; ?>" readonly>
													</div>
												</div>
												<div class="col-sm-12 col-md-5">
													<div class="form-group">
														<label><small>Size File</small></label>
														<input type="text" class="form-control form-control-sm" id="size_file" name="size_file" placeholder="Silahkan diisi..." value="<?= $detail->file_size; ?> Kb" disabled>
													</div>
												</div>
												<div class="col-sm-12 col-md-4">
													<div class="form-group">
														<label><small>Jumlah Halaman</small></label>
														<input type="text" class="form-control form-control-sm" id="jml_halaman" name="jml_halaman" placeholder="Silahkan diisi..." value="<?= $detail->jml_halaman; ?>">
													</div>
												</div>
												<div class="col-sm-12 col-md-4">
													<div class="form-group">
														<label><small>Bulan</small></label>
														<select class="form-control form-control-sm" id="bln_dokumen" name="bln_dokumen">
															<option value="<?= $detail->bln_dokumen; ?>"><?= $detail->bln_dokumen; ?></option>
															<?php foreach (getBulan() as $bln):?>
																<option value="<?= $bln; ?>"><?= $bln; ?></option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
												<div class="col-sm-12 col-md-4">
													<div class="form-group">
														<label><small>Tahun</small></label>
														<input type="text" class="form-control form-control-sm" id="thn_dokumen" name="thn_dokumen" placeholder="Silahkan diisi..." value="<?= $detail->thn_dokumen; ?>">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-primary btn-sm float-right m-1">Simpan</button>
							<button type="button" class="btn btn-danger btn-sm float-right m-1" onclick="history.back()">Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    $('#treeview_dokspmi').addClass("menu-open");
    $('#i_konsultasi').addClass("active");

    $(function() {
		setCSRF();
        $('#formValidate').validate({
            rules: {
                judul:"required",deskripsi:"required",nama_file:"required",
				jml_halaman:{required:true, digits: true,}, thn_dokumen:{required:true, digits: true, maxlength:4},
            },
            messages: {
                judul:"Silahkan diisi..",deskripsi:"Silahkan diisi..",nama_file:"Silahkan pilih file..",
                jml_halaman:{required:"Silahkan diisi..", digits: "Hanya boleh angka",},
				thn_dokumen:{required:"Silahkan diisi..", digits: "Hanya boleh angka", maxlength:"Maksimal 4 digit"},
            },
            submitHandler: function(form) {
                $('#progressBar').show();
                swalWithBootstrapButtons.fire({
                    text: 'Apakah anda yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    showLoaderOnConfirm: true,
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            var form = $('#formValidate')[0];
                            var formData = new FormData(form);
                            $('#progress-upload').show();
                            $.ajax({
                                xhr : function() {
                                    var xhr = new window.XMLHttpRequest();
                                    xhr.upload.addEventListener('progress', function(e){
                                        if(e.lengthComputable){
                                            console.log('Bytes Loaded : ' + e.loaded);
                                            console.log('Total Size : ' + e.total);
                                            console.log('Persen : ' + (e.loaded / e.total));
                                            var percent = Math.round((e.loaded / e.total) * 100);
                                            $('#progressBar').css('width', percent + '%');
                                        }
                                    });
                                    return xhr;
                                },
                                type: "POST", data: formData, dataType: 'json',
                                processData: false, contentType: false,
                                url: "<?= site_url('Api/api_updateKonsultasi'); ?>",
                                success: function (data) {
                                    $('#progress-upload').hide();
                                    if (data.response.status==="OK"){
                                        swalWithBootstrapButtons.fire({title: 'Berhasil.', text: "", icon: 'success',}).
                                        then((result) => {if (result.value) {history.back();}});
                                    } else {
                                        alertError('Gagal Menambahkan Data!');
                                    }
                                },
                                error: function (data) {
                                    $('#progress-upload').hide();
                                    alertError('Terjadi Kesalahan. Silahkan coba lagi!!!')
                                }
                            });
                        })
                    },
                    allowOutsideClick: false,
                });
            }
        });
    });
</script>
