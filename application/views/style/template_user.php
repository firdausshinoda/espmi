<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/favicon/favicon-32x32.png') ?>">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('assets/favicon/favicon-96x96.png') ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/favicon/favicon-16x16.png') ?>">
	<title>E-SPMI Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?= base_url('assets/fontawesome/css/all.css');?>" rel="stylesheet">
<!--	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
	<link rel="stylesheet" href="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/custom/custom.css');?>"/>
	<link rel="stylesheet" href="<?= base_url('assets/plugins/Croppie-2.6.4/croppie.css');?>">


	<script src="<?= base_url('assets/plugins/jQuery/jQuery-3.3.1.min.js');?>"></script>
	<script src="<?= base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
	<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<script src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js'); ?>"></script>
	<script src="<?= base_url('assets/plugins/jquery-validation-1.15.0/dist/jquery.validate.js');?>"></script>
	<script src="<?= base_url('assets/plugins/sweetalert2-9.5.4/package/dist/sweetalert2.all.min.js');?>"></script>
	<script src="<?= base_url('assets/plugins/moment/moment.min.js'); ?>"></script>
	<script src="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js');?>"></script>
	<script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
	<script src="<?= base_url('assets/dist/js/demo.js');?>"></script>
	<script src="<?= base_url('assets/custom/custom.js');?>"></script>
	<script src="<?= base_url('assets/plugins/pdfjs-2.3.200-dist/build/pdf.js');?>"></script>
	<script src="<?= base_url('assets/plugins/Croppie-2.6.4/croppie.js');?>"></script>
	<script>
		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>', csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
		function newCSRF(name,hash) {
			csrfName = name;
			csrfHash = hash;
			$('.csrf').attr('name',name);
			$('.csrf').val(hash);
		}
		function setCSRF(){
			$('.csrf').attr('name',csrfName);
			$('.csrf').val(csrfHash);
		}
		var delay_ajax = 1000;
	</script>
</head>
<body class="hold-transition layout-top-nav layout-navbar-fixed layout-fixed">
<div class="wrapper">
	<nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
		<div class="container">
			<a href="<?= site_url(); ?>" class="navbar-brand">
				<img src="<?= base_url('assets/favicon/favicon-96x96.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle">
				<span class="brand-text font-weight-light">E-SPMI</span>
			</a>

			<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="fas fa-cogs"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<a href="<?= site_url('User/profil'); ?>" class="dropdown-item">
							<i class="fas fa-user"></i> Profil
						</a>
						<a href="<?= site_url('User/sign_out'); ?>" class="dropdown-item">
							<i class="fas fa-sign-out-alt"></i>Keluar
						</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>
	<div id="Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

	<div class="content-wrapper">
		<?= $content; ?>
	</div>

	<footer class="main-footer">
		<div class="float-right d-none d-sm-block">
			<b>Version</b> 1.0.0
		</div>
		<strong>Copyright &copy; 2020 <a href="<?= site_url(); ?>">E-SPMI</a>.</strong> All rights reserved.
	</footer>
</div>
<script type="text/javascript">
    function modal(page,str1,str2){
        loader_show();
        $.ajax({
            type: "GET",
            data: {page:page,str1:str1,str2:str2},
            url: "<?= site_url('User/modal'); ?>",
            success: function(data) {
                loader_hide()
                $("#Modal").html(data);
                $("#Modal").modal('show',{backdrop: 'true'});
            }, error:function(data) {
                loader_hide();
                alertError('Terjadi Kesalahan Silahkan Coba Lagi!!!');
            }
        });
    }
</script>
</body>
</html>
