<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12">
				<p id="p_total">Total : Dokumen</p>
				<div class="input-group input-group-sm">
					<input type="text" class="form-control" placeholder="Cari dokumen..." id="cari_dokumen">
					<span class="input-group-append">
                    <button type="button" class="btn btn-info btn-flat" onclick="cari();">Cari</button>
                  </span>
				</div>
			</div>
			<div class="col-12 mt-3" id="div_jenis">
				<span class="badge badge-pill badge-primary shadow m-1" id="sp_0" style="cursor: pointer" onclick="pilih('sp_0')"><p class="m-1">Semua</p></span>
				<?php foreach ($jenis_dokumen as $itm_dok):?>
					<span class="badge badge-pill shadow m-1" id="sp_<?= $itm_dok->id_tb_jenis_dokumen?>" style="cursor: pointer" onclick="pilih('sp_<?= $itm_dok->id_tb_jenis_dokumen?>')"><p class="m-1"><?= $itm_dok->jenis_dokumen; ?></p></span>
				<?php endforeach; ?>
			</div>
			<div class="col-sm-12 mt-3">
				<div id="viewDokumen" class="row"></div>
				<div id="loading-info" class="display_none">
					<center>
						<div class="spinner-border spinner-border-sm" role="status">
							<span class="sr-only">Loading...</span>
						</div>
					</center>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	var type_ = getUrlVars()["type"];
	$('#i_dashboard').addClass("active");

	var kat = "0";
	var start = 0;
	var ttl_data = 0;
	var sp_ = [];
	$(function() {
		var theDiv = document.getElementById('div_jenis').children;
		for (var i = 0; i < theDiv.length; i++) {
			if (theDiv[i].tagName == 'SPAN') {
				sp_.push(theDiv[i].id);
			}
		}
		getData();
	});

	$(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() >= $(document).height()) {
			if (start < ttl_data) {
				getData();
			}
		}
	});

	function cari() {
		start = 0;
		ttl_data = 0;
		$('#viewDokumen').html('');
		getData();
	}

	function getData() {
		$.ajax({
			type: "GET",
			data: {offset:start,search:$('#cari_dokumen').val(),kategori:kat,type:type_},
			url: "<?= site_url('Api/dokumenView'); ?>",
			beforeSend: function () {
				$('#loading-info').fadeIn('slow');
			},
			success: function (data) {
				setTimeout(function(){
					start+=5;
					$('#loading-info').fadeOut('slow');
					$('#viewDokumen').append(data);
				}, delay_ajax);
			},
			error: function (data) {
				$('#loading-info').fadeOut('slow');
				alertError('Terjadi Kesalahan. Silahkan coba lagi!!!')
			}
		});
	}

	function pilih(str) {
		kat = str.split('_')[1];
		for (var i=0; i< sp_.length; i++){
			$('#'+sp_[i]).removeClass("badge-primary badge-light");
			if (sp_[i] === str){
				$('#'+str).addClass("badge-primary");
			}
		}
		cari();
	}
</script>

