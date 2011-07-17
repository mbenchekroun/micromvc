<?php
/**
 * Controller
 *
 * Basic outline for standard system controllers.
 *
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2011 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
namespace Core;

Abstract class Controller
{
	// Global view template
	public $template = 'Layout';

	// URL path segment matched to route here
	public $route = NULL;

	/**
	 * Set error handling and start session
	 */
	public function __construct($route = NULL)
	{
		$this->route = $route;

		Session::start();

		if(config('debug_mode'))
		{
			// When debugging, enable complex error handling
			set_error_handler(array('\Core\Error', 'handler'));
			register_shutdown_function(array('\Core\Error', 'fatal'));
			set_exception_handler(array('\Core\Error', 'exception'));
		}
	}


	/**
	 * Load database connection
	 */
	public function load_database($name = 'database')
	{
		// Load database
		$db = new DB(config($name));

		// Set default ORM database connection
		if(empty(ORM::$db))
		{
			ORM::$db = $db;
		}

		return $db;
	}


	/**
	 * Show a 404 error page
	 */
	public function show_404()
	{
		headers_sent() OR header('HTTP/1.0 404 Page Not Found');
		$this->content = new View('404');
	}


	/**
	 * Save user session before rendering the final layout template
	 */
	public function render()
	{
		Session::save();

		headers_sent() OR header('Content-Type: text/html; charset = utf-8');

		$layout = new View($this->template);
		$layout->set((array) $this);
		print $layout;

		$layout = NULL;

		if(config('debug_mode'))
		{
			print new View('Debug', 'Core');
		}
	}

}

// End