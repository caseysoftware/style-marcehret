<?php /* $Id$ $URL$ */
$dialog = w2PgetParam($_GET, 'dialog', 0);
if ($dialog) {
	$page_title = '';
} else {
	$page_title = ($w2Pconfig['page_title'] == 'web2Project') ? $w2Pconfig['page_title'] . '&nbsp;' . $AppUI->getVersion() : $w2Pconfig['page_title'];
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta name="Description" content="web2Project Snowball Style" />
        <meta name="Version" content="<?php echo $AppUI->getVersion(); ?>" />
        <meta http-equiv="Content-Type" content="text/html;charset=<?php echo isset($locale_char_set) ? $locale_char_set : 'UTF-8'; ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <title><?php echo @w2PgetConfig('page_title'); ?></title>
        <link rel="stylesheet" type="text/css" href="./style/common.css" media="all" charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle; ?>/main.css" media="all" charset="utf-8"/>
        <link rel="shortcut icon" href="./style/<?php echo $uistyle; ?>/favicon.ico" type="image/ico" />
        <?php
            if (isset($xajax) && is_object($xajax)) {
                $xajax->printJavascript(w2PgetConfig('base_url') . '/lib/xajax');
            }
        ?>
        <?php $AppUI->loadHeaderJS(); ?>
		<script src="./style/<?php echo $uistyle; ?>/jQuery.equalHeights.js" type="text/javascript" ></script>
		<script type="text/javascript">
		    $(document).ready(function() {
				$('.equalHeight').equalHeights();
			});


			
		</script>
    </head>


    <body onload="this.focus();" class="module-<?php echo $_GET['m']; ?>">
		<div class="page">
			<div id="page-header" class="clearfix">

				<div id="page-header_logo">
					Web2Project
				</div>

				<div id="page-header_navigation-meta">
					<div id="page-header_welcome" style="float:left">
					<?php
						echo $AppUI->_('Welcome') . ' ' . ($AppUI->user_id > 0 ? $AppUI->user_first_name . ' ' . $AppUI->user_last_name : $outsider);
					?>
					</div>
					
					<?php if ($AppUI->user_id > 0) { ?>
					<div id="page-header_search" style="float:left">
						<form name="frm_search" action="?m=smartsearch" method="post" accept-charset="utf-8">
							<?php if (canAccess('smartsearch')) { ?>
								<input class="text" size="20" type="text" id="keyword" name="keyword" value="<?php echo $AppUI->_('Global Search') . '...'; ?>" onclick="document.frm_search.keyword.value=''" onblur="document.frm_search.keyword.value='<?php echo $AppUI->_('Global Search') . '...'; ?>'" />
							<?php } else {
							echo '&nbsp;';
							} ?>
						</form>
					</div>
					
					<div class="navigation horizontal inline right" id="page-header_navigation" style="float:left">
						<ul>
							<li><a href="javascript: void(0);" onclick="javascript:window.open('?m=help&amp;dialog=1&amp;hid=', 'contexthelp', 'width=800, height=600, left=50, top=50, scrollbars=yes, resizable=yes')"><?php echo $AppUI->_('Help'); ?></a></li>
							<li><a href="./index.php?m=admin&amp;a=viewuser&amp;user_id=<?php echo $AppUI->user_id; ?>"><?php echo $AppUI->_('My Info'); ?></a></li>

							<?php if (canAccess('tasks')) { ?>
							<li><a href="./index.php?m=tasks&amp;a=todo"><?php echo $AppUI->_('Todo'); ?></a></li>
							<?php
							}
							if (canAccess('calendar')) {
								$now = new w2p_Utilities_Date(); ?>
									<li><a href="./index.php?m=calendar&amp;a=day_view&amp;date=<?php echo $now->format(FMT_TIMESTAMP_DATE); ?>"><?php echo $AppUI->_('Today'); ?></a></li>
								<?php
							} ?>

							<li><a href="./index.php?logout=-1"><?php echo $AppUI->_('Logout'); ?></a></li>
							
							<?php } ?>
						</ul>
					</div>
					
				</div>
			</div><!-- page-header -->
			
			<div id="page-navigation" class="clearfix">
			
			<?php
				if (!$dialog) {
					$perms = &$AppUI->acl(); ?>

				<div id="page-navigation_main" class="navigation horizontal block">
					<ul><?php echo buildHeaderNavigation($AppUI, '', 'li'); ?></ul>
				</div>

				<div id="page-navigation_new">
					<form name="frm_new" method="get" action="./index.php" accept-charset="utf-8">
						<input type="hidden" name="a" value="addedit" />
						<?php
							//build URI string
							if (isset($company_id)) {
								echo '<input type="hidden" name="company_id" value="' . $company_id . '" />';
							}
							if (isset($task_id)) {
								echo '<input type="hidden" name="task_parent" value="' . $task_id . '" />';
							}
							if (isset($file_id)) {
								echo '<input type="hidden" name="file_id" value="' . $file_id . '" />';
							}
							if ($AppUI->user_id > 0) {
								//Do this check in case we are not using any user id, for example for external uses
								$newItem = array('' => '- New Item -');
								if (canAdd('companies')) {
									$newItem['companies'] = 'Company';
								}
								if (canAdd('contacts')) {
									$newItem['contacts'] = 'Contact';
								}
								if (canAdd('calendar')) {
									$newItem['calendar'] = 'Event';
								}
								if (canAdd('files')) {
									$newItem['files'] = 'File';
								}
								if (canAdd('projects')) {
									$newItem['projects'] = 'Project';
								}
								if (canAdd('admin')) {
									$newItem['admin'] = 'User';
								}
								if (canAdd('departments')) {
									$newItem['departments'] = 'Department';
								}
								echo arraySelect($newItem, 'm', ' onchange="f=document.frm_new;mod=f.m.options[f.m.selectedIndex].value;if (mod == \'admin\') document.frm_new.a.value=\'addedituser\';if(mod) f.submit();"', '', true);
							}
						?>
					</form>
				</div>

				<?php } // END showMenu ?>
			</div><!-- page-navigation-->

			<div id="page-main" class="clearfix">
					<?php
						$messageSystem = $AppUI->getMsg();
						if ($messageSystem) {
							echo '<div class="message-system">'.$messageSystem.'</div>';
						}