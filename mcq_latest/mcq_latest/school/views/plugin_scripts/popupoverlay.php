<script src="<?php echo base_url('assets/js/jquery.popupoverlay.js') ?>"></script>
<style type="text/css">
@media (max-width: 991px) {
	.my-popup {
		transform: scale(0.8);
		width: 60%;
	}
}
@media (min-width: 992px) {
	.my-popup {
		transform: scale(0.8);
		width: 25%;
	}
}

.popup_visible .my-popup {
  transform: scale(1);
}	
.my-popup h4{
	text-align: center;
}

.popup-form .input{
	margin-bottom: 10px;
	border-radius: 0px;
}

.popup-bottom{
	margin-top: 20px;
}
</style>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
      // Initialize the plugin
      $('.my-popup').popup({
		  transition: 'all 0.3s'
		});
    });
</script>