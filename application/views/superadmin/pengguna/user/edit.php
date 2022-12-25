<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 mt-3">
				<form id="formValidate" class="formValidate">
					<div class="card card-white">
						<div class="card-header">
							<h3 class="card-title"><b>Edit</b></h3>
						</div>
						<div class="card-body">
							<input type='hidden' class="csrf" />
							<div class="form-group">
								<label for="nama_user"><small><b>Nama Pengguna</b></small></label>
								<input type="text" class="form-control form-control-sm" id="nama_user" name="nama_user" placeholder="Silahkan diisi..."/>
								<input type="hidden" id="id" name="id"/>
							</div>
							<div class="form-group">
								<label for="nipy"><small><b>NIPY</b></small></label>
								<input type="text" class="form-control form-control-sm" id="nipy" name="nipy" placeholder="Silahkan diisi..."/>
							</div>
							<div class="form-group">
								<label for="password"><small><b>Password</b></small></label>
								<input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Silahkan diisi..."/>
								<code><small>*) Silahkan diisi jika ingin merubah password</small></code>
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
        getData();
        $('#formValidate').validate({
            rules: {
                nama_user: "required", nipy: "required",
            },
            messages: {
				nama_user:"Silahkan diisi..", nipy: "Silahkan diisi..",
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
                                url: "<?= site_url('Api/api_updateUser'); ?>",
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

    function getData() {
        var id = getUrlVars()["id"];
        $('#id').val(id);
        loader_show();
        $.ajax({
            type: "GET",
            data: {'id':id },
            dataType: 'json',
            url: "<?= site_url('Api/api_detailUser');?>",
            success: function (data) {
                loader_hide();
                var dt = data.response.data;
                if (data.response.status==="OK"){
                    $('#nama_user').val(dt.nama_user);
                    $('#nipy').val(dt.nipy);
                    $('#cdate').val(setTgl(dt.cdate));
                    $('#mdate').val(setTgl(dt.mdate));
                } else {
                    alertError(dt.message);
                }
            },
            error: function (data) {
                loader_hide();
                alertError('Terjadi Kesalahan. Silahkan coba lagi!!!');
            }
        });
    }
</script>

