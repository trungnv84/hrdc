<?php
if (!isset($cs)) $cs = Yii::app()->getClientScript();
if (!isset($baseUrl)) $baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($baseUrl.'/js/select2-3.4.5/select2.css');
$cs->registerScriptFile($baseUrl.'/js/select2-3.4.5/select2.js');
$cs->registerScriptFile($baseUrl.'/js/hotkey.js');
$cs->registerScriptFile($baseUrl.'/js/quick_search.js');
?>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			<!-- Be sure to leave the brand out there if you want it shown -->
			<a class="brand" href="#"><?php echo Yii::app()->name; ?>
				<small></small>
			</a>

			<div class="nav-collapse">
				<?php $this->widget('zii.widgets.CMenu', array(
					'htmlOptions' => array('class' => 'pull-right nav'),
					'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
					'itemCssClass' => 'item-test',
					'encodeLabel' => false,
					'items' => array(
						//TODO: Change navigation
						array('label' => 'Dashboard', 'url' => array('/')),
						array('label' => 'Human Resource', 'url' => array('/humanresources/admin')),
						array('label' => 'Resource Allocation', 'url' => array('/resourceallocation/admin')),

						/*array('label' => 'Tables', 'url' => array('/site/page', 'view' => 'tables')),
						array('label' => 'Interface', 'url' => array('/site/page', 'view' => 'interface')),
						array('label' => 'Typography', 'url' => array('/site/page', 'view' => 'typography')),*/
						/*array('label'=>'Gii generated', 'url'=>array('customer/index')),*/
						/*array('label' => 'My Account <span class="caret"></span>', 'url' => '#', 'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"), 'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
							'items' => array(
								array('label' => 'My Messages <span class="badge badge-warning pull-right">26</span>', 'url' => '#'),
								array('label' => 'My Tasks <span class="badge badge-important pull-right">112</span>', 'url' => '#'),
								array('label' => 'My Invoices <span class="badge badge-info pull-right">12</span>', 'url' => '#'),
								array('label' => 'Separated link', 'url' => '#'),
								array('label' => 'One more separated link', 'url' => '#'),
							)),*/
						array('label' => 'Settings <span class="caret"></span>', 'url' => '#', 'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"), 'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
							'items' => array(
								array('label' => 'Account Manager', 'url' => array('/users/admin')),
							)),
						array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
						array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
					),
				)); ?>
			</div>
		</div>
	</div>
</div>

<div class="subnav navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">

			<div class="style-switcher pull-left">
				<a href="javascript:chooseStyle('none', 60)" checked="checked"><span class="style" style="background-color:#0088CC;"></span></a>
				<a href="javascript:chooseStyle('style2', 60)"><span class="style" style="background-color:#7c5706;"></span></a>
				<a href="javascript:chooseStyle('style3', 60)"><span class="style" style="background-color:#468847;"></span></a>
				<a href="javascript:chooseStyle('style4', 60)"><span class="style" style="background-color:#4e4e4e;"></span></a>
				<a href="javascript:chooseStyle('style5', 60)"><span class="style" style="background-color:#d85515;"></span></a>
				<a href="javascript:chooseStyle('style6', 60)"><span class="style" style="background-color:#a00a69;"></span></a>
				<a href="javascript:chooseStyle('style7', 60)"><span class="style" style="background-color:#a30c22;"></span></a>
			</div>
			<form id="quick_search" class="navbar-search pull-right" action="">
				<input type="text" id="search_query" class="search-query span2 hot-key" placeholder="Search"
				       data-hot-key-container="#s2id_search_query" data-hot-key-label="Search" data-hot-key-code="z"
				       data-hot-key-action="trigger" data-hot-key-trigger="select2click" data-hot-key-z-index="1031"
				       data-hot-key-position="fixed">
			</form>
		</div>
		<!-- container -->
	</div>
	<!-- navbar-inner -->
</div><!-- subnav -->