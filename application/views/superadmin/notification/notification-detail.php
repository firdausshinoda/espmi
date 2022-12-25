<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 mt-3">
				<div class="card shadow">
					<div class="card-body">
						<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="custom-content-below-info-tab" data-toggle="pill" href="#custom-content-below-info" role="tab" aria-controls="custom-content-below-info" aria-selected="true">Info</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="custom-content-below-dokumen-tab" data-toggle="pill" href="#custom-content-below-dokumen" role="tab" aria-controls="custom-content-below-dokumen" aria-selected="false">Dokumen</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="custom-content-below-unit-terkait-revisi-tab" data-toggle="pill" href="#custom-content-below-unit-terkait-revisi" role="tab" aria-controls="custom-content-below-unit-terkait-revisi" aria-selected="false">Unit Terkait Revisi</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="custom-content-below-revisi-tab" data-toggle="pill" href="#custom-content-below-revisi" role="tab" aria-controls="custom-content-below-revisi" aria-selected="false">Unggahan Revisi</a>
							</li>
						</ul>
						<div class="tab-content" id="custom-content-below-tabContent">
							<div class="tab-pane fade show active" id="custom-content-below-info" role="tabpanel" aria-labelledby="custom-content-below-info-tab">
								<div class="row">
									<div class="col-12">
										<div class="card bg-light mt-2">
											<div class="card-body">
												<div class="row">
													<div class="col-sm-12 col-md-6">
														<div class="form-group">
															<label><small>Nama Dokumen</small></label>
															<div class="form-control form-control-sm"><?= $detail->nama_dokumen; ?></div>
														</div>
													</div>
													<div class="col-sm-12 col-md-6">
														<div class="form-group">
															<label><small>Nomor Dokumen</small></label>
															<div class="form-control form-control-sm"><?= $detail->nomor_dokumen; ?></div>
														</div>
													</div>
													<div class="col-sm-12 col-md-4">
														<div class="form-group">
															<label><small>Jenis Dokumen</small></label>
															<div class="form-control form-control-sm"><?= $detail->jenis_dokumen; ?></div>
														</div>
													</div>
													<div class="col-sm-12 col-md-4">
														<div class="form-group">
															<label><small>Jumlah Halaman</small></label>
															<div class="form-control form-control-sm"><?= $detail->jml_halaman; ?></div>
														</div>
													</div>
													<div class="col-sm-12 col-md-4">
														<div class="form-group">
															<label><small>Revisi</small></label>
															<div class="form-control form-control-sm"><?= $detail->revisi; ?></div>
														</div>
													</div>
													<div class="col-sm-12 col-md-6">
														<div class="form-group">
															<label><small>Oleh Unit</small></label>
															<div class="form-control form-control-sm"><?= $detail->nama_unit; ?></div>
														</div>
													</div>
													<div class="col-sm-12 col-md-6">
														<div class="form-group">
															<label><small>Status Dokumen</small></label>
															<?php if ($detail->stt_dokumen == "MENUNGGU"): ?>
																<div class="form-control form-control-sm"><span class="badge badge-primary">Menunggu Konfirmasi</span></div>
															<?php elseif ($detail->stt_dokumen == "PUBLIS"):?>
																<div class="form-control form-control-sm"><span class="badge badge-success">Publis</span></div>
															<?php endif; ?>
														</div>
													</div>
													<div class="col-sm-12 col-md-6">
														<div class="form-group">
															<label><small>Perihal Dokumen</small></label>
															<div class="form-control form-control-sm div-textarea"><?= $detail->perihal_dokumen; ?></div>
														</div>
													</div>
													<div class="col-sm-12 col-md-6">
														<div class="form-group">
															<label><small>Deskripsi Dokumen</small></label>
															<div class="form-control form-control-sm div-textarea"><?= $detail->deskripsi_dokumen; ?></div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body bg-light">
												<h6><b>UNIT TERKAIT</b></h6>
												<table class="table table-bordered">
													<thead>
													<tr>
														<th><small><b>No</b></small></th>
														<th><small><b>Nama Unit</b></small></th>
														<th><small><b>Status</b></small></th>
														<th><small><b>Aksi</b></small></th>
													</tr>
													</thead>
													<tbody>
													<?php $no=0; foreach (db_view_unitTerkaitKonsultasi($detail->id_tb_konsultasi)->result() as $it_v): $no++;?>
														<tr>
															<td><small><?= $no; ?></small></td>
															<td><small><?= $it_v->nama_unit; ?></small></td>
															<td>
																<?php if ($it_v->stt_revisi_unit=="MENUNGGU"):?>
																	<span class="badge badge-info"><?= $it_v->stt_revisi_unit; ?></span>
																<?php elseif ($it_v->stt_revisi_unit=="REVISI"):?>
																	<span class="badge badge-warning"><?= $it_v->stt_revisi_unit; ?></span>
																<?php elseif ($it_v->stt_revisi_unit=="ACC"):?>
																	<span class="badge badge-success"><?= $it_v->stt_revisi_unit; ?></span>
																<?php endif;?>
															</td>
															<?php if (sess_get('jenis_unit')=="PENGENDALI"):?>
																<td style="width: 20%">
																	<?php if ($it_v->id_tb_unit == sess_get('id_unit')): ?>
																		<?php if ($it_v->stt_revisi_unit == "MENUNGGU"):?>
																			<button type="button" class="btn btn-success btn-sm text-white btn-block m-1" onclick="konfirm('<?= $it_v->id_tb_konsultasi_unit_terkait; ?>')"><i class="fa fa-check"></i> Konfirmasi</button>
																			<button type="button" class="btn btn-warning btn-sm text-white btn-block m-1" onclick="modal('revisi','<?= $it_v->id_tb_konsultasi_unit_terkait; ?>')"><i class="fa fa-pencil-alt"></i> Revisi</button>
																		<?php elseif ($it_v->stt_revisi_unit == "REVISI"):?>
																			<center><span class="badge badge-warning">MENUNGGU REVISI</span></center>
																		<?php else:?>
																			<center>Tidak Ada Aksi</center>
																		<?php endif; ?>
																	<?php else:?>
																		<center>-</center>
																	<?php endif; ?>
																</td>
															<?php endif; ?>
														</tr>
													<?php endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>
										<?php if ($detail->stt_dokumen == "MENUNGGU"):?>
											<div class="card-footer bg-white">
												<a href="<?= site_url('Superadmin/notification?page=edit&id='.$detail->id_tb_konsultasi); ?>" class="btn btn-primary btn-sm float-right" style="color: #FFFFFF !important;">Ubah Data</a>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="custom-content-below-dokumen" role="tabpanel" aria-labelledby="custom-content-below-dokumen-tab">
								<?php if ($detail->file_type=="pdf"):?>
									<div class="card mt-3">
										<div class="card-body">
											<object data="<?= base_url('assets/plugins/pdfjs-2.3.200-dist/web/viewerFull.html');?>?file=<?= base_url('assets/upload/dokumen/konsultasi/'.$detail->file);?>" type="application/pdf" width="100%" height="800">
												<p><a href="<?= base_url('assets/plugins/pdfjs-2.3.200-dist/web/viewerFull.html');?>?file=<?= base_url('assets/upload/dokumen/konsultasi/'.$detail->file);?>">Click to access viewer.html</a></p>
											</object>
										</div>
									</div>
								<?php else:?>
									<div class="card-footer bg-white mt-3">
										<ul class="mailbox-attachments d-flex align-items-stretch clearfix">
											<li>
												<span class="mailbox-attachment-icon"><i class="far fa-file"></i></span>
												<div class="mailbox-attachment-info">
													<a href="javascript:void(0)" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i><?= $detail->file; ?></a>
													<span class="mailbox-attachment-size clearfix mt-1">
														<span><?= $detail->file_size?> KB</span>
														<a href="<?= site_url('Superadmin/download?type=dokumen&file='.$detail->file.'&nama='.$detail->nama_dokumen.'&ext='.$detail->file_type); ?>" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
													</span>
												</div>
											</li>
										</ul>
									</div>
								<?php endif; ?>
							</div>
							<div class="tab-pane fade" id="custom-content-below-unit-terkait-revisi" role="tabpanel" aria-labelledby="custom-content-below-unit-terkait-revisi-tab">
								<div class="card bg-light">
									<div class="card-body">
										<div class="row">
											<div class="col-sm-12 col-md-3">
												<div class="form-group">
													<label><small><b>Tampilkan</b></small></label>
													<select class="form-control form-control-sm" id="length" onchange="setLength(this.value)">
														<option value="10" selected>10</option>
														<option value="25">25</option>
														<option value="50">50</option>
														<option value="100">100</option>
														<option value="200">200</option>
														<option value="-1">Semua</option>
													</select>
												</div>
											</div>
											<div class="col-sm-12 col-md-3">
												<label><small><b>Ekspor</b></small></label><br>
												<div class="btn-group btn-block">
													<button type="button" class="btn btn-info btn-sm" onclick="return $('.buttons-pdf').click()">PDF</button>
												</div>
											</div>
											<div class="col-sm-12 col-md-3">
												<div class="form-group">
													<label><small><b>Cari</b></small></label>
													<input type="text" class="form-control form-control-sm" id="search" placeholder="Silahkan diisi...">
												</div>
											</div>
											<div class="col-sm-12 col-md-3">
												<div class="form-group">
													<label><small><b>Urutan</b></small></label>
													<select class="form-control form-control-sm" id="order" onchange="getData()">
														<option value="DESC" selected>Terbaru</option>
														<option value="ASC">Terdahulu</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<table id="dt_table" class="table table-bordered table-striped" style="width: 100%">
									<thead>
									<tr>
										<th></th>
										<th>No</th>
										<th>Nama Unit</th>
										<th>Status Revisi</th>
									</tr>
									</thead>
								</table>
							</div>
							<div class="tab-pane fade mt-3" id="custom-content-below-revisi" role="tabpanel" aria-labelledby="custom-content-below-revisi-tab">
								<table id="dt_table2" class="table table-bordered table-striped" style="width: 100%">
									<thead>
									<tr>
										<th>No</th>
										<th>Pengunggah</th>
										<th>Keterangan</th>
										<th>Ditujukan Untuk Unit</th>
										<th>Tanggal</th>
									</tr>
									</thead>
									<tbody>
									<?php $no=0; foreach ($data_revisi as $it_rev): $no++;?>
										<tr>
											<td><?= $no; ?></td>
											<td><?= $it_rev->nama_admin; ?></td>
											<td><?= $it_rev->keterangan; ?></td>
											<td><?= $it_rev->unit_terkait; ?></td>
											<td><?= waktu_lalu($it_rev->cdate); ?></td>
										</tr>
									<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	var dt;
	$(document).ready(function() {
		setCSRF();
		$("#dt_table2").DataTable({
			"language" : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
		});
		dt = $("#dt_table").DataTable({
			"dom": 'Blfrtip',
			"buttons" : [
				{ extend: 'csv', messageTop: 'Daftar Revisi',
					exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5 ] },
					title: 'Daftar Revisi',
				},
				{
					extend: 'excel', messageTop: 'Daftar Revisi',
					exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5 ] },
					title: 'Daftar Revisi',
				},
				{
					extend: 'pdf', messageTop: 'Daftar Revisi', messageBottom: null,
					exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5 ] },
					title: 'Daftar Revisi',
				},
			],
			"ordering": false,
			"destroy": true,
			"lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
			"responsive":true,
			"processing": true,
			"serverSide": true,
			"pagingType": "simple_numbers",
			"paging": true,
			"ajax": {
				"url": '<?= site_url('Api/api_getUnitTerkait');?>',
				"type": "POST",
				"data": function (d) {
					d.csrf_espmi = csrfHash;
					d.order = $('#order').val();
					d.id = getUrlVars()["id"];
					d.length = $('[name="dt_table_length"]').val();
					loader_show();
				},
				"dataFilter": function(result){
					loader_hide();
					var d = JSON.parse(result);
					if (d.response.status === "OK"){
						newCSRF(d.response.data.csrfName,d.response.data.csrfHash);
						return JSON.stringify(d.response.data);
					} else {
						alertError(d.response.data.message);
						return false;
					}
				},
			},
			"columns": [
				{
					"class":          "details-control",
					"orderable":      false,
					"data":           null,
					"defaultContent": ""
				},
				{"data": null,"sortable": false,
					render: function (data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				{"data": "nama_unit"},
				{"data": "stt_revisi_unit"},
			],
			"language" : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
		});

		var detailRows = [];
		$('#dt_table tbody').on('click','tr td.details-control',function() {
			var tr = $(this).closest('tr');
			var row = dt.row(tr);
			var idx = $.inArray(tr.attr('id'),detailRows);

			if ( row.child.isShown() ) {
				tr.removeClass('details blue-grey white-text');
				row.child.hide();
				detailRows.splice(idx, 1);
			}
			else {
				tr.addClass('details blue-grey white-text');
				row.child(format(row.data())).show();
				if (idx === -1) {
					detailRows.push(tr.attr('id'));
				}
			}
		} );

		dt.on('draw',function() {
			$.each( detailRows, function (i,id) {
				$('#'+id+'td.details-control').trigger('click');
			});
		});
	});

	function format(d) {
		var d_loading = '<div class="row">\n' +
			'    <div class="col-sm-12">\n' +
			'        <center>\n' +
			'<div class="spinner-border text-primary" role="status">\n' +
			'  <span class="sr-only">Loading...</span>\n' +
			'</div>'+
			'        </center>\n' +
			'    </div>\n' +
			'</div>';
		var div = $('<div/>').addClass( 'loading' ).html(d_loading);
		var t_head, t_isi;
		t_head = '<head><tr><th><small>No</small></th><th><small>Keterangan</small></th><th><small>Tanggal</small></th></tr></head>';
		$.ajax( {
			url: "<?= site_url('Api/api_getRevisiUnit');?>",
			data: {
				[csrfName] : csrfHash,
				id: d.id_tb_konsultasi_unit_terkait,
			},
			dataType: 'json',type: "POST",
			success: function (data) {
				if (data.response.status==="OK"){
					console.log(data.response.data.csrfName);
					newCSRF(data.response.data.csrfName,data.response.data.csrfHash);
					t_isi = '<t_body>';
					if (data.response.data.data.length > 0){
						$.each(data.response.data.data, function (i, element) {
							t_isi += '<tr><td>'+(i+1)+'</td><td>'+element.keterangan+'</td><td>'+setTgl(element.cdate)+'</td></tr>';
						} );
					} else {
						t_isi += '<tr><td colspan="3"><center><small>Belum Ada Data</small></center></td></tr>';
					}
					t_isi += '</t_body>';
					div.html('<table class="table table-bordered table-striped" style="width:100%;">'+t_head+t_isi+'</table>').removeClass( 'loading' );
				}
			}
		});
		return div;
	}

	function konfirm(id) {
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
					$.ajax({
						type: "POST",
						data: {
							id_konsultasi:getUrlVars()["id"],
							id_konsultasi_unit_terkait:id,
							[csrfName]:csrfHash
						},
						dataType: 'json',
						url: "<?= site_url('Api/api_konfirmKonsultasi'); ?>",
						success: function (data) {
							$('#progress-upload').hide();
							if (data.response.status==="OK"){
								swalWithBootstrapButtons.fire({title: 'Berhasil.', text: "", icon: 'success',}).
								then((result) => {if (result.value) {location.reload();}});
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

	function setLength(str) {
		$('[name="dt_table_length"]').val(str).change();
	}

	$('#search').on( 'keyup', function () {
		dt.search(this.value).draw();
	});

	function getData() {
		$('#dt_table').DataTable().ajax.reload();
	}
</script>
