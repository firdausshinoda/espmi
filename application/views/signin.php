<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="E-SPMI">
	<meta name="author" content="firdausns44@gmail.com">
	<meta name="generator" content="E-SPMI">
	<meta name="keyword" content="E-SPMI, POLITEKNIK HARAPAN BERSAMA, POLTEK">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/favicon/favicon-32x32.png') ?>">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('assets/favicon/favicon-96x96.png') ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/favicon/favicon-16x16.png') ?>">
	<title>Aplikasi E-SPMI</title>
	<link rel="canonical" href="<?= base_url(); ?>">
	<link href="<?= base_url('assets/dist/css/adminlte.min.css');?>" rel="stylesheet">
	<link href="<?= base_url('assets/fontawesome/css/all.css');?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/custom/custom.css');?>"/>
	<link href="<?= base_url('assets/plugins/sweetalert2-9.5.4/package/dist/sweetalert2.min.css');?>" rel="stylesheet">

	<script src="<?= base_url('assets/plugins/jQuery/jQuery-3.3.1.min.js');?>"></script>
	<script src="<?= base_url("assets/plugins/bootstrap/js/bootstrap.bundle.min.js")?>"></script>
	<script src="<?= base_url('assets/plugins/jquery-validation-1.15.0/dist/jquery.validate.js');?>"></script>
	<script src="<?= base_url("assets/dist/js/adminlte.min.js"); ?>"></script>
	<script src="<?= base_url('assets/plugins/sweetalert2-9.5.4/package/dist/sweetalert2.all.min.js');?>"></script>
</head>
<body class="hold-transition login-page bg-login">
<div class="login-box">
	<div class="login-logo">
		<h2 class="border bg-light p-1">Aplikasi E-SPMI</h2>
	</div>
	<div class="card">
		<div class="card-body login-card-body">
			<p class="login-box-msg">Silahkan Masuk</p>
			<form id="formValidate" class="formValidate">
				<input class="csrf" type='hidden' name='<?= $this->security->get_csrf_token_name()?>' value='<?=$this->security->get_csrf_hash()?>' />
				<div class="input-group mb-3">
					<input type="text" class="form-control" name="nipy" id="nipy" placeholder="Silahkan Masukkan NIPY...">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-user"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="password" class="form-control" name="password" id="password" placeholder="Silahkan Masukkan Password...">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="progress progress-sm active mb-1" style="display: none" id="progressBar">
					<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						<span class="sr-only">100% Complete</span>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<button type="submit" class="btn btn-primary btn-block">MASUK</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
    $(function() {
        $('#formValidate').validate({
            rules: {
                nipy: "required", password : "required",
            },
            messages: {
                nipy:"Silahkan diisi..", password: "Silahkan diisi..",
            },
            submitHandler: function(form) {
                $('#progressBar').show();
                var values = $('#formValidate').serialize();
                $.ajax({
                    type: "POST",
                    data: values, dataType: 'json',
                    url: "<?= site_url('Sistem/auth'); ?>",
                    success: function (data) {
                        $('#progressBar').hide();
                        if (data.response.status==="NO-EXIST"){
                        	setCSRF(data.response.data.csrfName,data.response.data.csrfHash);
                            Swal.fire({icon: 'error', title: 'Oops...', text: 'Pengguna tidak ditemukan!'});
                        } else if (data.response.status==="WRONG"){
							setCSRF(data.response.data.csrfName,data.response.data.csrfHash);
                            Swal.fire({icon: 'error', title: 'Oops...', text: 'Password salah!'});
                        } else if (data.response.status==="OK"){
							window.location = data.response.data.url;
                        } else {
                            alert(data);
                        }
                    },
                    error: function (data) {
                        $('#progressBar').hide();
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Terjadi Kesalahan. Silahkan coba lagi!!!'})
                    }
                });
            }
        });
    });
	function setCSRF(csrfName,csrfHash){
		$('.csrf').attr('name',csrfName);
		$('.csrf').val(csrfHash);
	}
</script>
</body>
</html>
