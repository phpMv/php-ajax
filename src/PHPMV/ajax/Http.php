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

	public static function request(string $method, string $url, object $data, string $successCallback, string $errorCallback): string {
		if (\strpos($url, "'") === false && \strpos($url, '$') === false && \substr($url, 0, \strlen('this')) !== 'this') {
			$url = "'$url'";
		}
		if (\is_object($data)) {
			$data = JsUtils::objectToJSON($data);
		}
		$error = "";
		if ($errorCallback != null) {
			$error = ",function(response) {" . $errorCallback . "}";
		}
		$result = self::$template->parse([
			'axios-prefix' => self::$axiosPrefix,
			'method' => $method,
			'url' => $url,
			'data' => $data,
			'successCallback' => $successCallback,
			'error' => $error
		]);
		return $result;
	}
}

