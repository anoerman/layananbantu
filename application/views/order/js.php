
<!-- Autocomplete -->
	<style media="screen">
		.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
		.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
		.autocomplete-selected { background: #F0F0F0; }
		.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
	</style>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/jQuery-Autocomplete/dist/jquery.autocomplete.js'); ?>"></script>
	<script type="text/javascript">
		// Autocomplete
		$(".produk").autocomplete({
			serviceUrl: '<?php echo base_url('order/data_produk'); ?>',
			minChars: 3,
			lookupLimit: 2,
		});
	</script>
<!-- / Autocomplete -->

<!-- Select2 -->
	<script type="text/javascript" src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/select2/select2.full.min.js'); ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/select2/select2.min.css'); ?>">
	<style media="screen">
		.select2-container .select2-selection--single {
			height: 34px;
		}
	</style>
	<script type="text/javascript">
		$(".select2").select2();
	</script>
<!-- / Select2 -->

<!-- Daterangepicker -->
	<script type="text/javascript" src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/datepicker/js/bootstrap-datepicker.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/datepicker/locales/bootstrap-datepicker.id.min.js'); ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/datepicker/css/bootstrap-datepicker3.css'); ?>">
	<!-- <link rel="stylesheet" href="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/datepicker/css/bootstrap-datepicker3.css.map'); ?>"> -->
	<script type="text/javascript">
		$(".input-daterange").datepicker({
			language: "id",
			format: "dd-mm-yyyy",
			todayHighlight: true,
			// todayBtn: true,
		});
	</script>
<!-- / Daterangepicker -->

<script type="text/javascript">

	// Fungsi untuk input hanya angka
	function input_angka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
    return true;
	}

	// Tampilkan modal untuk konfirmasi ubah status
	function modal_ubah_status(info_status) {
		// Scroll to top
		$(window).scrollTop(0);

		// Set val
		$("#url_proses_container").html(info_status);
		$("#info_proses_container").html($("#info_proses").val());
		$("#url_proses_container").prop('href', $("#url_proses").val());

		// Buka modal
		$("#modal_proses_ubah_status").modal('show');
	}

	function proses_konfirmasi() {
		// Jika petugas sudah diisi, proses
		if ($("#petugas").val() !== "") {
			// Ubah tampilan button
			$("#batal_btn").addClass('disabled');
			$("#simpan_btn").addClass('disabled');
			$("#simpan_btn").html("Data sedang diproses ...");

			// Klik submit untuk proses form
			$("#simpan").click();
		}
		else {
			$("#petugas_fg").addClass('has-error');
			$("#petugas_hb").html('Harap isikan nama petugas layanan bantu!');
			$("#petugas").focus();
		}
	}
	// / Tampilkan modal untuk konfirmasi ubah status

	// Tampilkan modal untuk batal order
	function modal_proses_batal() {
		// Scroll to top
		$(window).scrollTop(0);

		// Buka modal
		$("#modal_proses_batal").modal('show');
	}
	// / Tampilkan modal untuk batal order

	// Ajax untuk menampilkan regional per cabang
	function tampilkan_regional_cabang(cabang, no_func) {
		$("#div_regional_select").html("<p class='text-danger'><span class='fa fa-spinner fa-spin'></span> Loading ...</p>");

		// $("#div_toko").slideUp('fast');
		$("#div_toko_select").html('<p class="form-control-static text-danger">Harap pilih regional</p>');

		var urlnya = "<?php echo base_url('regional/data_regional'); ?>";
		if (no_func!="") {
			var urlnya = "<?php echo base_url('regional/data_regional/no_func'); ?>";
		}

		$.ajax({
			url: urlnya,
			type: 'GET',
			dataType: 'html',
			data: {cabang: cabang}
		})
		.done(function(results) {
			console.log("success");
			// Show div
			$("#div_regional").slideDown('fast');
			$("#div_regional_select").html(results);
			$(".select2").select2();
		})
		.fail(function() {
			console.log("error");
		});
	}
	// / Ajax untuk menampilkan regional per cabang

	// Ajax untuk menampilkan toko per regional
	function tampilkan_toko_regional(regional) {
		$("#div_toko_select").html("<p class='text-danger'><span class='fa fa-spinner fa-spin'></span> Loading ...</p>");

		$.ajax({
			url: '<?php echo base_url('order/data_toko'); ?>',
			type: 'GET',
			dataType: 'html',
			data: {regional: regional}
		})
		.done(function(results) {
			console.log("success");
			// Show div
			// $("#div_toko").slideDown('fast');
			$("#div_toko_select").html(results);
			$(".select2").select2();
		})
		.fail(function() {
			console.log("error");
		});
	}
	// / Ajax untuk menampilkan toko per regional

	function formatAngka(nStr)
	{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? ',' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return "Rp " + x1 + x2;
	}

	// Fungsi untuk menampilkan atau menyembunyikan input nominal bayar
	function tampilkan_nominal_bayar(metode_bayar) {
		if (metode_bayar==0) {
			$("#nominal_go_pay_div").hide('hide');
			// Kembalikan value jika bayar reguler
			var nominal_baru = Number($("#total_bayar_hidden").val());
			nominal_baru+=Number($("#nominal_go_pay").val());
			if (nominal_baru<=0) {
				nominal_baru = 0;
			}
			$("#total_bayar_hidden").val(nominal_baru);

			// Set nominal yang sudah di format
			nominal_baru_formatted = formatAngka(nominal_baru);
			$("#total_bayar").html(nominal_baru_formatted);
			$("#nominal_go_pay").val(0);
		}
		else if (metode_bayar==1) {
			$("#nominal_go_pay_div").show('fast');
		}
	}
	// / Fungsi untuk menampilkan atau menyembunyikan input nominal bayar


	jQuery(document).ready(function($) {
		// Pastikan radio cabang ketika klik langsung call ajax diatas
		$('.check_cabang').on('ifChecked', function(event){
			tampilkan_regional_cabang($(this).val(), "");
		});
		// Pilihan regional tanpa fungsi ambil data toko
		$('.check_cabang_no_function').on('ifChecked', function(event){
			tampilkan_regional_cabang($(this).val(), "no_func");
		});

		// Data list
		$("#data_list_cabang").on('change', function(event) {
			event.preventDefault();
			$("#link_list").prop('href', '<?php echo base_url('order/data_list/'); ?>'+$(this).val());
		});

		// Fungsi untuk menampilkan atau menyembunyikan input nominal bayar
		$(".radio_metode_bayar").on('ifChecked', function(event) {
			tampilkan_nominal_bayar($(this).val());
		});
		// / Fungsi untuk menampilkan atau menyembunyikan input nominal bayar

		$(".hitung-total, #nominal_go_pay").on('change', function(event) {
			var nominal_baru = 0;
			$('.hitung-total').each(function() {
        nominal_baru += Number($(this).val());
    	});
			nominal_baru-=Number($("#nominal_go_pay").val());
			if (nominal_baru<=0) {
				nominal_baru = 0;
			}
			$("#total_bayar_hidden").val(nominal_baru);

			// Set nominal yang sudah di format
			nominal_baru_formatted = formatAngka(nominal_baru);
			$("#total_bayar").html(nominal_baru_formatted);

		});

		// // Disable tombol setelah di klik, menghindari kirim data 2 kali
		// $("#simpan").on('click', function(event) {
		// 	$(this).html('Proses...');
		// 	$(this).addClass('disabled');
		// });
	});


</script>
