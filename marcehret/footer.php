<?php /* $Id: footer.php 1693 2011-02-22 19:12:43Z pedroix $ $URL: https://web2project.svn.sourceforge.net/svnroot/web2project/tags/version2.3/style/wps-redmond/footer.php $ */
                    global $a, $AppUI;
                    if (function_exists('styleRenderBoxBottom') && (w2PgetParam($_GET, 'tab', 0) != -1)) {
                        echo styleRenderBoxBottom();
                    }
					
					echo '</div></div>';
					
                    $AppUI->loadFooterJS();
                    echo $AppUI->getMsg();
                    ?>
                