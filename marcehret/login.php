<?php /* $Id: login.php 1569 2010-12-31 05:42:00Z caseydk $ $URL: https://web2project.svn.sourceforge.net/svnroot/web2project/tags/version2.3/style/wps-redmond/login.php $ */
if (!defined('W2P_BASE_DIR')) {
	die('You should not access this file directly');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo $w2Pconfig['page_title']; ?></title>
        <meta http-equiv="Content-Type" content="text/html;charset=<?php echo isset($locale_char_set) ? $locale_char_set : 'UTF-8'; ?>" />
        <title><?php echo $w2Pconfig['company_name']; ?> :: web2Project Login</title>
        <meta http-equiv="Pragma" content="no-cache" />
        <meta name="Version" content="<?php echo $AppUI->getVersion(); ?>" />
        <link rel="stylesheet" type="text/css" href="./style/common.css" media="all" charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle; ?>/main.css" media="all" charset="utf-8"/>
        <link rel="shortcut icon" href="./style/<?php echo $uistyle; ?>/favicon.ico" type="image/ico" />
    </head>

    <body id="page-login" onload="document.loginform.username.focus();">
		<?php include ('overrides.php'); ?>
		<div class="page">
	
			<h1><?php echo $w2Pconfig['company_name']; ?></h1>	

			<div class="box" id="login_box">
				<div class="box_header">
					<strong>Login</strong>
				</div><!-- box_header -->
				<div class="box_content">
					<div class="content_form">
						<!--please leave action argument empty -->
						<form method="post" action="<?php echo $loginFromPage; ?>" name="loginform" accept-charset="utf-8">

							<input type="hidden" name="login" value="<?php echo time(); ?>" />
							<input type="hidden" name="lostpass" value="0" />
							<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />					



							<table width="100%">
								<tr>
									<td align="right">
										<label><?php echo $AppUI->_('Username'); ?>:</label>
									</td>
									<td>
										<input type="text" maxlength="255" name="username" />
									</td>
								</tr>
								<tr>
									<td align="right">
										<label><?php echo $AppUI->_('Password'); ?>:</label>
									</td>
									<td>
										<input type="password" maxlength="32" name="password" />
									</td>
								</tr>
								<tr>
									<td>
									</td>
									<td>
										<input type="submit" name="login" value="<?php echo $AppUI->_('login'); ?>" />
									</td>
								</tr>
							</table>
						</form>
					</div>
					<div class="content_options">

						<?php
							$messageError1 = $AppUI->getMsg();
							if ($messageError1) {
								echo '<div class="message_error">'.$messageError1.'</div>';
							}
							$messageError2 = '';
							$messageError2 .= (version_compare(PHP_VERSION, MIN_PHP_VERSION, '<')) ? '<br /><span class="warning">WARNING: web2project is NOT SUPPORT for this PHP Version (' . PHP_VERSION . ')</span>' : '';
							$messageError2 .= function_exists('mysql_pconnect') ? '' : '<br /><span class="warning">WARNING: PHP may not be compiled with MySQL support.  This will prevent proper operation of web2Project.  Please check you system setup.</span>';
							if ($messageError2) {
								echo '<div class="message_error">'.$messageError2.'</div>';
							}
						?>

						<p>
							<a href="javascript: void(0);" onclick="f=document.loginform;f.lostpass.value=1;f.submit();"><?php echo $AppUI->_('forgotPassword'); ?></a>
						</p>

						<?php if (w2PgetConfig('activate_external_user_creation') == 'true') { ?>
						<p>
							<a href="javascript: void(0);" onclick="javascript:window.location='./newuser.php'"><?php echo $AppUI->_('newAccountSignup'); ?></a>
						</p>
						<?php } ?>
						
						
						<?php
							$messageError1 = $AppUI->getMsg();
							if ($messageError1) {
								echo '<div class="message_error">'.$messageError1.'</div>';
							}
							$messageError2 = '';
							$messageError2 .= (version_compare(PHP_VERSION, MIN_PHP_VERSION, '<')) ? '<br /><span class="warning">WARNING: web2project is NOT SUPPORT for this PHP Version (' . PHP_VERSION . ')</span>' : '';
							$messageError2 .= function_exists('mysql_pconnect') ? '' : '<br /><span class="warning">WARNING: PHP may not be compiled with MySQL support.  This will prevent proper operation of web2Project.  Please check you system setup.</span>';
							if ($messageError2) {
								echo '<div class="message_error">'.$messageError2.'</div>';
							}
						?>
					</div>
				</div><!-- box_content -->
			</div><!-- box -->
			<p class="message_cookies" style="text-align:center;padding:5px 10px;">
				<?php echo $AppUI->_('You must have cookies enabled in your browser'); ?>
			</p>
		</div><!-- page -->
    </body>
</html>