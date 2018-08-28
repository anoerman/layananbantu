<script type="text/javascript">

	// Ajax untuk menampilkan regional per cabang
	function tampilkan_regional_cabang_history(cabang) {
		$("#div_regional_select").html("<p class='text-danger'><span class='fa fa-spinner fa-spin'></span> Loading ...</p>");

		$("#div_toko_select").html('<p class="form-control-static text-danger">Harap pilih regional</p>');

		var urlnya = "<?php echo base_url('regional/data_regional_checkbox'); ?>";

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

			// Re-declare iCheck
			redeclare_icheck();

			// Aktifkan fungsi pilih semua
			$('.pilih_semua').on('ifChanged', function(event) {
				// Pilih semua
				$('.pilih_semua').on('ifChecked', function(event) {
					$('.regional_cb').iCheck('check');
				});

				// Batal semua
				$('.pilih_semua').on('ifUnchecked', function(event) {
					$('.regional_cb').iCheck('uncheck');
				});
			});

		})
		.fail(function(sd) {
			console.log("error" + sd.responseText );
		});
	}
	// / Ajax untuk menampilkan regional per cabang

	function redeclare_icheck() {
		// $('input[name="regional_id[]"]').iCheck({
		$('input.regional_cb').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
	}


	jQuery(document).ready(function($) {
    $('.check_cabang_history').on('ifChecked', function(event){
			tampilkan_regional_cabang_history($(this).val());
		});

		// Aktifkan fungsi pilih semua
		$('.pilih_semua').on('ifChanged', function(event) {
			// Pilih semua
			$('.pilih_semua').on('ifChecked', function(event) {
				$('.regional_cb').iCheck('check');
			});

			// Batal semua
			$('.pilih_semua').on('ifUnchecked', function(event) {
				$('.regional_cb').iCheck('uncheck');
			});
		});

		// Tampilkan di halaman atau langsung download dalam bentuk Excel
		$('#view_data').on('click', function(event) {
			$('#form_laporan').prop('action', '<?php echo base_url('order/history_data') ?>');
			$('#proses_riwayat').click();
		});

		$('#download_excel').on('click', function(event) {
			$('#form_laporan').prop('action', '<?php echo base_url('order/history_excel') ?>');
			$('#proses_riwayat').click();
		});

	});
</script>
