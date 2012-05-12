<div class="single-report">
	<?php if ($image_url) { ?>
		<a href="<?php echo( $image_url ); ?>"><img class="image" src="<?php echo( $image_url ); ?>" alt=""/></a>
	<?php } ?>
	<div class="report-data">
		<dl >
			<dt>Report ID</dt>
			<dd><span class="report-id"><?php echo($report->report_id) ?></span></dd>
		</dl>
		<dl >
			<dt>Status</dt>
			<dd class="fmse-status-<?php echo($report->is_closed)?>"><?php echo($report->status_name)?></dd>
		</dl>
		<dl >
			<dt>Status Notes</dt>
			<dd><?php echo($report->status_notes)?></dd>
		</dl>
		<dl >
			<dt>Priority</dt>
			<dd class="fmse-prio<?php echo($report->priority)?>"><?php echo($report->prio_name)?></dd>
		</dl>
		<dl >
			<dt>Category</dt>
			<!-- id: <?php echo($report->category_id)?> -->
			<dd><?php echo($report->category_name)?></dd>
		</dl>
		<dl >
			<dt>Description</dt>
			<dd><?php echo($report->description)?></dd>
		</dl>
		<dl >
			<dt>Agency responsible</dt>
			<dd><?php echo($report->agency_responsible)?></dd>
		</dl>
		<dl >
			<dt>Service notice</dt>
			<dd><?php echo($report->service_notice)?></dd>
		</dl>
		<!--
		<dl >
			<dt>Token</dt>
			<dd><?php echo($report->token)?></dd>
		</dl>
		-->
		<dl >
			<dt>FMS ID</dt>
			<dd><?php echo($report->external_id)?></dd>
		</dl>
		<dl >
			<dt>Requested</dt>
			<dd><?php echo($report->requested_datetime)?></dd>
		</dl>
		<dl >
			<dt>Updated</dt>
			<dd><?php echo($report->updated_datetime)?></dd>
		</dl>
		<dl >
			<dt>Expected</dt>
			<dd><?php echo($report->expected_datetime)?></dd>
		</dl>
		<dl >
			<dt>Address</dt>
			<dd><?php echo($report->address)?></dd>
		</dl>
		<dl >
			<dt>Post code</dt>
			<dd><?php echo($report->postal_code)?></dd>
		</dl>
		<dl >
			<dt>lat : long</dt>
			<dd><?php echo($report->lat)?> : <?php echo($report->long)?></dd>
		</dl>
		<dl >
			<dt>Email</dt>
			<dd><?php echo($report->email)?></dd>
		</dl>
		<dl >
			<dt>Device ID</dt>
			<dd><?php echo($report->device_id)?></dd>
		</dl>
		<dl >
			<dt>Account</dt>
			<dd><?php echo($report->account_id)?></dd>
		</dl>
		<dl >
			<dt>Name</dt>
			<dd>
				<?php echo($report->first_name)?>
				<?php echo($report->last_name)?>
			</dd>
		</dl>
		<dl >
			<dt>Phone</dt>
			<dd><?php echo($report->phone)?></dd>
		</dl>
		<dl >
			<dt>URL</dt>
			<dd>
				<?php if ($report->media_url ) { ?>
					<a href="<?php echo("$report->media_url"); ?>"><?php echo("$report->media_url"); ?></a>
				<? } ?>
			</dd>
		</dl>
	</div>
</div>