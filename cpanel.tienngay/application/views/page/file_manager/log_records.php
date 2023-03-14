<div class="col-md-12 col-xs-12">
	<div role="tabpanel" class="tab-pane col-md-12 col-xs-12 nopadding" id="tab_content3"
		 aria-labelledby="tab_content3">
		<div class="col-md-12 col-xs-12 tab-content3">
			<ul class="list-unstyled timeline">
				<div class="table-responsive">
					<table id="summary-total"
						   class="table table-striped m-table table-hover table-calendar table-report"
						   style="font-size: 14px;font-weight: 400;">
						<thead style="background:#5A738E; color: #ffffff;">
						<tr>
							<th style="width: 1%">#</th>
							<th style="width: 1%">Action</th>
							<th style="width: 1%">User</th>
							<th style="text-align: center">Time</th>
							<th style="text-align: center">Old Data</th>
							<th style="text-align: center">New Data</th>

						</tr>
						</thead>
						<tbody>
						<?php if (!empty($log_records)): ?>
							<?php  foreach ($log_records as $key => $log): ?>
								<tr>
									<td style="text-align: center"><?= ++$key ?></td>
									<td><?= $log->action ? $log->action : ''; ?></td>
									<td><?= $log->created_by ? $log->created_by : ''; ?></td>
									<td><?= $log->created_at ? date('d/m/Y H:i:s', $log->created_at) : ''; ?></td>
									<td>
										<?php
										if (!empty($log->old) && is_object($log->old)) {
											echo "<pre>".json_encode($log->old, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."</pre>";
										} else {
											echo "";
										}
										; ?>
									</td>
									<td>
										<?php
										if (!empty($log->new) && is_object($log->new)) {
											echo "<pre>".json_encode($log->new, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."</pre>";
										} else {
											echo "";
										}
										; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
						</tbody>
					</table>
				</div>

			</ul>
		</div>
	</div>
</div>
