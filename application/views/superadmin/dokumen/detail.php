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
								<a class="nav-link" id="custom-content-below-unit-terkait-revisi-tab" data-toggle="pill" href="#custom-content-below-unit-terkait-revisi" role="tab" aria-controls="custom-content-below-unit-terkait-revisi" aria-selected="false">Unit Terkait</a>
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
													<?php if ($detail->jenis_dokumen == "Manual Pelaksanaan"):?>
														<div class="col-sm-12 col-md-4">
															<div class="form-group">
																<label><small>Oleh Unit</small></label>
																<div class="form-control form-control-sm"><?= $detail->nama_unit; ?></div>
															</div>
														</div>
														<div class="col-sm-12 col-md-4">
															<div class="form-group">
																<label><small>Unit Terkait</small></label>
																<div class="form-control form-control-sm"><?= $detail->nama_unit_terkait; ?></div>
															</div>
														</div>
														<div class="col-sm-12 col-md-4">
															<div class="form-group">
																<label><small>Status Dokumen</small></label>
																<div class="form-control form-control-sm"><span class="badge badge-success">Publis</span></div>
															</div>
														</div>
													<?php else:?>
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
													<?php endif; ?>
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
										<div class="card-footer bg-white">
											<a href="<?= site_url('Superadmin/dokumen?type='.get('type').'&page=edit&id='.$detail->id_tb_dokumen); ?>" class="btn btn-primary btn-sm float-right" style="color: #FFFFFF !important;">Ubah Data</a>
										</div>
										<hr>
										<?php if (!empty($detail->file)): ?>
											<div class="card-footer bg-white">
												<ul class="mailbox-attachments d-flex align-items-stretch clearfix">
													<li>
														<span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
														<div class="mailbox-attachment-info">
															<a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i><?= $detail->file; ?></a>
															<span class="mailbox-attachment-size clearfix mt-1">
															  <span><?= $detail->file_size?> KB</span>
															  <a href="<?= site_url('Superadmin/download?type=dokumen&file='.$detail->file.'&nama='.$detail->nama_dokumen.'&status=publis'); ?>" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
															</span>
														</div>
													</li>
												</ul>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="custom-content-below-dokumen" role="tabpanel" aria-labelledby="custom-content-below-dokumen-tab">
								<div class="card mt-3">
									<div class="card-body">
										<object data="<?= base_url('assets/plugins/pdfjs-2.3.200-dist/web/viewerFull.html');?>?file=<?= base_url('assets/upload/dokumen/dokumen/'.$detail->file);?>" type="application/pdf" width="100%" height="800">
											<p><a href="<?= base_url('assets/plugins/pdfjs-2.3.200-dist/web/viewerFull.html');?>?file=<?= base_url('assets/upload/dokumen/dokumen/'.$detail->file);?>">Click to access viewer.html</a></p>
										</object>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="custom-content-below-unit-terkait-revisi" role="tabpanel" aria-labelledby="custom-content-below-unit-terkait-revisi-tab">
								<table id="dt_table" class="table table-bordered table-striped" style="width: 100%">
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
	var type_ = getUrlVars()["type"];
	if (type_!=="dok-institusi"&&type_!=="kebijakan"&&type_!=="dashboard"&&type_!==undefined&&type_!==""){
		$('#treeview_dokspmi').addClass("menu-open");
		$('#i_dokspmi').addClass("active");
	}

	if (type_==="standar-spmi"){
		$('#sub_dokspmi_standar').addClass("active");
	} else if (type_==="manual-mutu-penetapan"){
		$('#sub_dokspmi_manual').addClass("menu-open");
		$('#i_dokspmi_manual').addClass("active");
		$('#sub_dokspmi_manual_penetapan').addClass("active");
	} else if (type_==="manual-mutu-pelaksanaan"){
		$('#sub_dokspmi_manual').addClass("menu-open");
		$('#i_dokspmi_manual').addClass("active");
		$('#sub_dokspmi_manual_pelaksanaan').addClass("active");
	} else if (type_==="manual-mutu-evaluasi"){
		$('#sub_dokspmi_manual').addClass("menu-open");
		$('#i_dokspmi_manual').addClass("active");
		$('#sub_dokspmi_manual_evaluasi').addClass("active");
	} else if (type_==="manual-mutu-pengendalian"){
		$('#sub_dokspmi_manual').addClass("menu-open");
		$('#i_dokspmi_manual').addClass("active");
		$('#sub_dokspmi_manual_pengendalian').addClass("active");
	} else if (type_==="manual-mutu-peningkatan"){
		$('#sub_dokspmi_manual').addClass("menu-open");
		$('#i_dokspmi_manual').addClass("active");
		$('#sub_dokspmi_manual_peningkatan').addClass("active");
	} else if (type_==="formulir"){
		$('#sub_dokspmi_formulir').addClass("active");
	} else if (type_==="kebijakan"){
		$('#i_kebijakan').addClass("active");
	} else if (type_==="dok-institusi"){
		$('#i_dokumen').addClass("active");
	} else {
		$('#i_dashboard').addClass("active");
	}
</script>
