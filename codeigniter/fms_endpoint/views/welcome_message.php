<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="/assets/fms-endpoint/css/fms-endpoint.css">
  <title><?php echo($title) ?></title>
</head>
<body id="fmse-admin">
  <div class="fmse-header">
    <h1>
      <?php echo($title) ?>
    </h1>
    <div class="fmse-nav">
      <ul>
        <li><a href='admin'>Main site</a></li> 
      </ul>
    </div>
  </div>
  <div class="fmse-content">
    <h2>
      FMS-endpoint is running 
      <?php if (count($problems) > 0) { ?>
        &mdash; but with problems 
        <img src="/assets/grocery_crud/texteditor/plugins/emotions/img/smiley-frown.gif" />        
      <?php } else { ?>
        OK
        <img src="/assets/grocery_crud/texteditor/plugins/emotions/img/smiley-smile.gif" />
      <?php } ?>
    </h2>	  
    <?php
    if (count($problems) > 0) { ?>
      <ul class="warnings">
        <?php
          for($i = 0; $i < count($problems); ++$i) {
            echo("<li><p>$problems[$i]</p><div class='details'>$details[$i]</dev></li>");
          }
        ?>
      </ul>
    <?php } ?>
</div>
  </div>
  <div class="fmse-footer">
  </div>
</body>
</html>
