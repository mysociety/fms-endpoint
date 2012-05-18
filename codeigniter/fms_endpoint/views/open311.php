<html>
<body>
	<div class="text-content">
		<h2>
			Open311 API information
		</h2>
		<p>
			This server implements <abbr title="work in progress!">some</abbr> of the 
			<a href="http://wiki.open311.org/GeoReport_v2">Open311 GeoReport v2</a> specification.
		</p>
		<p>
			This means that it receives incoming reports of civic problems, and also publishes them, via the Open311 API.
		</p>
		<ul class="<?php echo(is_config_true(config_item('enable_open311_server'))? 'success_messages' : 'warnings');?>">
			<li>
				<p>
					<strong style="font-size:120%;">
						The Open311 server is currently
						<?php if(! is_config_true(config_item('enable_open311_server'))) { echo('not');}?>
						running
					</strong>
					<?php if ($auth->is_admin()) { ?>
						<span class="admin-inline-text">
							<a href="settings/edit/enable_open311_server">
								<?php if(is_config_true(config_item('enable_open311_server'))) { echo('disable');} else {echo('enable');} ?>
								Open311
							</a>
						</span>
					</p>
				<?php } ?>
			</li>
		</ul>
		<ul>
			<li>
				<strong>
					Submit requests 
					<?php if(is_config_true(config_item('open311_use_api_keys'))) { ?>
						will be rejected unless they include a valid <span class="code">api_key</span>
					<?php } else { ?>
						do not require an API key
					<?php } ?>
				</strong>
				<?php if ($auth->is_admin()) { ?>
					<span class="admin-inline-text">
						<a href="settings/edit/open311_use_api_keys">change&nbsp;this</a>
						|
						<a href="api_keys">see&nbsp;keys</a>
					</span>
				<?php } ?>
			</li>
			<li>
				<strong>
					Submit requests 
					<?php if(is_config_true(config_item('open311_use_external_id'))) { ?>
						must provide an external report ID 
					<?php } else { ?>
						can optionally provide an external report ID
					<?php } ?>
					as 
					<span class="code">attrib[<?php echo(config_item('open311_use_external_name')) ?>]</span>
					
				</strong>
				<?php if ($auth->is_admin()) { ?>
					<span class="admin-inline-text">
						<a href="settings/edit/open311_use_api_keys">change&nbsp;setting</a>
						|
						<a href="settings/edit/open311_use_external_name">change&nbsp;name</a>
					</span>
				<?php } ?>
			</li>
			<li> Example URLs:
              <span class="code open311api_hints">
	              <br/><?php echo(config_item('base_url')); ?>/services/<i>&lt;service-id&gt;</i>.xml 
	              <br/><?php echo(config_item('base_url')); ?>/services.xml
	              <br/><?php echo(config_item('base_url')); ?>/requests/<i>&lt;report-id&gt;</i>.xml
	              <br/><?php echo(config_item('base_url')); ?>/requests.xml
              </span>
			</li>
		</ul>
	</div>
</body>
</html>