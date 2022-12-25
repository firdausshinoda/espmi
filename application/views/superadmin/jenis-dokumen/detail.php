<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 mt-3">
				<form id="formValidate" class="formValidate">
					<div class="card card-white">
						<div class="card-header">
							<h3 class="card-title"><b>Tambah</b></h3>
						</div>
						<div class="card-body">
							<input type='hidden' class="csrf" />
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Jenis Dokumen</b></small></label>
								<div class="form-control form-control-sm"><?= $detail->jenis_dokumen; ?></div>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Keterangan</b></small></label>
								<div class="form-control form-control-sm div-textarea"><?= $detail->keterangan; ?></div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<a href="<?= site_url('Superadmin/jendok?page=edit&id='.$detail->id_tb_jenis_dokumen); ?>" class="btn btn-primary btn-lg btn-floating shadow rounded-circle">
	<i class="fa fa-pencil-alt floating-icon"></i>
</a>
<script type="text/javascript">
	$('#treeview_pengaturan').addClass("menu-open");
	$('#i_pengaturan').addClass("active");
	$('#sub_pengaturan_jendok').addClass("active");
</script>

