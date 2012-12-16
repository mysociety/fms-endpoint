  </div>
  <div class="fmse-footer">
	<?php 
		$org_url = config_item('organisation_url');
		if (! empty($org_url)) { ?>
			<div class="departmental-link">
				<a href="<?php echo $org_url; ?>" class="<?php echo (preg_match('/https?:\/\/(\\w*\\.)*fixmy/', $org_url))? 'fmse-web-link-fms':'fmse-web-link' ?>"><?php 
				if (config_item('organisation_link_text')) {
					echo config_item('organisation_link_text');
				} else {
					echo $org_url;
				}
			?></a>
		</div>
	<?php } ?>
    <div class="open311-status">
      <a href="/admin/open311" 
        class="open311-status-<?php if(is_config_true(config_item('enable_open311_server'))) { echo('on');} else {echo('off');} ?>">
        Open311 server is
        <?php if(is_config_true(config_item('enable_open311_server'))) { echo('on');} else {echo('off');} ?>
      </a>
    </div>
    <?php if ($auth->logged_in()) { ?>
      <a href='<?php echo site_url('admin/about')?>' class="fmse-mysoc">about</a>
    <?php } ?>
  </div>
</body>
</html>
