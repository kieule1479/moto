<?php
class Session
{

	//===== INIT ======
	public static function init()
	{
		session_start();
	}

	//===== SET ======
	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	//===== GET ======
	public static function get($key)
	{
		if (isset($_SESSION[$key])) return $_SESSION[$key];
	}

	//===== DELETE ======
	public static function delete($key, $id = null)
	{
		if ($id != null) {
			if (isset($_SESSION[$key]['quantity'][$id])) unset($_SESSION[$key]['quantity'][$id]);
			if (isset($_SESSION[$key]['price'][$id])) unset($_SESSION[$key]['price'][$id]);
		} else {
			if (isset($_SESSION[$key])) unset($_SESSION[$key]);
		}
	}

	//===== DESTROY ======
	public static function destroy()
	{
		session_destroy();
	}
}
