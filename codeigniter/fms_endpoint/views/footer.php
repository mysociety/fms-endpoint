  </div>
  <div class="fmse-footer">
    <p style="float:left;">
      Open311 server enabled: <?php echo config_item('enable_open311_server') ?>
    </p>
    <?php if ($auth->logged_in()) { ?>
      <a href='<?php echo site_url('admin/about')?>' class="fmse-mysoc">about</a>
    <?php } ?>
  </div>
</body>
</html>
