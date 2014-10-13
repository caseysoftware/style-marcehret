<?php /* $Id: overrides.php 1569 2010-12-31 05:42:00Z caseydk $ $URL: https://web2project.svn.sourceforge.net/svnroot/web2project/tags/version2.3/style/wps-redmond/overrides.php $ */

class CTitleBlock extends CTitleBlock_core {

	function show() {
		global $AppUI, $a, $m, $tab, $infotab;
		$this->loadExtraCrumbs($m, $a);
		$uistyle = $AppUI->getPref('UISTYLE') ? $AppUI->getPref('UISTYLE') : $w2Pconfig['host_style'];

		$title_temp = $AppUI->_($this->title);
		if ($title_temp) {
			$s = '<div class="section clearfix"><h1 style="float:left;">' . $title_temp . '</h1>';
		} else {
			$s = '<div class="section clearfix content_options">';		
		}
		


		
		$s .= '<div style="float:right;">';

		foreach ($this->cells1 as $c) {
			$s .= '<div style="float:left;padding-left:5px;" ' . ($c[0] ? (' ' . $c[0]) : '') . '>';		
			$s .= $c[2] ? $c[2] : '';
			$s .= $c[1] ? $c[1] : '';
			$s .= $c[3] ? $c[3] : '';			
			$s .= '</div>';
		}
		$s .= '</div></div>';

		if (count($this->crumbs) || count($this->cells2)) {
			$crumbs = array();
			$class = 'navigation horizontal';
			foreach ($this->crumbs as $k => $v) {
				$t = $v[1] ? '<img class="testxxx" src="' . w2PfindImage($v[1], $this->module) . '" border="" alt="" />&nbsp;' : '';
				$t .= $AppUI->_($v[0]);
				$crumbs[] = '<li><a href="'.$k.'"><span>'.$t.'</span></a></li>';
			}
			$s .= '<div class="section clearfix"><div class="'.$class.'" style="float:left;"><ul>';
			$s .= implode('', $crumbs);
			$s .= '</ul></div><div style="float:right">';

			foreach ($this->cells2 as $c) {
				$s .= '<div style="float:left" ' . ($c[0] ? " $c[0]" : '') . '>';			
				$s .= $c[2] ? $c[2] : '';
				$s .= $c[1] ? $c[1] : '';
				$s .= $c[3] ? $c[3] : '';
				$s .= '</div>';
			}
			$s .= '</div></div>';
		}
		echo '' . $s;
//		if (($a != 'index' || $m == 'system' || $m == 'calendar' || $m == 'smartsearch') && !$AppUI->boxTopRendered && function_exists('styleRenderBoxTop')) {
//			echo styleRenderBoxTop();
//			$AppUI->boxTopRendered = true;
//		}
	}

}

##
##  This overrides the show function of the CTabBox_core function
##
class CTabBox extends CTabBox_core {
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











