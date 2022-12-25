<script>
    ttl_data = '<?= $ttl; ?>';
    $('#p_total').text('Total : <?= $ttl; ?> Dokumen');
</script>
<?php if ($data->num_rows() > 0):?>
	<?php foreach ($data->result() as $item):?>
		<div class="col-sm-12 col-md-6">
			<div class="card shadow">
				<div class="card-body">
					<p><b><?= $item->nama_dokumen; ?></b></p>
					<p class="text-justify text-sm">
						<span><?= $item->nama_dokumen; ?></span>
					</p>
					<hr>
					<table>
						<tbody>
						<tr>
							<td><small>Kategori Dokumen</small></td><td>&nbsp;:&nbsp;</td><td><span class="badge badge-pill badge-light shadow"><?= $item->jenis_dokumen; ?></span></td>
						</tr>
						<tr>
							<td><small>No. Dokumen</small></td><td>&nbsp;:&nbsp;</td><td><small><?= $item->nomor_dokumen; ?></small></td>
						</tr>
						<tr>
							<td><small>Oleh</small></td><td>&nbsp;:&nbsp;</td><td><small><?= $item->nama_unit; ?></small></td>
						</tr>
						<tr>
							<td><small>Jumlah</small></td><td>&nbsp;:&nbsp;</td><td><small><?= $item->jml_halaman; ?> Halaman</small></td>
						</tr>
						<tr>
							<td><small>Status</small></td>
							<td>&nbsp;:&nbsp;</td>
							<td>
								<small>
									<?= $item->stt_dokumen; ?>
									<?php if ($item->stt_dokumen == "MENUNGGU"): ?>
										<span class="badge badge-primary">Menunggu</span>
									<?php elseif ($item->stt_dokumen == "PUBLIS"):?>
										<span class="badge badge-success">Publis</span>
									<?php endif; ?>
								</small>
							</td>
						</tr>
						<tr>
							<td><small>Diunggah Pada</small></td><td>&nbsp;:&nbsp;</td><td><small><?= waktu_lalu($item->cdate); ?></small></td>
						</tr>
						</tbody>
					</table>
					<hr>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading<?= $item->id_tb_konsultasi?>">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" href="#collapse<?= $item->id_tb_konsultasi?>" aria-expanded="true" aria-controls="collapse<?= $item->id_tb_konsultasi?>">
									Unit Terkait
								</a>
							</h4>
						</div>
						<div id="collapse<?= $item->id_tb_konsultasi?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?= $item->id_tb_konsultasi?>">
							<div class="panel-body">
								<table class="table table-bordered">
									<thead>
									<tr>
										<th><small><b>No</b></small></th>
										<th><small><b>Nama Unit</b></small></th>
										<th><small><b>Status</b></small></th>
									</tr>
									</thead>
									<tbody>
									<?php $no=0; foreach (db_view_unitTerkaitKonsultasi($item->id_tb_konsultasi)->result() as $it_v): $no++;?>
										<tr>
											<td><small><?= $no; ?></small></td>
											<td><small><?= $it_v->nama_unit; ?></small></td>
											<td>
												<small>
													<?php if ($it_v->stt_revisi_unit=="MENUNGGU"):?>
														<span class="badge badge-info"><?= $it_v->stt_revisi_unit; ?></span>
													<?php elseif ($it_v->stt_revisi_unit=="REVISI"):?>
														<span class="badge badge-warning"><?= $it_v->stt_revisi_unit; ?></span>
													<?php elseif ($it_v->stt_revisi_unit=="ACC"):?>
														<span class="badge badge-success"><?= $it_v->stt_revisi_unit; ?></span>
													<?php endif;?>
												</small>
											</td>
										</tr>
									<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<hr>
					<a href="<?= site_url('Superadmin/notification?page=detail&id='.$item->id_tb_konsultasi); ?>" class="btn btn-success btn-sm text-white float-right m-1"><i class="fa fa-eye"></i> Lihat</a>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="col-sm-12">
		<div class="card shadow">
			<div class="card-body">
				<b>Belum Ada Dokumen</b>
			</div>
		</div>
	</div>
<?php endif; ?>
