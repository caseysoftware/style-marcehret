<?php /* $Id: lostpass.php 1335 2010-09-06 03:14:57Z caseydk $ $URL: https://web2project.svn.sourceforge.net/svnroot/web2project/tags/version2.3/style/wps-redmond/lostpass.php $ */
if (!defined('W2P_BASE_DIR')) {
	die('You should not access this file directly');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo @w2PgetConfig('page_title'); ?></title>
        <meta http-equiv="Content-Type" content="text/html;charset=<?php echo isset($locale_char_set) ? $locale_char_set : 'UTF-8'; ?>" />
        <title><?php echo $w2Pconfig['company_name']; ?> :: web2Project Lost Password Recovery</title>
        <meta http-equiv="Pragma" content="no-cache" />
        <meta name="Version" content="<?php echo $AppUI->getVersion(); ?>" />
        <link rel="stylesheet" type="text/css" href="./style/common.css" media="all" charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle; ?>/main.css" media="all" charset="utf-8"/>
        <style type="text/css" media="all">@import "./style/<?php echo $uistyle; ?>/main.css";</style>
        <link rel="shortcut icon" href="./style/<?php echo $uistyle; ?>/favicon.ico" type="image/ico" />
    </head>

    <body id="page-lostpassword" onload="document.lostpassform.checkusername.focus();">
        <?php include ('overrides.php'); ?>

		<h1><?php echo $w2Pconfig['company_name']; ?></h1>


		<div class="grid_box" id="login_box">
			<div class="grid_box_header">
				<h2>Get password</h2>
			</div>
			<div class="grid_box_content">
				<!--please leave action argument empty -->
				<div class="content content_form">
					<form class="form-vertical" method="post" name="lostpassform" accept-charset="utf-8">
						<input type="hidden" name="lostpass" value="1" />
						<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
						<dl class="input">
							<dt><label><?php echo $AppUI->_('Username'); ?>:</label></dt>
							<dd><span class="field"><input type="text" size="25" maxlength="255" name="checkusername" class="text" /></span></dd>
						</dl>
						<dl class="input">
							<dt><label><?php echo $AppUI->_('EMail'); ?>:</label></dt>
							<dd><span class="field"><input type="email" size="25" maxlength="255" name="checkemail" class="text" /></span></dd>
						</dl>
						<dl>
							<dt class="hidden"><label>&nbsp;</label></dt>
							<dd><span><input type="submit" name="sendpass" value="<?php echo $AppUI->_('send password'); ?>" class="button" /></span></dd>
						</dl>
					</form>						
				</div>
			</div>
		</div>
        <p class="message-error">
            <?php
                echo '<span class="error">' . $AppUI->getMsg() . '</span>';
                $msg = '';
                $msg .= (version_compare(PHP_VERSION, MIN_PHP_VERSION, '<')) ? '<br /><span class="warning">WARNING: web2project is NOT supported for this PHP Version (' . PHP_VERSION . ')</span>' : '';
                $msg .= function_exists('mysql_pconnect') ? '' : '<br /><span class="warning">WARNING: PHP may not be compiled with MySQL support.  This will prevent proper operation of web2Project.  Please check your system setup.</span>';
                echo $msg;
            ?>
        </p>
    </body>
</html>