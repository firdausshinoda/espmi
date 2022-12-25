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
<script type="text/javascript">
	var type_ = getUrlVars()["type"];
	$('#treeview_dokspmi').addClass("menu-open");
	$('#i_dokspmi').addClass("active");
	$('#sub_dokspmi_manual').addClass("menu-open");
	$('#i_dokspmi_manual').addClass("active");
	$('#sub_dokspmi_manual_evaluasi').addClass("active");

    var start = 0;
    var ttl_data = 0;
	var sp_ = [];
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
			data: {offset:start,search:$('#cari_dokumen').val(),type:type_},
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
</script>

