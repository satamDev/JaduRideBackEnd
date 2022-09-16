<script type="text/javascript">
	$(document).ready(function(){
		sarathi_splash_data();
	});

	function sarathi_splash_data(){
		$.ajax({
			type:"POST",
			url:"<?=base_url('Admin/sarathi_splash_data')?>",
			error:function(response){
				console.log(response);
			},
			success:function(response){
				if(response.success){
					console.log(response);
					var sarathi_splash=response.data;

					$.each(sarathi_splash, function(i){

						
					});

				}
				else{
					console.log(response);
				}
			}
		})
	}


</script>