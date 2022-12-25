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
								<label for="nama"><small><b>Nama</b></small></label>
								<input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Silahkan diisi..."/>
							</div>
							<div class="form-group">
								<label for="nipy"><small><b>NIPY</b></small></label>
								<input type="text" class="form-control form-control-sm" id="nipy" name="nipy" placeholder="Silahkan diisi..."/>
							</div>
							<div class="form-group">
								<label for="password"><small><b>Password</b></small></label>
								<input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Silahkan diisi..."/>
							</div>
							<div class="form-group">
								<label for="ulangi_password"><small><b>Ulangi Password</b></small></label>
								<input type="password" class="form-control form-control-sm" id="ulangi_password" name="ulangi_password" placeholder="Silahkan diisi..."/>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-primary btn-sm float-right m-1">Simpan</button>
							<button type="button" class="btn btn-danger btn-sm float-right m-1">Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    $('#treeview_pengguna').addClass("menu-open");
    $('#i_pengguna').addClass("active");
    $('#sub_pengguna_user').addClass("active");

    $(function() {
		setCSRF();
        $('#formValidate').validate({
            rules: {
                nama: "required", nipy: "required", password: "required",
                ulangi_password: {
                    required: true, equalTo:"#password"
                },
            },
            messages: {
                nama:"Silahkan diisi..", nipy: "Silahkan diisi..", password: "Silahkan diisi..",
                ulangi_password: {
                    required: "Silahkan diisi..", equalTo:"Password tidak sama..."
                },
            },
            submitHandler: function(form) {
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
                        var values = $('#formValidate').serialize();
                        return new Promise(function (resolve) {
                            $.ajax({
                                type: "POST", data: values,dataType: 'json',
                                url: "<?= site_url('Api/api_inputUser'); ?>",
                                success: function (data) {
									newCSRF(data.response.data.csrfName,data.response.data.csrfHash);
                                    if (data.response.status==="OK"){
                                        swalWithBootstrapButtons.fire({title: 'Berhasil.', text: "", icon: 'success',}).
                                        then((result) => {if (result.value) {history.back();}});
                                    } else if (data.response.status==="EXIST"){
										alertError('NIPY sudah terdaftar!');
									} else {
                                        alertError('Gagal Menambahkan Data!');
                                    }
                                },
                                error: function (data) {
                                    alertError('Terjadi Kesalahan. Silahkan coba lagi!!!')
                                }
                            });
                        })
                    },
                    allowOutsideClick: false,
                });
            }
        });
    });
</script>

