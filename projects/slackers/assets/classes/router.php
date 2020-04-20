<?php

class Router {
	private $exceptions;

	public function __construct() {
		$this->exceptions = array(
			'attendance' => 'raids/attendance',
			'baa' => 'addons/baa',
			'bt' => 'addons/bt',
			'bonusrolls' => 'raids/bonusrolls',
			'info' => 'general/info',
			'login' => 'users/login',
			'logout' => 'users/logout',
			'mla' => 'addons/mla',
			'mount' => 'addons/mount',
			'refresh' => 'shoutbox/refresh',
			'register' => 'users/register',
			'reindex' => 'scripts/reindex',
			'reserves' => 'general/reserves',
			'rules' => 'general/rules',
			'spent' => 'raids/spent',
			'spreadsheets' => 'raids/spreadsheets',
			'welcome' => 'users/welcome',
			'' => 'home'
		);
	}

	private function getFile() {
		$file = getURI(fullURL());

		if (strpos($file, '?') !== false) {
			$explode = explode('?', $file);
			$file = $explode[0];
		}

		// Trim the / off filename.
		$file = ltrim($file, '/');

		// Check if the uri is different from the path.
		if (isset($this->exceptions[$file])) {
			$file = $this->exceptions[$file];
		}

		// Check for a specified extension.
		if (!isset($variables['ext'])) {
			$file = $file . '.php';
		} else {
			$file = $file . $variables['ext'];
		}

		return $file;
	}

	private function getCleanURI() {
		$uri = getURI(fullURL());

		if (strpos($uri, '?') !== false) {
			$explode = explode('?', $uri);
			$uri = $explode[0];
		}

		return $uri;
	}

	private function getData() {
		$file = getURI(fullURL());

		// Returns any $_GET information. You cannot use $_GET[], so use $data[].
		if (strpos($file, '?') !== false) {
			$explode = explode('?', $file);
			$file = $explode[0];
			$get_data = $explode[1];
		}

		if (isset($get_data)) {
			parse_str($get_data, $data);

			foreach ($data as $k => $v) {
				$data[$k] = htmlspecialchars($v);
			}

			return $data;
		}
	}

	private function getCondition($file) {
		$file = ltrim($this->getCleanURI(), '/');

		$admin = array('reindex', 'admin/promote', 'admin/demote', 'articles/delete');
		$mod = array('articles/edit', 'articles/new', 'moderate/approve', 'moderate/denied', 'moderate/deny', 'moderate/pending');
		$logged_in = array('users/account');

		if (in_array($file, $admin)) {
			return $condition = !current_user() or !current_user()->is_admin;
		} elseif (in_array($file, $mod)) {
			return $condition = !current_user() or !current_user()->is_mod;
		} elseif (in_array($file, $logged_in)) {
			return $condition = !current_user();
		} else {
			return false;
		}
	}

	public function render($variables = array()) {
		$file = $this->getFile();
		$data = $this->getData();
		$condition = $this->getCondition($file);

		// Protected files
		if (file_exists('protected/controllers/' . $file) or file_exists('protected/views/' . $file)) {
			if ($condition) {
				$this->renderView(array('errors' => 'denied'));
			} elseif (file_exists('protected/controllers/' . $file)) {
				include('protected/controllers/' . $file);
			} elseif (file_exists('protected/views/' . $file)) {
				$this->renderView(array('protected' => true));
			} else {
				$this->renderView(array('errors' => '404'));
			}

			return;
		}

		// Normal files
		if ($condition) {
			$this->renderView(array('errors' => 'denied'));
		} elseif (file_exists('controllers/' . $file)) {
			include('controllers/' . $file);
		} elseif (file_exists('views/' . $file)) {
			$this->renderView($variables);
		} else {
			$this->renderView(array('errors' => '404'));
		}
	}

	private function getContents($path, $variables = array()) {
		ob_start();

		foreach ($variables as $k => $v) {
			$$k = $v;
		}

		include($path);

		return ob_get_clean();
	}

	public function renderView($variables = array()) {
		$file = $this->getFile();
		$data = $this->getData();

		if (isset($variables['errors'])) {
			$path = 'errors/' . $variables['errors'] . '.php';
		} elseif (isset($variables['protected'])) {
			$path = 'protected/views/' . $file;
		} else {
			$path = 'views/' . $file;
		}

		$variables['content'] = $this->getContents($path, $variables);

		echo $this->getContents('layout.php', $variables);
	}

	public function redirect_to($page) {
		if (strpos($page, '/') != 1) {
			$page = '/' . $page;
		}

		if ($_SERVER['HTTP_HOST'] == 'portfolio') {
			$url = str_replace('portfolio', '', LOCALHOST . $page);
		} else {
			$url = 'http://' . DOMAIN . $page;
		}

		header('Location: ' . $url);
	}
}
