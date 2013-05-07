<section class="topbar">
	<?php if(!empty($_SESSION['user_username'])): ?>
	<div class="right">
		<?PHP echo lang()->get('topbar_welcome') ?>, <?PHP echo $_SESSION['user_name'] .' '. $_SESSION['user_surname'] ?> 
		<a class="buttonsmall bluebut" href="<?php echo base_url(__ADMIN_FOLDER.'/logout.php') ?>"><?PHP echo lang()->get('topbar_logout') ?></a></div>
	<?php endif; ?>
</section>