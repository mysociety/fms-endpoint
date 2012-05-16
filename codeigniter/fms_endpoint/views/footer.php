  </div>
  <div class="fmse-footer">
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
