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
				<a href="#">
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
			<td><a href="#"><?PHP echo lang()->get('images_update') ?></a></td>
			<td><a href="#"><?PHP echo lang()->get('images_delete') ?></a></td>
		</tr>
	</table>
</div>
<?PHP endforeach; ?>