function getUrlVars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
	});
	return vars;
}
var hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jum&#39;at','Sabtu'];
var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
function setTgl(str){
	var __tgl = new Date(str);
	var __hari = __tgl.getDay();
	var __bulan = __tgl.getMonth();
	var __tahun = __tgl.getYear();
	var tahun__ = (__tahun<1000)?__tahun+1900 : __tahun;
	if (str==null){
		return "";
	} else {
		return hari[__hari]+', '+__tgl.getDate()+' '+bulan[__bulan]+' '+tahun__;
	}
}
function loader_show(){
	$('#progress-get').css("visibility", "visible");
}
function loader_hide(){
	$('#progress-get').css("visibility", "hidden");
}
const swalWithBootstrapButtons = Swal.mixin({
	customClass: {
		confirmButton: 'btn btn-success m-1',
		cancelButton: 'btn btn-danger m-1'
	},
	buttonsStyling: false
});
function alertSuccess(str){
	swalWithBootstrapButtons.fire({icon: 'success', title: str, showConfirmButton: true});
}
function alertError(str){
	swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: str})
}
