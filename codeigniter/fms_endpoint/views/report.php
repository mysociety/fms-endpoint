<div class="single-report">
	<dl class="report-data">
		<dt>Report ID</dt>
		<dd><span class="report-id"><?php echo($report->report_id) ?></span></dd>
	</dl>
	<dl class="report-data">
		<dt>Status</dt>
		<dd><?php echo($report->status)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Status Notes</dt>
		<dd><?php echo($report->status_notes)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Priority</dt>
		<dd class="fmse-prio<?php echo($report->priority)?>"><?php echo($report->prio_name)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Category</dt>
		<!-- id: <?php echo($report->category_id)?> -->
		<dd><?php echo($report->category_name)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Description</dt>
		<dd><?php echo($report->description)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Agency responsible</dt>
		<dd><?php echo($report->agency_responsible)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Service notice</dt>
		<dd><?php echo($report->service_notice)?></dd>
	</dl>
	<!--
	<dl class="report-data">
		<dt>Token</dt>
		<dd><?php echo($report->token)?></dd>
	</dl>
	-->
	<dl class="report-data">
		<dt>FMS ID</dt>
		<dd><?php echo($report->external_id)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Requested</dt>
		<dd><?php echo($report->requested_datetime)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Updated</dt>
		<dd><?php echo($report->updated_datetime)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Expected</dt>
		<dd><?php echo($report->expected_datetime)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Address</dt>
		<dd><?php echo($report->address)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Post code</dt>
		<dd><?php echo($report->postal_code)?></dd>
	</dl>
	<dl class="report-data">
		<dt>lat : long</dt>
		<dd><?php echo($report->lat)?> : <?php echo($report->long)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Email</dt>
		<dd><?php echo($report->email)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Device ID</dt>
		<dd><?php echo($report->device_id)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Account</dt>
		<dd><?php echo($report->account_id)?></dd>
	</dl>
	<dl class="report-data">
		<dt>Name</dt>
		<dd>
			<?php echo($report->first_name)?>
			<?php echo($report->last_name)?>
		</dd>
	</dl>
	<dl class="report-data">
		<dt>Phone</dt>
		<dd><?php echo($report->phone)?></dd>
	</dl>
	<dl class="report-data">
		<dt>URL</dt>
		<dd>
			<?php if ($report->media_url ) { ?>
				<a href="<?php echo("$report->media_url"); ?>"><?php echo("$report->media_url"); ?></a>
			<? } ?>
		</dd>
	</dl>
</div>