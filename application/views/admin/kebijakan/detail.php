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
							<?php if ($dokumen->id_tb_admin == sess_get('id')):?>
								<li class="nav-item">
									<a class="nav-link" id="custom-content-below-revisi-tab" data-toggle="pill" href="#custom-content-below-revisi" role="tab" aria-controls="custom-content-below-revisi" aria-selected="false">Revisi</a>
								</li>
							<?php endif; ?>
						</ul>
						<div class="tab-content" id="custom-content-below-tabContent">
							<div class="tab-pane fade show active" id="custom-content-below-info" role="tabpanel" aria-labelledby="custom-content-below-info-tab">
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-sm-12 col-md-6">
												<div class="form-group">
													<label><small>Nama Dokumen</small></label>
													<div class="form-control form-control-sm"><?= $dokumen->nama_dokumen; ?></div>
												</div>
											</div>
											<div class="col-sm-12 col-md-6">
												<div class="form-group">
													<label><small>Nomor Dokumen</small></label>
													<div class="form-control form-control-sm"><?= $dokumen->nomor_dokumen; ?></div>
												</div>
											</div>
											<div class="col-sm-12 col-md-4">
												<div class="form-group">
													<label><small>Jenis Dokumen</small></label>
													<div class="form-control form-control-sm"><?= $dokumen->jenis_dokumen; ?></div>
												</div>
											</div>
											<div class="col-sm-12 col-md-4">
												<div class="form-group">
													<label><small>Jumlah Halaman</small></label>
													<div class="form-control form-control-sm"><?= $dokumen->jml_halaman; ?></div>
												</div>
											</div>
											<div class="col-sm-12 col-md-4">
												<div class="form-group">
													<label><small>Revisi</small></label>
													<div class="form-control form-control-sm"><?= $dokumen->revisi; ?></div>
												</div>
											</div>
											<div class="col-sm-12 col-md-6">
												<div class="form-group">
													<label><small>Oleh Unit</small></label>
													<div class="form-control form-control-sm"><?= $dokumen->nama_unit; ?></div>
												</div>
											</div>
											<div class="col-sm-12 col-md-6">
												<div class="form-group">
													<label><small>Status Dokumen</small></label>
													<?php if ($dokumen->stt_dokumen == "Menunggu" || $dokumen->stt_dokumen == "Menunggu Unit"): ?>
														<div class="form-control form-control-sm"><span class="badge badge-primary">Menunggu Konfirmasi</span></div>
													<?php elseif ($dokumen->stt_dokumen == "Revisi P2M" || $dokumen->stt_dokumen == "Revisi P2M"): ?>
														<div class="form-control form-control-sm"><span class="badge badge-danger">Belum Mengunggah File Baru</span></div>
													<?php elseif ($dokumen->stt_dokumen == "Menunggu Revisi P2M" || $dokumen->stt_dokumen == "Menunggu Revisi Unit"):?>
														<div class="form-control form-control-sm"><span class="badge badge-warning">Menunggu Revisi</span></div>
													<?php elseif ($dokumen->stt_dokumen == "Publis"):?>
														<div class="form-control form-control-sm"><span class="badge badge-success">Publis</span></div>
													<?php endif; ?>
												</div>
											</div>
											<div class="col-sm-12 col-md-6">
												<div class="form-group">
													<label><small>Perihal Dokumen</small></label>
													<div class="form-control form-control-sm div-textarea"><?= $dokumen->perihal_dokumen; ?></div>
												</div>
											</div>
											<div class="col-sm-12 col-md-6">
												<div class="form-group">
													<label><small>Deskripsi Dokumen</small></label>
													<div class="form-control form-control-sm div-textarea"><?= $dokumen->deskripsi_dokumen; ?></div>
												</div>
											</div>
										</div>
									</div>
									<?php if (sess_get('espmi-superadmin')):?>
										<div class="col-12">
											<hr>
											<div class="card-footer bg-white">
												<?php if (!empty($dokumen->file)): ?>
													<ul class="mailbox-attachments d-flex align-items-stretch clearfix">
														<li>
															<span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
															<div class="mailbox-attachment-info">
																<a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i><?= $dokumen->file; ?></a>
																<span class="mailbox-attachment-size clearfix mt-1">
															  <span><?= $dokumen->file_size?> KB</span>
															  <a href="<?= base_url('Admin/download?type=standar&file='.$dokumen->file.'&nama='.$dokumen->nama_dokumen); ?>" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
															</span>
															</div>
														</li>
													</ul>
												<?php endif; ?>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="tab-pane fade" id="custom-content-below-dokumen" role="tabpanel" aria-labelledby="custom-content-below-dokumen-tab">
<!--								<div class="card bg-light mt-3">-->
<!--									<div class="card-body">-->
<!--										<div class="row">-->
<!--											<div class="col-sm-12 col-md-3">-->
<!--												<div class="row">-->
<!--													<div class="col-sm-6">-->
<!--														<button type="button" id="btn-prev" class="btn btn-sm btn-success btn-block m-1"><i class="fa fa-angle-double-left"></i> Sebelumnya</button>-->
<!--													</div>-->
<!--													<div class="col-sm-6">-->
<!--														<button type="button" id="btn-next" class="btn btn-sm btn-success btn-block m-1">Selanjutnya <i class="fa fa-angle-double-right"></i></button>-->
<!--													</div>-->
<!--												</div>-->
<!--											</div>-->
<!--											<div class="col-sm-12 col-md-3 offset-md-6">-->
<!--												<div class="row">-->
<!--													<div class="col-sm-4">-->
<!--														<div class="form-control form-control-sm" id="div-halaman-sekarang"></div>-->
<!--													</div>-->
<!--													<div class="col-sm-4">-->
<!--														<div class="form-control form-control-sm"><center>Dari</center></div>-->
<!--													</div>-->
<!--													<div class="col-sm-4">-->
<!--														<div class="form-control form-control-sm" id="div-halaman-total"></div>-->
<!--													</div>-->
<!--												</div>-->
<!--											</div>-->
<!--										</div>-->
<!--									</div>-->
<!--								</div>-->
								<div class="card mt-3">
									<div class="card-body">
										<object data="<?= base_url('assets/plugins/pdfjs-2.3.200-dist/web/viewer.html');?>?file=<?= base_url('assets/upload/dokumen/'.$jenis_dokumen.'/'.$dokumen->file);?>" type="application/pdf" width="100%" height="800">
											<p><a href="<?= base_url('assets/plugins/pdfjs-2.3.200-dist/web/viewer.html');?>?file=<?= base_url('assets/upload/dokumen/'.$jenis_dokumen.'/'.$dokumen->file);?>">Click to access viewer.html</a></p>
										</object>
										<!--										<canvas id="pdf-canvas"></canvas>-->
									</div>
								</div>
							</div>
							<?php if ($dokumen->id_tb_admin == sess_get('id')):?>
								<div class="tab-pane fade" id="custom-content-below-revisi" role="tabpanel" aria-labelledby="custom-content-below-revisi-tab">
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
														<button type="button" class="btn btn-success btn-sm" onclick="return $('.buttons-excel').click()">EXCEL</button>
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
											<th>No</th>
											<th>Revisi</th>
											<th>Nama</th>
											<th>Nama Unit</th>
											<th>Keterangan</th>
											<th>Dibuat Pada</th>
										</tr>
										</thead>
									</table>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    $('#i_kebijakan').addClass("active");
    $(document).bind("contextmenu",function(e){
        return false;
    });

	//var url = '<?//= base_url('assets/upload/dokumen/'.$jenis_dokumen.'/'.$dokumen->file);?>//';
	//var pdfjsLib = window['pdfjs-dist/build/pdf'];
	//
	//pdfjsLib.GlobalWorkerOptions.workerSrc = '<?//= base_url('assets/plugins/pdfjs-2.3.200-dist/build/pdf.worker.js');?>//';
	//var pdfDoc = null,
	//	pageNum = 1,
	//	pageRendering = false,
	//	pageNumPending = null,
	//	scale = 0.8,
	//	canvas = document.getElementById('pdf-canvas'),
	//	ctx = canvas.getContext('2d');
	//pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
	//	pdfDoc = pdfDoc_;
	//	document.getElementById('div-halaman-total').textContent = pdfDoc.numPages;
	//	renderPage(pageNum);
	//});
	//function renderPage(num) {
	//	pageRendering = true;
	//	// Using promise to fetch the page
	//	pdfDoc.getPage(num).then(function(page) {
	//		var viewport = page.getViewport({scale: scale});
	//		canvas.height = viewport.height;
	//		canvas.width = viewport.width;
	//
	//		// Render PDF page into canvas context
	//		var renderContext = {
	//			canvasContext: ctx,
	//			viewport: viewport
	//		};
	//		var renderTask = page.render(renderContext);
	//
	//		// Wait for rendering to finish
	//		renderTask.promise.then(function() {
	//			pageRendering = false;
	//			if (pageNumPending !== null) {
	//				// New page rendering is pending
	//				renderPage(pageNumPending);
	//				pageNumPending = null;
	//			}
	//		});
	//	});
	//
	//	// Update page counters
	//	document.getElementById('div-halaman-sekarang').textContent = num;
	//}
	//function queueRenderPage(num) {
	//	if (pageRendering) {
	//		pageNumPending = num;
	//	} else {
	//		renderPage(num);
	//	}
	//}
	//function onPrevPage() {
	//	if (pageNum <= 1) {
	//		return;
	//	}
	//	pageNum--;
	//	queueRenderPage(pageNum);
	//}
	//document.getElementById('btn-prev').addEventListener('click', onPrevPage);
	//function onNextPage() {
	//	if (pageNum >= pdfDoc.numPages) {
	//		return;
	//	}
	//	pageNum++;
	//	queueRenderPage(pageNum);
	//}
	//document.getElementById('btn-next').addEventListener('click', onNextPage);
</script>
<?php if ($dokumen->id_tb_admin == sess_get('id')):?>
	<script type="text/javascript">
        var dt;
        $(document).ready(function() {
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
                    "url": '<?= base_url('Api/api_getRevisi');?>',
                    "type": "POST",
                    "data": function (d) {
                        d.order = $('#order').val();
                        d.id = getUrlVars()["id"];
                        d.length = $('[name="dt_table_length"]').val();
                        d.token = "<?= get_token();?>";
                        loader_show();
                    },
                    "dataFilter": function(result){
                        loader_hide();
                        var d = JSON.parse(result);
                        if (d.response.status === "OK"){
                            return JSON.stringify(d.response.data);
                        } else {
                            alertError(d.response.data.message);
                            return false;
                        }
                    },
                },
                "columns": [
                    {"data": null,"sortable": false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {"data": "revisi"},
                    {"data": "nama_admin"},
                    {"data": "nama_unit"},
                    {"data": "keterangan"},
                    {"render": function ( data, type, row ) {
                            return setTgl(row.cdate);
                        }
                    },
                ],
                "language" : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
            });
        });

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
<?php endif; ?>
