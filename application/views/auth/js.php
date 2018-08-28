
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


<script type="text/javascript">

  // Ajax untuk menampilkan regional per cabang
  function tampilkan_regional_cabang(cabang) {
    $("#div_regional_select").html("<p class='text-danger'><span class='fa fa-spinner fa-spin'></span> Loading ...</p>");

    $.ajax({
      url: '<?php echo base_url('regional/data_regional/no_func'); ?>',
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


  jQuery(document).ready(function($) {
    // Pastikan radio cabang ketika klik langsung call ajax diatas
		$('.check_cabang').on('ifChecked', function(event){
			tampilkan_regional_cabang($(this).val());
		});
  });

</script>
