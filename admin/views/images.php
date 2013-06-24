<script type="text/javascript">
  function deleteImagePopUp(imageID, imageName, imageUrl){
    var html = "<h3><?PHP echo lang()->get('images_delete_pop_title'); ?></h3>";
    html 	+= "<img src='"+imageUrl+"' title='"+imageName+"' alt='"+imageName+"'>";
    html    += "<p><?PHP echo str_replace('[image]', '<span id=\'deleteImage\'></span>', lang()->get('images_delete_pop_message')) ?></p>";

    popup = new PopUp(html);
    popup.width = 400;
    var url = "<?PHP echo base_url(__ADMIN_FOLDER.'/image_delete.php?image=') ?>"+imageID;
    popup.addButton(url, "<?PHP echo lang()->get('images_delete_pop_delete'); ?>", "redbut");
    popup.display();
    document.getElementById('deleteImage').innerHTML = imageName;
  }

  function updateImagePopUp(imageID, imageName, imageUrl, imageError) {
  	imageError = typeof imageError !== 'undefined' ? imageError : "";
  	
  	var html = "<h3><?PHP echo lang()->get('images_update_pop_title'); ?></h3>";
  	html 	+= "<img src='"+imageUrl+"' title='"+imageName+"' alt='"+imageName+"'>";
  	html 	+= "<p><label class='formlabel'><?PHP echo lang()->get('images_name') ?></label>";
  	html 	+= "<label class='help'><?PHP echo lang()->get('images_name_info') ?></label> ";
  	html 	+= "<input class='textfield' type='text' name='image_name' value='"+imageName+"' />";
  	html 	+= "<span  class='formError'>"+imageError+"</span></p>";
  	html 	+= "<input type='hidden' name='image_id' value='"+imageID+"' />";

  	popup = new PopUp(html);
  	popup.width = 450;
  	popup.formAction = "<?PHP echo base_url(__ADMIN_FOLDER.'/image_edit.php') ?>";
  	popup.formMethod = "post";
  	popup.addButton("image_update_submit", "<?PHP echo lang()->get('images_update_pop_save'); ?>", "bluebut", true);
  	popup.display();
  }

  function imagePopUp(imageName, imageUrl){
  	var html = "<h3>"+imageName+"</h3>";
  	html 	+=" <a onclick='removePopUp();' href='#'>";
  	html 	+= "<img src='"+imageUrl+"' title='"+imageName+"' alt='"+imageName+"'></a>";

  	popup = new PopUp(html);
  	popup.width = 900;
    popup.display();
  }
  	function getUrlDate(name){
   		if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
      		return decodeURIComponent(name[1]);
	}
	if(<?PHP echo $update_error ?>) {
		updateImagePopUp(<?PHP echo "'$update_id', '$update_name', '$update_url', '$update_error_message'" ?>);
	}
</script>
<form action="" method="post" enctype="multipart/form-data">
	<fieldset>
		<p>
			<label class="formlabel"><?PHP echo lang()->get('images_name') ?></label>	
			<label class="help"><?PHP echo lang()->get('images_name_info') ?></label> 		
			<input class="textfield" type="text" name="image_name" value="<?PHP echo $image_name ?>" />
			<span  class="formError"><?PHP echo $error_image_name ?></span>
		</p>

		<p>
			<label class="formlabel"><?PHP echo lang()->get('images_file') ?></label>	
			<label class="help"><?PHP echo lang()->get('images_file_info') ?></label> 		
			<input class="textfield" type="file" name="image_file" value="<?PHP echo $image_file ?>" />
			<span  class="formError"><?PHP echo $error_image_file ?></span>
		</p>

		<input type="submit" value="<?PHP echo lang()->get('images_upload_button') ?>" name="image_submit" class="button buttrans bluebut" />
	</fieldset>
</form>

<h1><?PHP echo lang()->get('images_title') ?></h1>
<?PHP foreach ($images as $image ): ?>
	<div style="float: left; padding: 5px;">
	<table>
		<tr>
			<td rowspan="5">
				<a href="#" onclick="imagePopUp('<?PHP echo $image['name']."', '".base_url('data/images/'.$image['file_name']) ?>');">
					<img src="<?PHP echo base_url('data/images/thumbnails/'.$image['file_name']) ?>" title="<?PHP echo $image['name'] ?>" alt="<?PHP echo $image['name'] ?>">
				</a>
			</td>
		</tr>
		<tr>
			<td><?PHP echo lang()->get('images_name') ?>:</td>
			<td><?php echo $image['name'] ?></td>
		</tr>
		<tr>
			<td><?PHP echo lang()->get('images_uploaded_on') ?>:</td>
			<td><?php echo substr($image['created_on'],0 ,10) ?></td>
		</tr>
		<tr>
			<td><?PHP echo lang()->get('images_uploaded_by') ?>:</td>
			<td><?php echo $image['created_by'] ?></td>
		</tr>
		<tr>
			<td><a onclick="updateImagePopUp('<?PHP echo $image['ID']."', '".$image['name']."', '".base_url('data/images/thumbnails/'.$image['file_name']) ?>');"
				href="#"><?PHP echo lang()->get('images_update') ?></a></td>
			<td><a onclick="deleteImagePopUp('<?PHP echo $image['ID']."', '".$image['name']."', '".base_url('data/images/thumbnails/'.$image['file_name']) ?>');" 
				href="#"><?PHP echo lang()->get('images_delete') ?></a></td>
		</tr>
	</table>
</div>
<?PHP endforeach; ?>