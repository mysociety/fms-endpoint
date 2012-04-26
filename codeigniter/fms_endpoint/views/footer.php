  </div>
  <div class="fmse-footer">
    <?php if ($auth->logged_in()) { ?>
      <a href='<?php echo site_url('admin/about')?>' class="fmse-mysoc">about</a>
    <?php } ?>
  </div>
</body>
</html>
