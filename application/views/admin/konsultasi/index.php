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
<a href="<?= site_url('Admin/konsultasi?page=new'); ?>" class="btn btn-primary btn-lg btn-floating shadow rounded-circle">
	<i class="fa fa-plus floating-icon"></i>
</a>
<script type="text/javascript">
    $('#i_konsultasi').addClass("active");

	$(document).on('click', '.panel', function(e) {
		e.preventDefault();
	});

    var start = 0;
    var ttl_data = 0;
    $(function() {
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
			data: {offset:start,search:$('#cari_dokumen').val()},
			url: "<?= site_url('Api/konsultasiView'); ?>",
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
</script>

