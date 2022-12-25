<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 mt-3">
				<form id="formValidate" class="formValidate">
					<div class="card card-white">
						<div class="card-header">
							<h3 class="card-title"><b>Profil</b></h3>
						</div>
						<div class="card-body">
							<div class="form-group">
								<?php if (empty(sess_get('foto'))):?>
									<center>
										<img src="<?= base_url('assets/dist/img/avatar5.png')?>" class="img-circle img-bordered" style="width: 150px"/>
									</center>
								<?php else:?>
									<center>
										<img src="<?= base_url('assets/upload/img/profil/'.sess_get('foto'))?>" class="img-circle img-bordered" style="width: 150px"/>
									</center>
								<?php endif;?>
								<div style="margin-top: -3%;margin-left: 7%;">
									<center>
										<button type="button" class="btn btn-primary btn-sm shadow rounded-circle" style="width: 40px;height: 40px;" onclick="modal('profil-img')">
											<i class="fa fa-camera" style="margin-top: 5px;"></i>
										</button>
									</center>
								</div>
							</div>
							<div class="form-group">
								<label for="nama"><small><b>Nama</b></small></label>
								<div class="form-control form-control-sm"><?= sess_get('nama'); ?></div>
							</div>
							<div class="form-group">
								<label for="nipy"><small><b>NIPY</b></small></label>
								<div class="form-control form-control-sm"><?= sess_get('nipy'); ?></div>
							</div>
						</div>
						<div class="card-footer">
							<button type="button" class="btn btn-primary btn-sm float-right m-1" onclick="modal('profil-ubah')">Ubah Profil</button>
							<button type="button" class="btn btn-primary btn-sm float-right m-1" onclick="modal('profil-password')">Ubah Password</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
