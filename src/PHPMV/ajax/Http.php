<?php
namespace PHPMV\ajax;

use PHPMV\js\JavascriptUtils;
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

	public static string $axiosPrefix = 'axios';

	private static TemplateParser $template;

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
	 * @param ?string $errorCallback
	 * @return string
	 */
	public static function request(string $method, string $url, $data = '{}', string $successCallback = '', ?string $errorCallback = null): string {
		if (\strpos($url, "'") === false && \strpos($url, '$') === false && \substr($url, 0, \strlen('this')) !== 'this') {
			$url = "'$url'";
		}
		$data = JavascriptUtils::toJSON($data);
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
	 * @param string $url
	 * @param mixed $data
	 * @param string $successCallback
	 * @param ?string $errorCallback
	 * @return string
	 */
	public static function get(string $url, $data = null, string $successCallback = '', ?string $errorCallback = null): string {
		return self::request('get', $url, $data, $successCallback, $errorCallback);
	}

	/**
	 * Send a post request.
	 *
	 * @param string $url
	 * @param mixed $data
	 * @param string $successCallback
	 * @param ?string $errorCallback
	 * @return string
	 */
	public static function post(string $url, $data = null, string $successCallback = '', ?string $errorCallback = null): string {
		return self::request('post', $url, $data, $successCallback, $errorCallback);
	}

	/**
	 * Send a patch request.
	 *
	 * @param string $url
	 * @param mixed $data
	 * @param string $successCallback
	 * @param ?string $errorCallback
	 * @return string
	 */
	public static function patch(string $url, $data = null, string $successCallback = '', ?string $errorCallback = null): string {
		return self::request('patch', $url, $data, $successCallback, $errorCallback);
	}

	/**
	 * Send a put request.
	 *
	 * @param string $url
	 * @param mixed $data
	 * @param string $successCallback
	 * @param ?string $errorCallback
	 * @return string
	 */
	public static function put(string $url, $data = null, string $successCallback = '', ?string $errorCallback = null): string {
		return self::request('put', $url, $data, $successCallback, $errorCallback);
	}

	/**
	 * Send a delete request.
	 *
	 * @param string $url
	 * @param mixed $data
	 * @param string $successCallback
	 * @param ?string $errorCallback
	 * @return string
	 */
	public static function delete(string $url, $data = null, string $successCallback = '', ?string $errorCallback = null): string {
		return self::request('delete', $url, $data, $successCallback, $errorCallback);
	}
}

