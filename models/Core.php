<?php
/**
 * Copyright (c) 2016 B. Lutz
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */


class Core {
	
	/**
	 * Autoloading PHP classes
	 */
	public static function autoload($name)
	{
		require "models/" . $name . ".php";
	}
	
	
	/**
	 * File by route
	 */
	public static function fileForBaseRouteInDirectory($dir) {
		$file_name = "default";
		$base_route = Request::route(0);
		
		if ($base_route == false)
			$base_route = "home";

		if ($base_route && preg_match("/^[\w\-]+$/", $base_route) && file_exists("{$dir}/{$base_route}.php"))
			$file_name = $base_route;
		
		return $file_name;
	}
	
	
	/**
	 * Controller
	 */
	public static function controller() {
		$controller = self::fileForBaseRouteInDirectory("controllers");
		
		require "controllers/{$controller}.php";
		exit();
	}
	
	
	/**
	 * View
	 */
	public static function view($name, $data=array(), $inView="master") {
		foreach ($data as $viewKey => $viewValue) {
			$$viewKey = $viewValue;
		}
		
		if ($inView) {
			$subView = $name;
			$name = $inView;
		}
		
		require "views/{$name}.php";
	}
}
?>