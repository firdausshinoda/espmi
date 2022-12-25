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
								<label for="exampleInputEmail1"><small><b>Nama Unit</b></small></label>
								<input type="text" class="form-control form-control-sm" id="nama_unit" name="nama_unit" placeholder="Silahkan diisi..."/>
								<input type="hidden" id="id" name="id"/>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Keterangan</b></small></label>
								<textarea class="form-control form-control-sm" id="keterangan" name="keterangan" placeholder="Silahkan diisi..." rows="7"></textarea>
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
    $('#i_dafunit').addClass("active");

    $(function() {
		setCSRF();
        getData();
        $('#formValidate').validate({
            rules: {
                nama_unit : "required",
            },
            messages: {
                nama_unit: "Silahkan diisi..",
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
                                url: "<?= site_url('Api/api_updateDafUnit?type='); ?>"+getUrlVars()["type"],
                                success: function (data) {
                                    if (data.response.status==="OK"){
                                        swalWithBootstrapButtons.fire({title: 'Berhasil.', text: "", icon: 'success',}).
                                        then((result) => {if (result.value) {history.back();}});
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
            data: {'id':id,'token':'<?= get_token(); ?>'},
            dataType: 'json',
            url: "<?= site_url('Api/api_detailDafUnit');?>",
            success: function (data) {
                loader_hide();
                var dt = data.response.data;
                if (data.response.status==="OK"){
                    $('#nama_unit').val(dt.nama_unit);
                    $('#keterangan').val(dt.keterangan);
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

