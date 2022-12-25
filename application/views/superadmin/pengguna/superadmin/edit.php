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
								<label for="nama_admin"><small><b>Nama Admin</b></small></label>
								<input type="text" class="form-control form-control-sm" id="nama_admin" name="nama_admin" placeholder="Silahkan diisi..."/>
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
							<div class="form-group">
								<label for="unit"><small><b>Unit</b></small></label>
								<select class="form-control select2" id="unit" name="unit" style="width: 100%;"></select>
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
    $('#sub_pengguna_superadmin').addClass("active");

    $(function() {
		setCSRF();
        getData();
        $('#formValidate').validate({
            rules: {
                nama_admin: "required", nipy: "required", unit: "required",
            },
            messages: {
                nama_admin:"Silahkan diisi..", nipy: "Silahkan diisi..", unit: "Silahkan dipilih..",
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
                                url: "<?= site_url('Api/api_updateSuperadmin'); ?>",
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
            data: {'id':id},
            dataType: 'json',
            url: "<?= site_url('Api/api_detailSuperadmin');?>",
            success: function (data) {
                loader_hide();
                var dt = data.response.data;
                if (data.response.status==="OK"){
                    $('#nama_admin').val(dt.nama_admin);
                    $('#nipy').val(dt.nipy);
					$('#unit').append("<option value='"+dt.id_tb_unit+"' selected>"+dt.nama_unit+"</option>");
                    $('#cdate').val(setTgl(dt.cdate));
                    $('#mdate').val(setTgl(dt.mdate));
                    setSelect(dt.jenis_unit);
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

    function setSelect(jenis) {
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
        $("select[name='jenis_unit'] > option").each(function () {
            if (this.value === jenis){this.selected = true;}
        });
    }
</script>

