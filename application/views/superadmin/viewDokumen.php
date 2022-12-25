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
							<td><small>Tanggal</small></td><td>&nbsp;:&nbsp;</td><td><small><?= waktu_lalu($item->cdate); ?></small></td>
						</tr>
						<tr>
							<td><small>Revisi</small></td><td>&nbsp;:&nbsp;</td><td><small><?= $item->revisi; ?></small></td>
						</tr>
						</tbody>
					</table>
					<hr>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading<?= $item->id_tb_dokumen?>">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" href="#collapse<?= $item->id_tb_dokumen?>" aria-expanded="true" aria-controls="collapse<?= $item->id_tb_dokumen?>">
									Unit Terkait
								</a>
							</h4>
						</div>
						<div id="collapse<?= $item->id_tb_dokumen?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?= $item->id_tb_dokumen?>">
							<div class="panel-body">
								<table class="table table-bordered">
									<thead>
									<tr>
										<th><small><b>No</b></small></th>
										<th><small><b>Nama Unit</b></small></th>
									</tr>
									</thead>
									<tbody>
									<?php $no=0; foreach (db_view_unitTerkait($item->id_tb_dokumen)->result() as $it_v): $no++;?>
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
					<hr>
					<button onclick="hapus('hapus-dokumen','<?= $item->id_tb_dokumen; ?>')" class="btn btn-danger btn-sm text-white float-right m-1"><i class="fa fa-trash-alt"></i> Hapus</button>
					<a href="<?= site_url('Superadmin/dokumen?type='.$type.'&page=detail&id='.$item->id_tb_dokumen); ?>" class="btn btn-success btn-sm text-white float-right m-1"><i class="fa fa-eye"></i> Lihat</a>
					<a href="<?= site_url('Superadmin/dokumen?type='.$type.'&page=edit&id='.$item->id_tb_dokumen); ?>" class="btn btn-warning btn-sm text-white float-right m-1"><i class="fa fa-pencil-alt"></i> Edit</a>
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
