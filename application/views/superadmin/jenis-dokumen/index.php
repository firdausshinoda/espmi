<section class="content">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-sm-12 mt-3">
				<div class="card card-white">
					<div class="card-header">
						<h3 class="card-title"><b>Daftar Jenis Dokumen</b></h3>
					</div>
					<div class="card-body">
						<div class="card bg-light">
							<div class="card-body">
								<div class="row">
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
										<label><small><b>Ekspor</b></small></label><br>
										<div class="btn-group btn-block">
											<button type="button" class="btn btn-info btn-sm" onclick="return $('.buttons-pdf').click()">PDF</button>
											<button type="button" class="btn btn-success btn-sm" onclick="return $('.buttons-excel').click()">EXCEL</button>
										</div>
									</div>
									<div class="col-sm-12 col-md-3">
										<div class="form-group">
											<label><small><b>Cari</b></small></label>
											<input type="text" class="form-control form-control-sm" id="search" placeholder="Silahkan diisi...">
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
								</div>
							</div>
						</div>
						<table id="dt_table" class="table table-bordered table-striped" style="width: 100%">
							<thead>
							<tr>
								<th>No</th>
								<th>Jenis Dokumen</th>
								<th>Keterangan</th>
								<th>Dibuat Pada</th>
								<th>Aksi</th>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<a href="<?= site_url('Superadmin/jendok?page=new'); ?>" class="btn btn-primary btn-lg btn-floating shadow rounded-circle">
	<i class="fa fa-plus floating-icon"></i>
</a>
<script type="text/javascript">
	$('#treeview_pengaturan').addClass("menu-open");
	$('#i_pengaturan').addClass("active");
	$('#sub_pengaturan_jendok').addClass("active");


    var dt;
    $(document).ready(function() {
        dt = $("#dt_table").DataTable({
            "dom": 'Blfrtip',
            "buttons" : [
                { extend: 'csv', messageTop: 'Daftar Jenis Dokumen',
                    exportOptions: { columns: [ 0, 1, 2 ,3 ] },
                    title: 'Daftar Jenis Dokumen',
                },
                {
                    extend: 'excel', messageTop: 'Daftar Jenis Dokumen',
                    exportOptions: { columns: [ 0, 1, 2 ,3 ] },
                    title: 'Daftar Jenis Dokumen',
                },
                {
                    extend: 'pdf', messageTop: 'Daftar Jenis Dokumen', messageBottom: null,
                    exportOptions: { columns: [ 0, 1, 2 ,3 ] },
                    title: 'Daftar Jenis Dokumen',
                },
            ],
            "ordering": false,
            "destroy": true,
            "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
            "responsive":true,
            "processing": true,
            "serverSide": true,
            "pagingType": "simple_numbers",
            "paging": true,
            "ajax": {
                "url": '<?= site_url('Api/api_getJenisDokumen');?>',
                "type": "POST",
                "data": function (d) {
					d.csrf_espmi = csrfHash;
                    d.order = $('#order').val();
                    d.length = $('[name="dt_table_length"]').val();
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
                {"render": function ( data, type, row ) {
                        return '<a href="<?= site_url('Superadmin/jendok?page=detail&id=')?>'+row.id_tb_jenis_dokumen+'">'+row.jenis_dokumen+'</a>';
                    }
                },
                {"data": "keterangan"},
                {"render": function ( data, type, row ) {
                        return setTgl(row.cdate);
                    }
                },
                {"render": function ( data, type, row ) {
						var view = '<a href="<?= site_url('Superadmin/jendok?page=edit&id='); ?>' + row.id_tb_jenis_dokumen + '" class="btn btn-warning btn-sm btn-block shadow-sm">Edit</a>';
						if (row.tipe_dokumen === "DOKUMEN INSTITUSI") {
							view += '<button type="button" class="btn btn-danger btn-sm btn-block shadow-sm" onclick="hapus(\'jendok\',\''+row.id_tb_jenis_dokumen+'\')">Hapus</button>';
						}
						return view;
					}
                },
            ],
            "language" : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
        });
    });

    function setLength(str) {
        $('[name="dt_table_length"]').val(str).change();
    }

    $('#search').on( 'keyup', function () {
        dt.search(this.value).draw();
    });

    function getData() {
        $('#dt_table').DataTable().ajax.reload();
    }
</script>

