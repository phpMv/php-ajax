<?php
namespace PHPMV\ajax;

use PHPMV\js\JsUtils;
use PHPMV\core\TemplateParser;
use PHPMV\core\Library;

/**
 * Ajax Axios implementation.
 * PHPMV\ajax$Http
 * This class is part of php-ajax
 *
 * @author jc
 * @version 1.0.0
 *
 */
class Http {

	public static $axiosPrefix = 'axios';

	private static $template;

	public static function init() {
		self::$template = new TemplateParser();
		self::$template->loadTemplatefile(Library::getTemplateFolder() . '/axios-request');
	}

	/**
	 * Send a request.
	 *
	 * @param string $method
	 * @param string $url
	 * @param mixed $data
	 * @param string $successCallback
	 * @param string $errorCallback
	 * @return string
	 */
	public static function request(string $method, string $url, $data = '{}', ?string $successCallback = '', ?string $errorCallback = null): string {
		if (\strpos($url, "'") === false && \strpos($url, '$') === false && \substr($url, 0, \strlen('this')) !== 'this') {
			$url = "'$url'";
		}
		$data = JsUtils::objectToJSON($data);
		$error = '';
		if ($errorCallback != null) {
			$error = ',function(response) {' . $errorCallback . '}';
		}
		$result = self::$template->parse([
			'axios-prefix' => self::$axiosPrefix,
			'method' => "'$method'",
			'url' => $url,
			'data' => $data ?? '{}',
			'successCallback' => $successCallback,
			'error' => $error
		]);
		return $result;
	}

	/**
	 *
	 * @param string $method
	 * @param string $url
	 * @param mixed $data
	 * @param string $successCallback
	 * @param string $errorCallback
	 * @return string
	 */
	public static function get(string $method, string $url, $data = null, ?string $successCallback = '', ?string $errorCallback = null): string {
		return self::request('get', $url, $data, $successCallback, $errorCallback);
	}

	/**
	 * Send a post request.
	 *
	 * @param string $method
	 * @param string $url
	 * @param mixed $data
	 * @param string $successCallback
	 * @param string $errorCallback
	 * @return string
	 */
	public static function post(string $method, string $url, $data = null, ?string $successCallback = '', ?string $errorCallback = null): string {
		return self::request('post', $url, $data, $successCallback, $errorCallback);
	}

	/**
	 * Send a patch request.
	 *
	 * @param string $method
	 * @param string $url
	 * @param mixed $data
	 * @param string $successCallback
	 * @param string $errorCallback
	 * @return string
	 */
	public static function patch(string $method, string $url, $data = null, ?string $successCallback = '', ?string $errorCallback = null): string {
		return self::request('patch', $url, $data, $successCallback, $errorCallback);
	}

	/**
	 * Send a put request.
	 *
	 * @param string $method
	 * @param string $url
	 * @param mixed $data
	 * @param string $successCallback
	 * @param string $errorCallback
	 * @return string
	 */
	public static function put(string $method, string $url, $data = null, ?string $successCallback = '', ?string $errorCallback = null): string {
		return self::request('put', $url, $data, $successCallback, $errorCallback);
	}

	/**
	 * Send a delete request.
	 *
	 * @param string $method
	 * @param string $url
	 * @param mixed $data
	 * @param string $successCallback
	 * @param string $errorCallback
	 * @return string
	 */
	public static function delete(string $method, string $url, $data = null, ?string $successCallback = '', ?string $errorCallback = null): string {
		return self::request('delete', $url, $data, $successCallback, $errorCallback);
	}
}

