<?php
class CommonAction extends Action
{
	protected $_admin = array();
	//增加开始
	protected $city_id = 0;
	protected $city = array();
	//增加结束
	protected $_CONFIG = array();

	protected function _initialize()
	{	
		$this->_admin = session('admin');
		if ((strtolower(MODULE_NAME) != 'login') && (strtolower(MODULE_NAME) != 'public')) {
			if (empty($this->_admin)) {
				header('Location: ' . u('login/index'));
				exit();
			}
	
            //演示账号不能操作结束
			if ($this->_admin['role_id'] != 1) {
				$this->_admin['menu_list'] = d('RoleMaps')->getMenuIdsByRoleId($this->_admin['role_id']);

				if (strtolower(MODULE_NAME) != 'index') {
					$menu_action = strtolower(MODULE_NAME . '/' . ACTION_NAME);
					$menu = d('Menu')->fetchAll();
					$menu_id = 0;

					foreach ($menu as $k => $v) {
						if ($v['menu_action'] == $menu_action) {
							$menu_id = (int) $k;
							break;
						}
					}

					if (empty($menu_id) || !isset($this->_admin['menu_list'][$menu_id])) {
						//$this->error('很抱歉您没有权限操作模块:' . $menu[$menu_id]['menu_name']);
					}
				}
			}
		}
		
		

		$this->_CONFIG = d('Setting')->fetchAll();
		define('__HOST__', 'http://' . $_SERVER['HTTP_HOST']);
		$this->assign('CONFIG', $this->_CONFIG);
		$this->assign('admin', $this->_admin);
		$this->assign('ctl', strtolower(MODULE_NAME));
        $this->assign('act', ACTION_NAME);
		$this->assign('today', TODAY);
		//增加辨别城市开始
		
		$this->city_id = $this->_admin['city_id'];
		$this->assign('city_id', $this->city_id);
		
		$citys = D('City')->where(array('closed' => 0,'city_id'=>$this->city_id))->select();//这里应该查询fetchAll不过有缓存会错误
		$this->assign('citys', $citys);
		
		//做好安全
			
		if(!empty($this->_admin['role_id'])){
			if ($this->_admin['role_id'] != 3) {
					session('admin',null);
					$this->error('您不是水站管理员,正在跳转到分站登录页！', U('Shuiadminmobile/login/index'));
			}
		}	
			
		

		//增加结束
		$this->assign('nowtime', NOW_TIME);
	}

	protected function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '')
	{
		parent::display($this->parseTemplate($templateFile), $charset, $contentType, $content = '', $prefix = '');
	}

	 private function parseTemplate($template = '')
    {
        $depr = C('TMPL_FILE_DEPR');
        $template = str_replace(':', $depr, $template);
        $theme = $this->getTemplateTheme();
        define('NOW_PATH', BASE_PATH . '/themes/' . $theme . 'Shuiadminmobile/');
        define('THEME_PATH', BASE_PATH . '/themes/default/Shuiadminmobile/');
        define('APP_TMPL_PATH', __ROOT__ . '/themes/default/Shuiadminmobile/');
        if ('' == $template) {
            $template = strtolower(MODULE_NAME) . $depr . strtolower(ACTION_NAME);
        } elseif (false === strpos($template, '/')) {
            $template = strtolower(MODULE_NAME) . $depr . strtolower($template);
        }
        $file = NOW_PATH . $template . C('TMPL_TEMPLATE_SUFFIX');
        if (file_exists($file)) {
            return $file;
        }
        return THEME_PATH . $template . C('TMPL_TEMPLATE_SUFFIX');
    }
    private function getTemplateTheme()
    {
        define('THEME_NAME', 'default');
        if ($this->theme) {
            // 指定模板主题
            $theme = $this->theme;
        } else {
            /* 获取模板主题名称 */
            $theme = D('Template')->getDefaultTheme();
            if (C('TMPL_DETECT_THEME')) {
                // 自动侦测模板主题
                $t = C('VAR_TEMPLATE');
                if (isset($_GET[$t])) {
                    $theme = $_GET[$t];
                } elseif (cookie('think_template')) {
                    $theme = cookie('think_template');
                }
                if (!in_array($theme, explode(',', C('THEME_LIST')))) {
                    $theme = C('DEFAULT_THEME');
                }
                cookie('think_template', $theme, 864000);
            }
        }
        return $theme ? $theme . '/' : '';
    }
	protected function baoSuccess($message, $jumpUrl = '', $time = 3000)
	{
		$str = '<script>';
		$str .= 'parent.success("' . $message . '",' . $time . ',\'jumpUrl("' . $jumpUrl . '")\');';
		$str .= '</script>';
		exit($str);
	}
	
	

	protected function baoError($message, $time = 3000, $yzm = false)
	{
		$str = '<script>';

		if ($yzm) {
			$str .= 'parent.error("' . $message . '",' . $time . ',"yzmCode()");';
		}
		else {
			$str .= 'parent.error("' . $message . '",' . $time . ');';
		}

		$str .= '</script>';
		exit($str);
	}

	protected function checkFields($data = array(), $fields = array())
	{
		foreach ($data as $k => $val) {
			if (!in_array($k, $fields)) {
				unset($data[$k]);
			}
		}

		return $data;
	}

	protected function ipToArea($_ip)
	{
		return iptoarea($_ip);
	}
}

?>
