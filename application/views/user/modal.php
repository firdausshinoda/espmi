<?php if ($page=="profil-img"): ?>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="formExecuteModal" class="formExecuteModal">
				<div class="modal-header">
					<h6 class="modal-title" id="exampleModalLabel">Ganti Foto Profil</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="loader-modal" id="progress-modal">
					<div class="bar-modal"></div>
				</div>
				<div class="modal-body" id="modal-body">
					<div class="image_demo" style="width: 100%;"></div>
					<center>
						<span class="btn btn-sm btn-primary btn-file">
							<i class="fa fa-camera"></i> Pilih Foto
							<input type="file" id="upload_image" name="upload_image" accept=".jpg, .jpeg, .png">
						</span>
					</center>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
					<button type="button" id="crop_image" class="btn btn-sm btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
        var $image_crop;
        $(document).ready(function(){
            $image_crop = $('.image_demo').croppie({
                enableExif: true,
                viewport: {
                    width:200,
                    height:200,
                    type:'circle'
                },
                boundary:{
                    width:400,
                    height:400
                }
            });

            $('#upload_image').on('change', function(){
                var reader = new FileReader();
                reader.onload = function (event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                };
                reader.readAsDataURL(this.files[0]);
            });

            $('#crop_image').click(function(event){
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response){
                    loader_show();
                    $.ajax({
                        url:"<?= site_url('Api/api_profilImage'); ?>",
                        type: "POST",
                        data:{"image": response,[csrfName]:csrfHash},
                        success:function(data) {
                            loader_hide();
							newCSRF(data.response.data.csrfName,data.response.data.csrfHash);
                            if (data.response.status==="OK"){
                                swalWithBootstrapButtons.fire({title: 'Berhasil.', text: "", icon: 'success',}).
                                then((result) => {if (result.value) {location.reload();}});
                            } else {
                                alertError('Gagal Menambahkan Data!');
                            }
                        }
                    });
                })
            });
        });
	</script>
<?php elseif ($page=="profil-ubah"): ?>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="formExecuteModal" class="formExecuteModal">
				<div class="modal-header">
					<h6 class="modal-title" id="exampleModalLabel">Ganti Profil</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="loader-modal" id="progress-modal">
					<div class="bar-modal"></div>
				</div>
				<div class="modal-body" id="modal-body">
					<input type='hidden' class="csrf" />
					<div class="form-group">
						<label for="nama"><small><b>Nama</b></small></label>
						<input type="text" class="form-control form-control-sm" id="nama" name="nama" value="<?= sess_get('nama'); ?>"/>
					</div>
					<div class="form-group">
						<label for="nipy"><small><b>NIPY</b></small></label>
						<input type="text" class="form-control form-control-sm" id="nipy" name="nipy" value="<?= sess_get('nipy'); ?>"/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-sm btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
        $(function() {
			setCSRF();
            $('#formExecuteModal').validate({
                rules: {
                    nama:"required",nipy:"required",
                },
                messages: {
                    nama:"Silahkan diisi..",nipy:"Silahkan diisi..",
                },
                submitHandler: function(form) {
                    loader_show();
                    var values = $('#formExecuteModal').serialize();
                    $.ajax({
                        type: "POST", data: values,
                        url: "<?= site_url('Api/api_profilUpdate'); ?>",
                        success: function (data) {
                            loader_hide();
							newCSRF(data.response.data.csrfName,data.response.data.csrfHash);
                            if (data.response.status==="OK"){
                                swalWithBootstrapButtons.fire({title: 'Berhasil.', text: "", icon: 'success',}).
                                then((result) => {if (result.value) {location.reload();}});
                            } else if (data.response.status==="EXIST"){
								alertError('NIPY sudah terdaftar!');
							} else {
                                alertError('Gagal Menambahkan Data!');
                            }
                        },
                        error: function (data) {
                            loader_hide();
                            alertError('Terjadi Kesalahan. Silahkan coba lagi!!!')
                        }
                    });
                }
            });
        });
	</script>
<?php elseif ($page=="profil-password"): ?>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="formExecuteModal" class="formExecuteModal">
				<div class="modal-header">
					<h6 class="modal-title" id="exampleModalLabel">Ganti Password</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="loader-modal" id="progress-modal">
					<div class="bar-modal"></div>
				</div>
				<div class="modal-body" id="modal-body">
					<input type='hidden' class="csrf" />
					<div class="form-group">
						<label for="password_lama"><small><b>Password Lama</b></small></label>
						<input type="password" class="form-control form-control-sm" id="password_lama" name="password_lama"/>
					</div>
					<div class="form-group">
						<label for="password_baru"><small><b>Password Baru</b></small></label>
						<input type="password" class="form-control form-control-sm" id="password_baru" name="password_baru"/>
					</div>
					<div class="form-group">
						<label for="ulangi_password"><small><b>Ulangi Password Baru</b></small></label>
						<input type="password" class="form-control form-control-sm" id="ulangi_password" name="ulangi_password"/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-sm btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
        $(function() {
			setCSRF();
            $('#formExecuteModal').validate({
                rules: {
                    password_lama:"required",password_baru:"required",
                    ulangi_password:{required:true, equalTo:"#password_baru"},
                },
                messages: {
                    password_lama:"Silahkan diisi..",password_baru:"Silahkan diisi..",
                    ulangi_password:{required:"Silahkan diisi..", equalTo:"Password Tidak Sama..."},
                },
                submitHandler: function(form) {
                    loader_show();
                    var values = $('#formExecuteModal').serialize();
                    $.ajax({
                        type: "POST", data: values,
                        url: "<?= site_url('Api/api_profilPassword'); ?>",
                        success: function (data) {
                            loader_hide();
							newCSRF(data.response.data.csrfName,data.response.data.csrfHash);
                            if (data.response.status==="OK"){
                                swalWithBootstrapButtons.fire({title: 'Berhasil.', text: "", icon: 'success',}).
                                then((result) => {if (result.value) {location.reload();}});
                            } else if (data.response.status==="NOT-SAME"){
                                alertError('Password lama salah!');
                            } else {
                                alertError('Gagal Menambahkan Data!');
                            }
                        },
                        error: function (data) {
                            loader_hide();
                            alertError('Terjadi Kesalahan. Silahkan coba lagi!!!')
                        }
                    });
                }
            });
        });
	</script>
<?php endif; ?>
