<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 mt-3">
				<form id="formValidate" class="formValidate">
					<div class="card card-white">
						<div class="card-header">
							<h3 class="card-title"><b>Detail</b></h3>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="nama_user"><small><b>Nama Admin</b></small></label>
								<div class="form-control form-control-sm" id="nama_user"></div>
							</div>
							<div class="form-group">
								<label for="nipy"><small><b>NIPY</b></small></label>
								<div class="form-control form-control-sm" id="nipy"></div>
							</div>
							<div class="row">
								<div class="form-group col-sm-12 col-md-6">
									<label for="exampleInputEmail1"><small><b>Ditambahkan Pada</b></small></label>
									<div class="form-control form-control-sm" id="cdate"></div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="exampleInputEmail1"><small><b>Diubah Pada</b></small></label>
									<div class="form-control form-control-sm" id="mdate"></div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<a href="javascript:void(0);" class="btn btn-primary btn-lg btn-floating shadow rounded-circle" id="btn-edit">
	<i class="fa fa-pencil-alt floating-icon"></i>
</a>
<script type="text/javascript">
    $('#treeview_pengguna').addClass("menu-open");
    $('#i_pengguna').addClass("active");
    $('#sub_pengguna_user').addClass("active");

    $(document).ready(function() {
        getData();
    });

    function getData() {
        var id = getUrlVars()["id"];
        var type_ = getUrlVars()["type"];
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
                    $('#nama_user').html(dt.nama_user);
                    $('#nipy').html(dt.nipy);
                    $('#cdate').html(setTgl(dt.cdate));
                    $('#mdate').html(setTgl(dt.mdate));
                    $('#btn-edit').attr('href', "<?= site_url('Superadmin/pengguna?type='); ?>"+type_+"&page=edit&id="+id);
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

