<?php
if (!defined('W2P_BASE_DIR')) {
    die('You should not access this file directly.');
}

class style_marcehret extends w2p_Theme_Base
{

}

##
##  This overrides the show function of the CTabBox_core function
##
class CTabBox extends w2p_Theme_TabBox {
	function show($extra = '', $js_tabs = false) {
		global $AppUI, $w2Pconfig, $currentTabId, $currentTabName, $m, $a;
		$this->loadExtras($m, $a);
		$uistyle = $AppUI->getPref('UISTYLE') ? $AppUI->getPref('UISTYLE') : $w2Pconfig['host_style'];
		if (!$uistyle) {
			$uistyle = 'web2project';
		}
		reset($this->tabs);
		$s = '';
		// tabbed / flat view options
		if ($AppUI->getPref('TABVIEW') == 0) {

					$s = '<div class="section clearfix">';
						$s .= '<div class="navigation horizontal" id="navigation-tabbed" style="float:left;">';
							$s .= '<ul>';
								$s .= '<li><a href="' . $this->baseHRef . 'tab=0">' . $AppUI->_('tabbed') . '</a></li>';
								$s .= '<li><a href="' . $this->baseHRef . 'tab=-1">' . $AppUI->_('flat') . '</a></li>';
							$s .= '</ul>';
						$s .= '</div>';
					$s .= '';

					$s .= '<div style="float:right">';
						$s .= $extra;
					$s .= '</div></div>';

			echo $s;
		} else {
			if ($extra) {
				echo '<div class="navigation_tabbed-flat clearfix"><div style="float:right">' . $extra . '</div></div>';
			}
		}

		if ($this->active < 0 || $AppUI->getPref('TABVIEW') == 2) {
			// flat view, active = -1
			echo '<div id="tabbed_flat">';
			foreach ($this->tabs as $k => $v) {
				echo '<div class="box">';
				echo '<div class="box_header">' . ($v[2] ? $v[1] : $AppUI->_($v[1])) . '</div><div class="box_content">';
				$currentTabId = $k;
				$currentTabName = $v[1];
				include $this->baseInc . $v[0] . '.php';
				echo '</div></div>';
			}
			echo '</div>';
		} else {
			// tabbed view
			$s = '<div class="section clearfix"><div class="navigation horizontal block" id="navigation-tabs"><ul>';

			if (count($this->tabs) - 1 < $this->active) {
				//Last selected tab is not available in this view. eg. Child tasks
				$this->active = 0;
			}
			foreach ($this->tabs as $k => $v) {
				$class = ($k == $this->active) ? 'tabon' : 'taboff';
				$sel = ($k == $this->active) ? 'Selected' : '';
				$s .= '<li id="toptab_' . $k . '" ';
				$s .= ' class="' . $class . '"';
				$s .= '><a href="';
				if ($this->javascript) {
					$s .= 'javascript:' . $this->javascript . "({$this->active}, $k)";
				} elseif ($js_tabs) {
					$s .= 'javascript:show_tab(' . $k . ')';
				} else {
					$s .= $this->baseHRef . 'tab=' . $k;
				}
				$s .= '"><span>' . ($v[2] ? $v[1] : $AppUI->_($v[1])) . '</span></a></li>';
			}
			$s .= '</ul></div>';
			$s .= '<div class="box_content">';
			echo $s;
			//Will be null if the previous selection tab is not available in the new window eg. Children tasks
			if ($this->tabs[$this->active][0] != '') {
				$currentTabId = $this->active;
				$currentTabName = $this->tabs[$this->active][1];
				if (!$js_tabs) {
					require $this->baseInc . $this->tabs[$this->active][0] . '.php';
				}
			}
			if ($js_tabs) {
				foreach ($this->tabs as $k => $v) {
					echo '<div class="tab" id="tab_' . $k . '">';
					$currentTabId = $k;
					$currentTabName = $v[1];
					require $this->baseInc . $v[0] . '.php';
					echo '</div>';
					echo '<script language="javascript" type="text/javascript">
						<!--
						show_tab(' . $this->active . ');
						//-->
						</script>';
				}
			}
			echo '</div></div>';
		}
	}
}











