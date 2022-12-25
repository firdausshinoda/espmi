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
								<label for="exampleInputEmail1"><small><b>Jenis Dokumen</b></small></label>
								<select class="form-control form-control-sm" id="jenis_dokumen" name="jenis_dokumen">
									<option value="<?= $detail->id_tb_jenis_dokumen?>" selected><?= $detail->jenis_dokumen?></option>
									<?php foreach (db_jenisDokumen() as $itm):?>
										<option value="<?= $itm->id_tb_jenis_dokumen?>"><?= $itm->jenis_dokumen?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Nomor Dokumen</b></small></label>
								<input type="text" class="form-control form-control-sm" id="nomor_dokumen" name="nomor_dokumen" value="<?= $detail->nomor_dokumen; ?>" placeholder="Silahkan diisi..."/>
								<input type="hidden" id="id" name="id" value="<?= $detail->id_tb_dokumen_kode; ?>"/>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1"><small><b>Prihal Dokumen</b></small></label>
								<textarea class="form-control form-control-sm" id="perihal_dokumen" name="perihal_dokumen" placeholder="Silahkan diisi..." rows="7"><?= $detail->perihal_dokumen; ?></textarea>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-primary btn-sm float-right m-1">Simpan</button>
							<button type="button" class="btn btn-danger btn-sm float-right m-1" onclick="history.back()">Batal</button>
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
	$('#sub_pengaturan_nodok').addClass("active");

    $(function() {
		setCSRF();
		var jenis_dokumen = {};
		$("select[name='jenis_dokumen'] > option").each(function () {
			if(jenis_dokumen[this.text]) { $(this).remove();}
			else {jenis_dokumen[this.text] = this.value;}
		});
        $('#formValidate').validate({
            rules: {
                nomor_dokumen: "required", perihal_dokumen : "required",
            },
            messages: {
                nomor_dokumen:"Silahkan diisi..", perihal_dokumen: "Silahkan diisi..",
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
                                url: "<?= base_url('Api/api_updateNoDok'); ?>",
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

