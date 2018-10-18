<?php
require('includes/header.php');
$stats = new \trackr\Stats();

$actions = $stats->actions_week_compare();
$sessions = $stats->sessions_week_compare();
$browser_race = $stats->browsers();
$viewport_race = $stats->viewports();
$action_race = $stats->actions_week_compare_list();

$persession_lw = $actions['last_week']/$sessions['last_week'];
$persession_tw = $actions['this_week']/$sessions['this_week'];
$actions_per_session = array(
	'variation'=> round(100*$persession_tw/$persession_lw-100,2),
	'last_week'=>round($persession_lw,2),
	'this_week'=>round($persession_tw,2),
);

$session = new \trackr\Session();
$session_list = $session->list_today();
?>
<div class="page-content container">
	<div class="row">
		<!-- <div class="col-md-2">
			<div class="row">
				<div class="sidebar content-box" style="display: block;">
					<?php //require('includes/menu.php');?>
				</div>
			</div>
		</div> -->

		<div class="col-md-12">
			<h1>This week data:</h1>
			<div class="row">
				<div class="col-md-4">
					<div class="content-box-header">
						<div class="panel-title">Actions</div>
					</div>
					<div class="content-box-large box-with-header" style="padding-top:15px;">
						<span class="bign"><?= $actions['this_week']?> <small>(<?= $actions['variation']>=0?'+':''?><?= $actions['variation']?>%)<br><?= $actions['last_week']?></small></span><br>
					</div>
				</div>
				<div class="col-md-4">
					<div class="content-box-header">
						<div class="panel-title">Actions per session</div>
					</div>
					<div class="content-box-large box-with-header" style="padding-top:15px;">
						<span class="bign"><?= $actions_per_session['this_week']?> <small>(<?= $actions_per_session['variation']>=0?'+':''?><?= $actions_per_session['variation']?>%)<br><?= $actions_per_session['last_week']?></small></span><br>
					</div>
				</div>
				<div class="col-md-4">
					<div class="content-box-header">
						<div class="panel-title">Sessions</div>
					</div>
					<div class="content-box-large box-with-header" style="padding-top:15px;">
						<span class="bign"><?= $sessions['this_week']?> <small>(<?= $sessions['variation']>=0?'+':''?><?= $sessions['variation']?>%)<br><?= $sessions['last_week']?></small></span><br>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-4">
					<div class="content-box-header">
						<div class="panel-title">Browser</div>
					</div>
					<div class="content-box-large box-with-header not-high" style="padding-top:0px;padding-bottom: 0px;">
						<table class="table widget">
							<?php foreach($browser_race as $row){extract($row);?>
							<tr>
								<td><?= $browser?></td>
								<td><?= $count?></td>
							</tr>
							<?php }?>
						</table>
					</div>
				</div>
				<div class="col-md-4">
					<div class="content-box-header">
						<div class="panel-title">Viewport</div>
					</div>
					<div class="content-box-large box-with-header not-high" style="padding-top:0px;padding-bottom: 0px;">
						<table class="table widget">
							<?php foreach($viewport_race as $row){extract($row);?>
							<tr>
								<td><?= strtoupper($viewport_width)?></td>
								<td><?= $count?></td>
							</tr>
							<?php }?>
						</table>
					</div>
				</div>
				<div class="col-md-4">
					<div class="content-box-header">
						<div class="panel-title">Actions</div>
					</div>
					<div class="content-box-large box-with-header not-high" style="padding-top:0px;padding-bottom: 0px;">
						<table class="table widget">
							<thead>
								<tr>
									<th>Action</th>
									<th>Last week</th>
									<th>This week</th>
								</tr>
							</thead>
							<?php foreach($action_race as $row){extract($row);?>
							<tr>
								<td><?= $value?></td>
								<td><?= $last_week?></td>
								<td><?= $this_week?></td>
							</tr>
							<?php }?>
						</table>
					</div>
				</div>
			</div>

			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">Today's sessions</div>
				</div>
				<div class="panel-body">
					<div class=" table-responsive">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dttable">
							<thead>
								<tr>
									<th>IP</th>
									<th>Browser</th>
									<th>Viewport</th>
									<th>Orientation</th>
									<th>Updated</th>
									<th>Created</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($session_list as $key=>$row){extract($row);?>
								<tr class="<?= ($key % 2 == 0)?'even':'odd';?>">
									<td><?= $ip?></td>
									<td><?= $browser?></td>
									<td><?= strtoupper($viewport_width)?></td>
									<td><?= $orientation?></td>
									<td><?= $updated?></td>
									<td><?= $created?></td>
									<td><?= $n_actions?></td>
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<?php
require('includes/footer.php');
?>