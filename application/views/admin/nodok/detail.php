<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 mt-3">
				<form id="formValidate" class="formValidate">
					<div class="card card-white">
						<div class="card-header">
							<h3 class="card-title"><b>Detail</b></h3>
						</div>
						<div class="card-body">
							<input type='hidden' class="csrf" />
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Jenis Dokumen</b></small></label>
								<div class="form-control form-control-sm" ><?= $detail->jenis_dokumen?></div>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Nomor Dokumen</b></small></label>
								<div class="form-control form-control-sm"><?= $detail->nomor_dokumen; ?>"</div>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Prihal Dokumen</b></small></label>
								<div class="form-control form-control-sm div-textarea"><?= $detail->perihal_dokumen; ?></div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$('#i_nodok').addClass("active");
</script>

