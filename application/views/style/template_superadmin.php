<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/favicon/favicon-32x32.png') ?>">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('assets/favicon/favicon-96x96.png') ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/favicon/favicon-16x16.png') ?>">
	<title>E-SPMI Superadmin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?= base_url('assets/fontawesome/css/all.css');?>" rel="stylesheet">
<!--	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
	<link rel="stylesheet" href="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/custom/custom.css');?>"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/custom/custom_superadmin.css');?>"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/DataTables/datatables.min.css');?>"/>
	<link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2.min.css');?>">
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
	<script src="<?= base_url('assets/plugins/DataTables/datatables.min.js'); ?>"></script>
	<script src="<?= base_url("assets/plugins/select2/js/select2.full.min.js"); ?>"></script>
	<script src="<?= base_url("assets/plugins/select2/js/i18n/id.js"); ?>" type="text/javascript"></script>
	<script src="<?= base_url('assets/plugins/ckeditor/ckeditor.js')?>"></script>
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
<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed pr-0">
<div class="wrapper">
	<nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="<?= site_url('Superadmin/notification'); ?>">
					<i class="far fa-bell"></i>
					<span class="badge badge-warning navbar-badge"><?= db_notif_konsul_super(); ?></span>
				</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="#">
					<i class="fas fa-cogs"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<a href="<?= site_url('Superadmin/profil'); ?>" class="dropdown-item">
						<i class="fas fa-user"></i> Profil
					</a>
					<a href="<?= site_url('Superadmin/sign_out'); ?>" class="dropdown-item">
						<i class="fas fa-sign-out-alt"></i>Keluar
					</a>
				</div>
			</li>
		</ul>
		<div class="loader-upload" id="progress-upload">
			<div class="progress">
				<div id="progressBar" class="progress-bar bg-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
					<span class="sr-only">80% Complete</span>
				</div>
			</div>
		</div>
		<div class="loader-get" id="progress-get">
			<div class="bar"></div>
		</div>
	</nav>
	<div id="Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
	<aside class="main-sidebar elevation-4 sidebar-dark-primary">
		<a href="<?= site_url(); ?>" class="brand-link">
			<img src="<?= base_url('assets/dist/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
			<span class="brand-text font-weight-light">E-SPMI</span>
		</a>

		<div class="sidebar">
			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="image">
					<img src="<?= base_url('assets/dist/img/AdminLTELogo.png'); ?>" class="img-circle elevation-2" alt="User Image">
				</div>
				<div class="info">
					<a href="<?= site_url('Superadmin/profil'); ?>" class="d-block">
						Nama Superadmin
					</a>
				</div>
			</div>

			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<li class="nav-item">
						<a href="<?= site_url('Superadmin'); ?>" class="nav-link" id="i_dashboard">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item has-treeview" id="treeview_dokspmi">
						<a href="javascript:void(0);" class="nav-link" id="i_dokspmi">
							<i class="nav-icon fas fa-book"></i>
							<p>Dokumen SPMI<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/dokumen?type=standar-spmi'); ?>" class="nav-link" id="sub_dokspmi_standar">
									<i class="far fa-circle nav-icon"></i>
									<p>Standar</p>
								</a>
							</li>
							<li class="nav-item has-treeview" id="sub_dokspmi_manual">
								<a href="#" class="nav-link" id="i_dokspmi_manual">
									<i class="far fa-circle nav-icon"></i>
									<p>
										Manual Mutu
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav-treeview" id="treeview_sub_dokspmi_manual">
									<li class="nav-item">
										<a href="<?= site_url('Superadmin/dokumen?type=manual-mutu-penetapan'); ?>" class="nav-link" id="sub_dokspmi_manual_penetapan">
											<i class="far fa-dot-circle nav-icon"></i>
											<p>Manual Penetapan</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= site_url('Superadmin/dokumen?type=manual-mutu-pelaksanaan'); ?>" class="nav-link" id="sub_dokspmi_manual_pelaksanaan">
											<i class="far fa-dot-circle nav-icon"></i>
											<p>Manual Pelaksanaan</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= site_url('Superadmin/dokumen?type=manual-mutu-evaluasi'); ?>" class="nav-link" id="sub_dokspmi_manual_evaluasi">
											<i class="far fa-dot-circle nav-icon"></i>
											<p>Manual Evaluasi</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= site_url('Superadmin/dokumen?type=manual-mutu-pengendalian'); ?>" class="nav-link" id="sub_dokspmi_manual_pengendalian">
											<i class="far fa-dot-circle nav-icon"></i>
											<p>Manual Pengendalian</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= site_url('Superadmin/dokumen?type=manual-mutu-peningkatan'); ?>" class="nav-link" id="sub_dokspmi_manual_peningkatan">
											<i class="far fa-dot-circle nav-icon"></i>
											<p>Manual Peningkatan</p>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/dokumen?type=formulir'); ?>" class="nav-link" id="sub_dokspmi_formulir">
									<i class="far fa-circle nav-icon"></i>
									<p>Formulir</p>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a href="<?= site_url('Superadmin/dokumen?type=kebijakan'); ?>" class="nav-link" id="i_kebijakan">
							<i class="nav-icon fas fa-book"></i>
							<p>Kebijakan</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= site_url('Superadmin/dokumen?type=dok-institusi'); ?>" class="nav-link" id="i_dokumen">
							<i class="nav-icon fas fa-book"></i>
							<p>Dokumen Institusi</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= site_url('Superadmin/konsultasi'); ?>" class="nav-link" id="i_konsultasi">
							<i class="nav-icon fas fa-comments"></i>
							<p>Konsultasi</p>
						</a>
					</li>
					<li class="nav-item has-treeview" id="treeview_pengguna">
						<a href="javascript:void(0);" class="nav-link" id="i_pengguna">
							<i class="nav-icon fas fa-users"></i>
							<p>Pengguna<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/pengguna?type=superadmin'); ?>" class="nav-link" id="sub_pengguna_superadmin">
									<i class="far fa-circle nav-icon"></i>
									<p>Superadmin</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/pengguna?type=admin'); ?>" class="nav-link" id="sub_pengguna_admin">
									<i class="far fa-circle nav-icon"></i>
									<p>Admin</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/pengguna?type=user'); ?>" class="nav-link" id="sub_pengguna_user">
									<i class="far fa-circle nav-icon"></i>
									<p>Pengguna Biasa</p>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a href="<?= site_url('Superadmin/dafunit'); ?>" class="nav-link" id="i_dafunit">
							<i class="nav-icon fas fa-book"></i>
							<p>Daftar Unit</p>
						</a>
					</li>
					<li class="nav-item has-treeview" id="treeview_pengaturan">
						<a href="javascript:void(0);" class="nav-link" id="i_pengaturan">
							<i class="nav-icon fas fa-cogs"></i>
							<p>Pengaturan<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/jendok'); ?>" class="nav-link" id="sub_pengaturan_jendok">
									<i class="far fa-circle nav-icon"></i>
									<p>Jenis Dokumen</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/nodok'); ?>" class="nav-link" id="sub_pengaturan_nodok">
									<i class="far fa-circle nav-icon"></i>
									<p>Nomor Dokumen</p>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item has-treeview" id="treeview_laporan">
						<a href="javascript:void(0);" class="nav-link" id="i_laporan">
							<i class="nav-icon fas fa-print"></i>
							<p>Laporan<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/laporan?type=list-dokumen'); ?>" class="nav-link" id="sub_laporan_list_dokumen">
									<i class="far fa-circle nav-icon"></i>
									<p>Daftar Dokumen</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/laporan?type=list-konsultasi'); ?>" class="nav-link" id="sub_laporan_list_konsultasi">
									<i class="far fa-circle nav-icon"></i>
									<p>Daftar Konsultasi</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/laporan?type=list-jendok'); ?>" class="nav-link" id="sub_laporan_list_jendok">
									<i class="far fa-circle nav-icon"></i>
									<p>Daftar Jenis Dokumen</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/laporan?type=list-nodok'); ?>" class="nav-link" id="sub_laporan_list_nodok">
									<i class="far fa-circle nav-icon"></i>
									<p>Daftar Nomor Dokumen</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/laporan?type=list-unit'); ?>" class="nav-link" id="sub_laporan_list_unit">
									<i class="far fa-circle nav-icon"></i>
									<p>Daftar Unit</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/laporan?type=list-user-unit'); ?>" class="nav-link" id="sub_laporan_list_user_unit">
									<i class="far fa-circle nav-icon"></i>
									<p>Pengguna Unit</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('Superadmin/laporan?type=list-user-view'); ?>" class="nav-link" id="sub_laporan_list_user_view">
									<i class="far fa-circle nav-icon"></i>
									<p>Pengguna Biasa</p>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</aside>

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
    function hapus(page,id,str1) {
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
                        data:{page:page,id:id,str1:str1,[csrfName]:csrfHash},
                        dataType: 'json',
                        url: "<?= site_url('Api/api_deleteData'); ?>",
                        success: function(data) {
                            if (data.response.status==="OK"){
								newCSRF(data.response.data.csrfName,data.response.data.csrfHash);
								alertSuccess('Berhasil menghapus data');
                                if (page==="hapus-dokumen"||page==="hapus-konsultasi"){
									cari();
								} else {
									getData();
								}
                            } else {
                                alertError(data.response.data.message);
                            }
                        },
                        error:function(data){
                            alertError('Terjadi Kesalahan. Silahkan coba lagi!!!');
                        }
                    });
                })
            },
            allowOutsideClick: false,
        });
    }
    function previewFile() {
        var input = document.getElementById("file");
        var files = input.files[0];
        var oFReader = new FileReader();
        var nBytes = files.size;
        var sOutput = nBytes + " bytes";
        for (var aMultiples = ["K", "M", "G", "T", "P", "E", "Z", "Y"], nMultiple = 0, nApprox = nBytes / 1024; nApprox > 1; nApprox /= 1024, nMultiple++) {
            sOutput = nApprox.toFixed(3) +" "+ aMultiples[nMultiple];
        }
        oFReader.fileName = files.name;
        oFReader.fileSize = sOutput;
        oFReader.onload = function (e){
            $('#nama_file').val(e.target.fileName);
            $('#size_file').val(e.target.fileSize);
        };
        oFReader.readAsDataURL(files);
    }
    function modal(page,str1,str2){
        loader_show();
        $.ajax({
            type: "GET",
            data: {page:page,str1:str1,str2:str2},
            url: "<?= site_url('Superadmin/modal'); ?>",
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
