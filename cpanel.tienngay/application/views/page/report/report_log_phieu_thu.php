<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-9">
			<div class="page-title">
				<div class="title_left" style="width: 100%">
					<h3> Báo cáo
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#">
								Báo cáo lỗi phiếu thu</a>
						</small>
					</h3>
					<div class="alert alert-danger alert-result" id="div_error"
						 style="display:none; color:white;"></div>
				</div>
			</div>
		</div>
		<div class="col-xs-3">

		</div>
		<div class="col-xs-12">
		
			<div class="table-responsive">
				<table id="datatable-button" class="table table-striped">
					<thead>
					<tr>
						<th>Tên lỗi</th>
						<th>Mã phiếu ghi</th>
						<th>Mã phiếu thu</th>
						<th>Loại</th>
						<th>Note</th>
						
						<th>Ngày </th>
						
					</tr>
					</thead>
					<tbody>
					<?php foreach($report as $key => $item) { ?>
						<tr>
							<td><?=$item->name?></td>
							<td><?=$item->code_contract?></td>
							<td><?=$item->code?></td>
							<td><?=$item->type?></td>
							<td><?=$item->note?></td>
						
							<td><?=date('d/m/Y',$item->date)?></td>
							
						</tr>
					<?php } ?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>

