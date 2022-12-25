<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 mt-3">
				<form id="formValidate" class="formValidate">
					<div class="card shadow">
						<div class="card-header">
							<b>Edit Dokumen Konsultasi</b>
						</div>
						<div class="card-body row">
							<input type='hidden' class="csrf" />
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1"><small><b>Judul</b></small></label>
								<input type="text" class="form-control form-control-sm" id="judul" name="judul" value="<?= $detail->nama_dokumen; ?>" placeholder="Silahkan diisi..."/>
								<input type="hidden" id="id" name="id" value="<?= $detail->id_tb_konsultasi; ?>"/>
							</div>
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1"><small><b>Deskripsi</b></small></label>
								<textarea class="form-control form-control-sm" id="deskripsi" name="deskripsi" placeholder="Silahkan diisi..." rows="7"><?= $detail->deskripsi_dokumen; ?></textarea>
							</div>
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1"><small><b>Kategori Dokumen</b></small></label>
								<select type="text" class="form-control form-control-sm select2" id="jenis_dokumen" name="jenis_dokumen">
									<?php if (empty($detail->jenis_dokumen)):?>
										<option value="">--Silahkan Dipilih Sebelum Memilih Standar Terkait--</option>
									<?php else:?>
										<option value="<?= $detail->id_tb_jenis_dokumen; ?>"><?= $detail->jenis_dokumen; ?></option>
									<?php endif;?>
								</select>
							</div>
							<div class="form-group col-sm-8">
								<label for="exampleInputEmail1"><small><b>Standar Terkait</b></small></label>
								<select class="form-control form-control-sm select2" id="kode_no" name="kode_no" style="width: 100%;">
									<?php if (empty($detail->id_tb_dokumen_kode)):?>
										<option value="">--Silahkan Pilih Jenis Dokumen Terlelbih Dahulu--</option>
									<?php else:?>
										<option value="<?= $detail->id_tb_dokumen_kode; ?>"><?= $detail->nomor_dokumen." - ".$detail->jenis_dokumen; ?></option>
									<?php endif;?>
								</select>
							</div>
							<div class="form-group col-sm-4">
								<label for="exampleInputEmail1"><small><b>Tambah Kode Standar Terkait</b></small></label>
								<button type="button" class="btn btn-primary btn-sm btn-block" onclick="addKode(true)">Tambah</button>
							</div>
							<div class="display_none col-sm-12" id="viewAddKode">
								<div class="row">
									<div class="form-group col-sm-8">
										<label for="exampleInputEmail1"><small><b>Kode Tambahan Standar Terkait</b></small></label>
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
								<label for="exampleInputEmail1"><small><b>Unit Terkait</b></small></label>
								<?php foreach (db_view_unitTerkaitKonsultasi($detail->id_tb_konsultasi)->result() as $it_v): ?>
									<?php if ($it_v->id_tb_unit==11):?>
										<div class="row m-1">
											<div class="col-sm-12">
												<input type="text" class="form-control form-control-sm" value="<?= $it_v->nama_unit?>" disabled/>
											</div>
										</div>
									<?php else:?>
										<div class="row m-1">
											<div class="col-sm-11">
												<input type="text" class="form-control form-control-sm" value="<?= $it_v->nama_unit?>" disabled/>
											</div>
											<div class="col-sm-1">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" type="checkbox" id="unitTerkait<?= $it_v->id_tb_konsultasi_unit_terkait; ?>" name="unit_hapus[]" value="<?= $it_v->id_tb_konsultasi_unit_terkait; ?>">
													<label for="unitTerkait<?= $it_v->id_tb_konsultasi_unit_terkait; ?>" class="custom-control-label"><i class="fa fa-trash"></i></label>
												</div>
											</div>
										</div>
									<?php endif;?>
								<?php endforeach; ?>
								<div class="row m-1">
									<div class="add-controls col-sm-12" id="box_item">
										<div class="add-entry pt-1">
											<div class="row">
												<div class="col-sm-11">
													<select class="form-control form-control-sm select2" id="unit_terkait-1" name="unit_terkait[]" style="width: 100%"></select>
												</div>
												<div class="col-sm-1">
													<button type="button" class="btn btn-success btn-sm btn-block add-colum">+</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="card bg-light">
								<div class="card-body">
									<div class="row">
										<div class="col-sm-2">
											<center><i class="far fa-file" style="font-size: 68px;"></i></center>
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
    $('#i_konsultasi').addClass("active");

	var jenis_dokumen = null, kode_dokumen = "";
	$(function() {
		bsCustomFileInput.init();
		setCSRF();
		$('#jenis_dokumen').select2({
			ajax: {
				url: '<?= site_url('Api/selectJenisDokumen'); ?>',
				type: "post", dataType: 'json', delay: 250,
				data: function (params) {return { search: params.term, page: params.page || 1, [csrfName]: csrfHash };},
				processResults: function (data) {
					newCSRF(data.csrfName,data.csrfHash);
					return {results: data.results, pagination: {more: data.morePages},};
				}, cache: true
			}
		}).on('select2:select', function (evt) {
			selectKode($('#jenis_dokumen option:selected').val());
		});
		$('#unit_terkait-1').select2({
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
				judul:"required",deskripsi:"required",nama_file:"required",jenis_dokumen:"required",kode_no:"required",
				jml_halaman:{required:true, digits: true,}, thn_dokumen:{required:true, digits: true, maxlength:4},
			},
			messages: {
				judul:"Silahkan diisi..",deskripsi:"Silahkan diisi..",nama_file:"Silahkan pilih file..",
				jenis_dokumen:"Silahkan dipilih..", kode_no:"Silahkan dipilih..",
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
							var del_unit = document.getElementsByName("unit_hapus[]");
							var unit_baru = document.getElementsByName("unit_terkait[]");

							var data = new FormData();
							data.append("id", $('#id').val());
							data.append("judul", $('#judul').val());
							data.append("deskripsi", $('#deskripsi').val());
							data.append("jenis_dokumen", $('#jenis_dokumen').val());
							data.append("kode_no", $('#kode_no').val());
							data.append("jenis_dokumen_tambahan", jenis_dokumen);
							data.append("kode_tambahan", $('#kode_tambahan').val());
							data.append("perihal_dokumen_tambahan", $('#perihal_dokumen_tambahan').val());
							data.append("jml_halaman", $('#jml_halaman').val());
							data.append("bln_dokumen", $('#bln_dokumen').val());
							data.append("thn_dokumen", $('#thn_dokumen').val());
							data.append([csrfName], csrfHash);
							for (var i = 0; i < del_unit.length; i++) {
								if(del_unit[i].checked)
								{data.append("unit_hapus[]", del_unit[i].value);}
							}
							for (var j = 0; j < unit_baru.length; j++) {
								if (unit_baru[j].value != "") {data.append("unit_baru[]", unit_baru[j].value);}
							}

							$.ajax({
								type: "POST", data: data, dataType: 'json',
								processData : false, contentType : false,
								url: "<?= site_url('Api/api_updateKonsultasi'); ?>",
								success: function (data) {
									if (data.response.status==="OK"){
										swalWithBootstrapButtons.fire({title: 'Berhasil.', text: "", icon: 'success',}).
										then((result) => {if (result.value) {history.back();}});
									} else {
										alertError('Gagal Menambahkan Data!');
									}
								},
								error: function (data) {
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
			jenis_dokumen = str;
			$('#kode_no').select2({
				ajax: {
					url: '<?= site_url('Api/selectKode'); ?>',
					type: "post", dataType: 'json', delay: 250,
					data: function (params) {return { search: params.term, page: params.page || 1, id_jenis:str, [csrfName]: csrfHash };},
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

	var idUnit = 1;
	$(document).on('click', '.add-colum', function(e) {
		e.preventDefault();
		var controlForm = $('.add-controls:first');
		idUnit += 1;
		console.log(idUnit);
		var _html_new = '<div class="add-entry pt-1"><div class="row"><div class="col-sm-11">\n' +
			'<select type="text" class="form-control form-control-sm select2" id="unit_terkait-'+idUnit+'" name="unit_terkait[]" style="width: 100%"></select>\n' +
			'</div><div class="col-sm-1">' +
			'<button type="button" class="btn btn-success btn-sm btn-block add-colum">+</button>\n' +
			'</div></div></div>';
		$(_html_new).appendTo(controlForm);
		controlForm.find('.add-entry:not(:last) .add-colum')
			.removeClass('add-colum').addClass('del-colum')
			.removeClass('btn-success').addClass('btn-danger')
			.html('-');
		setSelect2(idUnit);
	}).on('click', '.del-colum', function(e) {
		$(this).parents('.add-entry:first').remove();
		e.preventDefault();
		return false;
	});

	function setSelect2(id) {
		$('#unit_terkait-'+id).select2({
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
