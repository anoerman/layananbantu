
<script language="javascript">

	$(document).ready(function() {
		load_data_dinamis(<?php echo $curr_cabang ?>);
	});

	function load_data_dinamis (cabang) {
		$.ajax({
			url: '<?php echo base_url('order/data_dinamis/') ?>'+cabang,
			type: 'GET',
			dataType: 'html',

		})
		.done(function(response) {
			$("#container_data").html(response);
			console.log("Daftar order berhasil ditampilkan");
		})
		.fail(function(response) {
			console.log("Error menampilkan data order. "+response.status + " " + response.statusText);
		});
	}

	// Auto reload content
	setInterval(function(){load_data_dinamis(<?php echo $curr_cabang ?>);}, <?php echo $time_refresh ?>);

</script>
