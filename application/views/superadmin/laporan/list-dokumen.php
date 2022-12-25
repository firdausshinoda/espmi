<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 mt-3">
				<div class="card card-white">
					<div class="card-header">
						<h3 class="card-title"><b>Daftar Dokumen</b></h3>
					</div>
					<div class="card-body">
						<div class="card bg-light">
							<div class="card-body">
								<div class="row">
									<div class="col-sm-12 col-md-3">
										<div class="form-group">
											<label><small><b>Jenis Dokumen</b></small></label>
											<select class="form-control form-control-sm" id="jenis_dokumen" onchange="getData()">
												<option value="Semua" selected>Semua</option>
												<?php foreach (db_jenisDokumen() as $itm):?>
													<option value="<?= $itm->id_tb_jenis_dokumen?>"><?= $itm->jenis_dokumen?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-sm-12 col-md-3">
										<div class="form-group">
											<label><small><b>Tampilkan</b></small></label>
											<select class="form-control form-control-sm" id="length" onchange="setLength(this.value)">
												<option value="10" selected>10</option>
												<option value="25">25</option>
												<option value="50">50</option>
												<option value="100">100</option>
												<option value="200">200</option>
												<option value="-1">Semua</option>
											</select>
										</div>
									</div>
									<div class="col-sm-12 col-md-3">
										<div class="form-group">
											<label><small><b>Urutan</b></small></label>
											<select class="form-control form-control-sm" id="order" onchange="getData()">
												<option value="DESC" selected>Terbaru</option>
												<option value="ASC">Terdahulu</option>
											</select>
										</div>
									</div>
									<div class="col-sm-12 col-md-3">
										<label><small><b>Cetak</b></small></label><br>
										<div class="btn-group btn-block">
											<button type="button" class="btn btn-info btn-sm" onclick="cetak('PDF')">PDF</button>
											<button type="button" class="btn btn-success btn-sm" onclick="cetak('EXCEL')">EXCEL</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<table id="dt_table" class="table table-bordered table-striped" style="width: 100%">
							<thead>
							<tr>
								<th>No</th>
								<th>Nama Dokumen</th>
								<th>Jenis Dokumen</th>
								<th>Perihal Dokumen</th>
								<th>Nomor Dokumen</th>
								<th>Oleh Unit</th>
								<th>Tanggal Publis</th>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    $('#treeview_laporan').addClass("menu-open");
    $('#i_laporan').addClass("active");
    $('#sub_laporan_list_dokumen').addClass("active");

    var dt;
    $(document).ready(function() {
        dt = $("#dt_table").DataTable({
            "ordering": false,
            "destroy": true,
            "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
            "responsive":true,
            "processing": true,
            "serverSide": true,
            "pagingType": "simple_numbers",
            "paging": true,
            "ajax": {
                "url": '<?= base_url('Api/api_getLaporan?page=');?>'+getUrlVars()["type"],
                "type": "POST",
                "data": function (d) {
					d.csrf_espmi = csrfHash;
                    d.length = $('[name="dt_table_length"]').val();
                    d.jenis_dokumen = $('#jenis_dokumen').val();
					d.order = $('#order').val();
                    loader_show();
                },
                "dataFilter": function(result){
                    loader_hide();
                    var d = JSON.parse(result);
                    if (d.response.status === "OK"){
						newCSRF(d.response.data.csrfName,d.response.data.csrfHash);
                        return JSON.stringify(d.response.data);
                    } else {
                        alertError(d.response.data.message);
                        return false;
                    }
                },
            },
            "columns": [
                {"data": null,"sortable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "nama_dokumen",},
                {"data": "jenis_dokumen",},
                {"data": "perihal_dokumen",},
                {"data": "nomor_dokumen",},
                {"render": function ( data, type, row ) {
                        return row.nama_admin+" ("+row.nama_unit+")";
                    },
                },
                {"render": function ( data, type, row ) {
                        return setTgl(row.cdate);
                    },
                },
            ],
            "language" : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
        });
    });

    function setLength(str) {
        $('[name="dt_table_length"]').val(str).change();
    }

    function getData() {
        $('#dt_table').DataTable().ajax.reload();
    }

    function cetak(str) {
        window.open("<?= base_url('Cetak/laporan_dokumen?type=');?>"+str+"&jenis_dokumen="+$('#jenis_dokumen').val(),"_blank ");
    }
</script>

