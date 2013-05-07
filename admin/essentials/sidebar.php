<section class="sidebar">
	<a href='<?PHP echo base_url(__ADMIN_FOLDER) ?>'><img id='logo' src='images/logo_small.png' alt='logo' /></a>
	
	<ul id='menu'>
		<?PHP if(secure()->hasUserAccess(__ROLE_ADMIN)): ?>
			<a href='<?PHP echo base_url(__ADMIN_FOLDER.'/settings.php') ?>'>
				<li>
					<img class='icon' src='images/icons/settings.png' alt='' />		
					<span><?PHP echo lang()->get('sidebar_settings') ?></span>	
				</li>
			</a>
		<?PHP endif; 
		
		if(secure()->hasUserAccess(__ROLE_USER)): ?>
			<a href='<?PHP echo base_url(__ADMIN_FOLDER.'/pages.php') ?>'>
				<li>
					<img class='icon' src='images/icons/pages.png' alt='' />		
					<span><?PHP echo lang()->get('sidebar_pages') ?></span>		
				</li>
			</a>
		<?PHP endif; 
		
		if(secure()->hasUserAccess(__ROLE_DEV)): ?>
			<a href='<?PHP echo base_url(__ADMIN_FOLDER.'/menu.php') ?>'>
				<li>
					<img class='icon' src='images/icons/menu.png' alt='' />			
					<span><?PHP echo lang()->get('sidebar_menu') ?></span>		
				</li>
			</a>
		<?PHP endif; 
		
		if(secure()->hasUserAccess(__ROLE_USER)): ?>
			<a href='<?PHP echo base_url(__ADMIN_FOLDER.'/images.php') ?>'>
				<li>
					<img class='icon' src='images/icons/images.png' alt='' />		
					<span><?PHP echo lang()->get('sidebar_images') ?></span>		
				</li>
			</a>
		<?PHP endif; 
		
		if(secure()->hasUserAccess(__ROLE_ADMIN)): ?>
			<a href='<?PHP echo base_url(__ADMIN_FOLDER.'/components.php') ?>'>
				<li>
					<img class='icon' src='images/icons/component.png' alt='' />	
					<span><?PHP echo lang()->get('sidebar_components') ?></span>	
				</li>
			</a>
		<?PHP endif; 
		
		if(secure()->hasUserAccess(__ROLE_ADMIN)): ?>
			<a href='<?PHP echo base_url(__ADMIN_FOLDER.'/users.php') ?>'>
				<li>
					<img class='icon' src='images/icons/users.png' alt='' />		
					<span><?PHP echo lang()->get('sidebar_users') ?></span>		
				</li>
			</a>
		<?PHP endif; 
		
		if(secure()->hasUserAccess(__ROLE_DEV)): ?>
			<a href='<?PHP echo base_url(__ADMIN_FOLDER.'/templates.php') ?>'>
				<li>
					<img class='icon' src='images/icons/template.png' alt='' />		
					<span><?PHP echo lang()->get('sidebar_templates') ?></span>	
				</li>
			</a>
		<?PHP endif; ?>
	</ul>
</section>