<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 mt-3">
				<form id="formValidate" class="formValidate">
					<div class="card shadow">
						<div class="card-header">
							<b>Tambah Dokumen Institusi</b>
						</div>
						<div class="card-body">
							<input type='hidden' class="csrf" />
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Judul</b></small></label>
								<input type="text" class="form-control form-control-sm" id="judul" name="judul" placeholder="Silahkan diisi..."/>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Deskripsi</b></small></label>
								<textarea class="form-control form-control-sm" id="deskripsi" name="deskripsi" placeholder="Silahkan diisi..." rows="7"></textarea>
							</div>
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1"><small><b>Kategori Dokumen</b></small></label>
								<select type="text" class="form-control form-control-sm" id="jenis_dokumen" name="jenis_dokumen" onchange="selectKode(this.value)">
									<?php if (empty($detail->jenis_dokumen)):?>
										<option value="">--Silahkan Dipilih Sebelum Memilih Standar Terkait--</option>
									<?php else:?>
										<option value="<?= $detail->jenis_dokumen; ?>"><?= $detail->jenis_dokumen; ?></option>
									<?php endif;?>
									<option value="Standar SPMI">Standar SPMI</option>
									<option value="Manual Mutu Penetapan">Manual Mutu Penetapan</option>
									<option value="Manual Mutu Pelaksanaan">Manual Mutu Pelaksanaan</option>
									<option value="Manual Mutu Evaluasi">Manual Mutu Evaluasi</option>
									<option value="Manual Mutu Pengendalian">Manual Mutu Pengendalian</option>
									<option value="Manual Mutu Peningkatan">Manual Mutu Peningkatan</option>
									<option value="Formulir">Formulir</option>
									<option value="Kebijakan">Kebijakan</option>
								</select>
							</div>
							<div class="col-sm-12">
								<div class="row">
									<div class="form-group col-sm-8">
										<label for="exampleInputEmail1"><small><b>Standar Terkait</b></small></label>
										<select class="form-control form-control-sm select2" id="kode_no" name="kode_no" style="width: 100%;">
											<?php if (empty($detail->id_tb_dokumen_kode)):?>
												<option value="">--Silahkan Pilih Jenis Dokumen Terlelbih Dahulu--</option>
											<?php else:?>
												<option value="<?= $detail->id_tb_dokumen_kode; ?>"><?= $detail->nomor_dokumen." - ".$detail->jenis_dokumen_kode; ?></option>
											<?php endif;?>
										</select>
									</div>
									<div class="form-group col-sm-4">
										<label for="exampleInputEmail1"><small><b>Tambah Kode Standar Terkait</b></small></label>
										<button type="button" class="btn btn-primary btn-sm btn-block" onclick="addKode(true)">Tambah</button>
									</div>
								</div>
							</div>
							<div class="display_none col-sm-12" id="viewAddKode">
								<div class="row">
									<div class="form-group col-sm-8">
										<label for="exampleInputEmail1"><small><b>Kode Tambahan Standar Terkait</b></small></label>
										<input type="hidden" id="jenis_dokumen_tambahan" name="jenis_dokumen_tambahan"/>
										<input type="text" class="form-control form-control-sm" id="kode_tambahan" name="kode_tambahan" value="" placeholder="Silahkan diisi..."/>
									</div>
									<div class="form-group col-sm-4">
										<label for="exampleInputEmail1"><small><b>Opsi</b></small></label>
										<button type="button" class="btn btn-danger btn-sm btn-block" onclick="addKode(false)">Batal</button>
									</div>
									<div class="form-group col-sm-12">
										<label for="exampleInputEmail1"><small><b>Perihal Dokumen</b></small></label>
										<textarea class="form-control form-control-sm" id="perihal_dokumen_tambahan" name="perihal_dokumen_tambahan" placeholder="Silahkan diisi..." rows="7"></textarea>
									</div>
								</div>
							</div>
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1"><small><b>Dibuat Oleh Unit</b></small></label>
								<select class="form-group form-control-sm select2" id="unit_pembuat" name="unit_pembuat" style="width: 100%"></select>
							</div>
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1"><small><b>Unit Terkait</b></small></label>
								<select class="select2" multiple="multiple" id="unit_terkait" name="unit_terkait[]" style="width: 100%"></select>
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
														<input type="text" class="form-control form-control-sm" id="nama_file" name="nama_file" placeholder="Silahkan diisi..." readonly>
													</div>
												</div>
												<div class="col-sm-12 col-md-3">
													<div class="form-group">
														<label><small>Size File</small></label>
														<input type="text" class="form-control form-control-sm" id="size_file" name="size_file" placeholder="Silahkan diisi..." readonly>
													</div>
												</div>
												<div class="col-sm-12 col-md-2">
													<div class="form-group">
														<label><small>Pilih PDF</small></label>
														<span class="btn btn-sm btn-primary btn-block btn-file"><i class="fa fa-folder-open"></i> <input type="file" id="file" name="file" accept=".pdf" onchange="previewFile()"></span>
													</div>
												</div>
												<div class="col-sm-12 col-md-3">
													<div class="form-group">
														<label><small>Jumlah Halaman</small></label>
														<input type="text" class="form-control form-control-sm" id="jml_halaman" name="jml_halaman" placeholder="Silahkan diisi...">
													</div>
												</div>
												<div class="col-sm-12 col-md-3">
													<div class="form-group">
														<label><small>Bulan</small></label>
														<select class="form-control form-control-sm" id="bln_dokumen" name="bln_dokumen">
															<?php foreach (getBulan() as $bln):?>
																<option value="<?= $bln; ?>"><?= $bln; ?></option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
												<div class="col-sm-12 col-md-3">
													<div class="form-group">
														<label><small>Tahun</small></label>
														<input type="text" class="form-control form-control-sm" id="thn_dokumen" name="thn_dokumen" placeholder="Silahkan diisi...">
													</div>
												</div>
												<div class="col-sm-12 col-md-3">
													<div class="form-group">
														<label><small>Jumlah Revisi</small></label>
														<input type="text" class="form-control form-control-sm" id="revisi" name="revisi" placeholder="Silahkan diisi...">
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
	$('#i_dokumen').addClass("active");

	var kode_dokumen = "";
	$(function() {
		setCSRF();
		$('#unit_terkait').select2({
			ajax: {
				url: '<?= site_url('Api/selectUnit'); ?>',
				type: "post", dataType: 'json', delay: 250,
				data: function (params) {return { search: params.term, page: params.page || 1, [csrfName]: csrfHash };},
				processResults: function (data) {
					newCSRF(data.csrfName,data.csrfHash);
					return {results: data.results, pagination: {more: data.morePages},};
				}, cache: true
			}
		});
		$('#unit_pembuat').select2({
			ajax: {
				url: '<?= site_url('Api/selectUnit'); ?>',
				type: "post", dataType: 'json', delay: 250,
				data: function (params) {return { search: params.term, page: params.page || 1, [csrfName]: csrfHash };},
				processResults: function (data) {
					newCSRF(data.csrfName,data.csrfHash);
					return {results: data.results, pagination: {more: data.morePages},};
				}, cache: true
			}
		});
		$('#formValidate').validate({
			rules: {
				judul:"required",deskripsi:"required",nama_file:"required",size_file:"required",unit_pembuat:"required",
				jml_halaman:{required:true, digits: true,}, thn_dokumen:{required:true, digits: true, maxlength:4},
				"unit_terkait[]": "required", revisi:{required:true, digits: true },
			},
			messages: {
				judul:"Silahkan diisi..",deskripsi:"Silahkan diisi..",nama_file:"Silahkan pilih file..",size_file:"Silahkan pilih file..",
				unit_pembuat:"Silahkan dipilih..", jml_halaman:{required:"Silahkan diisi..", digits: "Hanya boleh angka",},
				thn_dokumen:{required:"Silahkan diisi..", digits: "Hanya boleh angka", maxlength:"Maksimal 4 digit"},
				"unit_terkait[]":"Silahkan dipilih...", revisi:{required:"Silahkan diisi..", digits: "Hanya boleh angka", },
			},
			ignore: [],
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
								url: "<?= site_url('Api/api_inputDokumen'); ?>",
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

	function selectKode(str) {
		if (str !== null || str !== ""){
			$('#jenis_dokumen_tambahan').val(str);
			$('#kode_no').select2({
				ajax: {
					url: '<?= site_url('Api/selectKode'); ?>',
					type: "post", dataType: 'json', delay: 250,
					data: function (params) {return { search: params.term, page: params.page || 1, jenis:str, [csrfName]: csrfHash };},
					processResults: function (data) {
						newCSRF(data.csrfName,data.csrfHash);
						return {results: data.results, pagination: {more: data.morePages},};
					}, cache: true
				}
			}).on('select2:select', function (evt) {
				kode_dokumen = $('#kode_no option:selected').text();
			});
		}
	}

	function addKode(stt) {
		if (stt){
			$('#viewAddKode').show();
			$('#kode_tambahan').val(kode_dokumen.split('- ')[1]);
		} else {
			$('#kode_tambahan').val('');
			$('#viewAddKode').hide();
		}
	}
</script>
