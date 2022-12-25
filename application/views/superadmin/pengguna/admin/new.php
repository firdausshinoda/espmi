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
								<label for="nama_admin"><small><b>Nama Admin</b></small></label>
								<input type="text" class="form-control form-control-sm" id="nama_admin" name="nama_admin" placeholder="Silahkan diisi..."/>
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
							<div class="form-group">
								<label for="unit"><small><b>Unit</b></small></label>
								<select class="form-control select2" id="unit" name="unit" style="width: 100%;"></select>
							</div>
							<div class="form-group">
								<label for="jenis_unit"><small><b>Jenis Unit</b></small></label>
								<select class="form-control select2" id="jenis_unit" name="jenis_unit">
									<option value="PENGENDALI" selected>PENGENDALI</option>
									<option value="UNIT BIASA">UNIT BIASA</option>
								</select>
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
    $('#sub_pengguna_admin').addClass("active");

    $(function() {
		setCSRF();
        $('#unit').select2({
            ajax: {
                url: '<?= site_url('Api/selectUnit'); ?>',
                type: "post", dataType: 'json', delay: 250,
                data: function (params) {return { search: params.term, page: params.page || 1, [csrfName]: csrfHash };},
                processResults: function (data) {
					newCSRF(data.csrfName,data.csrfHash);
                    return {
                        results: data.results,
                        pagination: {more: data.morePages},
                    };
                }, cache: true
            }
        });
        $('#formValidate').validate({
            rules: {
                nama_admin: "required", nipy: "required", password: "required",
                ulangi_password: {
                    required: true, equalTo:"#password"
                },
                unit: "required",
            },
            messages: {
                nama_admin:"Silahkan diisi..", nipy: "Silahkan diisi..", password: "Silahkan diisi..",
                ulangi_password: {
                    required: "Silahkan diisi..", equalTo:"Password tidak sama..."
                },
                unit: "Silahkan dipilih..",
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
                                url: "<?= site_url('Api/api_inputAdmin'); ?>",
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

