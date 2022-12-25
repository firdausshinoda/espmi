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
								<input type="text" class="form-control form-control-sm" id="jenis_dokumen" name="jenis_dokumen" value="<?= $detail->jenis_dokumen; ?>" placeholder="Silahkan diisi..."/>
								<input type="hidden" id="id" name="id" value="<?= $detail->id_tb_jenis_dokumen; ?>"/>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Keterangan</b></small></label>
								<textarea class="form-control form-control-sm" id="keterangan" name="keterangan" placeholder="Silahkan diisi..." rows="7"><?= $detail->keterangan; ?></textarea>
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
	$('#treeview_pengaturan').addClass("menu-open");
	$('#i_pengaturan').addClass("active");
	$('#sub_pengaturan_jendok').addClass("active");

    $(function() {
		setCSRF();
        $('#formValidate').validate({
            rules: {
                jenis_dokumen : "required",
            },
            messages: {
				jenis_dokumen: "Silahkan diisi..",
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
                                url: "<?= site_url('Api/api_updateJenisDokumen'); ?>",
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
</script>

