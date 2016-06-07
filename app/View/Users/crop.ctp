
<meta id='urlCrop' name='url' content= "<?php echo $user_info['profileImage']; ?>">
<meta id='idCrop' name='id' content= "<?php echo $user['id']; ?>">


<?php
	echo $this->Html->css('user/crop');
?>
<div id='return'>
	<?php echo $baseURL ?>
</div>
<div  class="component">

	<div class="overlay">
		
		<div class="overlay-inner">
		
		</div>
		
	</div>
	
<!--	<div class="resize-container">-->
		
<!--
		<span class="resize-handle resize-handle-nw"></span>
		<span class="resize-handle resize-handle-ne"></span>
-->
		<img class="resize-image" src="<?php echo $user_info['profileImage']; ?>">
<!--
		<span class="resize-handle resize-handle-sw"></span>
		<span class="resize-handle resize-handle-se"></span>
-->
		
<!--	</div>-->

	<button id='crop' class="btn-crop js-crop">Crop</button>
	
</div>

<?php 
	echo $this->Html->script('crop.js');
?>
