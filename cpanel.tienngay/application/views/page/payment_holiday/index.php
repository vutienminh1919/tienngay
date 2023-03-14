<div class="right_col" role="main">
	<iFrame src="<?php echo $url;?>" width="100%" height="auto" name="the-iFrame" frameborder="0"></iFrame>
</div>
<script type="text/javascript">
	let iframeDomain = "<?php echo $iframeDomain;?>";
	window.addEventListener('message', function(event) {
      if((event.origin + '/')  === iframeDomain) {
        window.location.replace(event.data.targetLink)
      } else {
        alert('Origin not allowed!');
      }
    }, false);
	$( document ).ready(function() {
		var _iframe = $("iFrame");
	    _iframe.css('min-height', '1700px');
	});
</script>
