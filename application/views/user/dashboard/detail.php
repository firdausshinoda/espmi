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
								<a class="nav-link" id="custom-content-below-unit-terkait-tab" data-toggle="pill" href="#custom-content-below-unit-terkait" role="tab" aria-controls="custom-content-below-unit-terkait" aria-selected="false">Unit Terkait</a>
							</li>
						</ul>
						<div class="tab-content" id="custom-content-below-tabContent">
							<div class="tab-pane fade show active" id="custom-content-below-info" role="tabpanel" aria-labelledby="custom-content-below-info-tab">
								<div class="row mt-3">
									<div class="col-12">
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
													<div class="form-control form-control-sm"><span class="badge badge-success">Publis</span></div>
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
							</div>
							<div class="tab-pane fade" id="custom-content-below-dokumen" role="tabpanel" aria-labelledby="custom-content-below-dokumen-tab">
								<object data="<?= base_url('assets/plugins/pdfjs-2.3.200-dist/web/viewer.html');?>?file=<?= base_url('assets/upload/dokumen/dokumen/'.$detail->file);?>" type="application/pdf" width="100%" height="800">
									<p><a href="<?= base_url('assets/plugins/pdfjs-2.3.200-dist/web/viewer.html');?>?file=<?= base_url('assets/upload/dokumen/dokumen/'.$detail->file);?>">Click to access viewer.html</a></p>
								</object>
							</div>
							<div class="tab-pane fade" id="custom-content-below-unit-terkait" role="tabpanel" aria-labelledby="custom-content-below-unit-terkait-tab">
								<div class="mt-3">
									<h6><b>UNIT TERKAIT</b></h6>
									<table class="table table-bordered">
										<thead>
										<tr>
											<th><small><b>No</b></small></th>
											<th><small><b>Nama Unit</b></small></th>
										</tr>
										</thead>
										<tbody>
										<?php $no=0; foreach (db_view_unitTerkait($detail->id_tb_dokumen)->result() as $it_v): $no++;?>
											<tr>
												<td><small><?= $no; ?></small></td>
												<td><small><?= $it_v->nama_unit; ?></small></td>
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
	</div>
</section>
<script type="text/javascript">
    $('#i_dashboard').addClass("active");
</script>
