<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 col-md-6 mt-3">
				<div class="card card-white">
					<div class="card-header">
						<h3 class="card-title"><b>Tombol Unggah Semua Dokumen Unit</b></h3>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label for="nama"><small><b>Aktifkan/Matikan</b></small></label>
							<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success float-right">
								<input type="checkbox" class="custom-control-input" id="sw_btn_unggah" onchange="ubah_switch()">
								<label class="custom-control-label" for="sw_btn_unggah"></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    $('#i_setting').addClass("active");

    var ck_ = "<?= $sw; ?>";
    if (ck_=== "1" ) {
        $("#sw_btn_unggah").prop('checked', true);
    } else {
        $("#sw_btn_unggah").prop('checked', false);
    }

    function ubah_switch() {
        var stt = 0;
        if ($('#sw_btn_unggah').is(':checked')) {
            stt = 1;
        } else {
            stt = 0;
        }
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
                return new Promise(function (resolve) {
                    $.ajax({
                        type: "POST",
                        data:{id:1,stt:stt,[csrfName]:csrfHash},
                        dataType: 'json',
                        url: "<?= base_url('Api/api_updateSetting'); ?>",
                        success: function(data) {
                            if (data.response.status==="OK"){
								newCSRF(data.response.data.csrfName,data.response.data.csrfHash);
                                swalWithBootstrapButtons.fire('', 'Berhasil menyimpan perubahan.', 'success');
                            } else {
                                swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: 'Gagal menyimpan perubahan.'});
                            }
                        },
                        error:function(data){
                            swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: 'Terjadi Kesalahan. Silahkan coba lagi!!!'});
                        }
                    });
                })
            },
            allowOutsideClick: false,
        });
    }
</script>

