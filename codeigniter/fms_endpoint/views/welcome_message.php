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
    if (count($problems) == 0) { ?>
      <ul class="success_messages">
        <li>
          <p>
            This is the FMS-endpoint root page.
          </p>
          <div class="details">
              You can leave this page as it is, or:
              <ul>
                <li>redirect this page automatically (for example, to the <a href="admin">admin</a>) by logging in as the administrator,
                  and changing the <b>redirect_root_page</b> setting in <a href="admin/settings/edit/redirect_root_page">config settings</a> 
                <li>edit <span class="code">fms_endpoint/views/welcome_message.php</span> and replace it with your own content
              </ul>
          </div>
        </li>
        <li>
          <p> The Open311 service is currently <b>
            <?php if (! $is_open311_enabled) { echo('not'); } ?>
             enabled</b>, so  
            <?php if (! $is_open311_enabled) { echo('attempts to use it will be rejected.'); } else { ?>
              requests to the following URLs will be serviced.
              <span class="code open311api_hints">
              <br/>services/<i>&lt;service-id&gt;</i>.xml 
              <br/>services.xml
              <br/>requests/<i>&lt;report-id&gt;</i>;.xml
              <br/>requests.xml
              </span>
            <?php } ?>
          </p>
          <div class="details">
              You can switch the Open311 server on and off by logging in as the administrator, and changing <b>enable_open311_server</b>
              setting in <a href="admin/settings/edit/enable_open311_server">config settings</a>.
          </div>
        </li>
      </ul>
    <?php } else { ?>
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
