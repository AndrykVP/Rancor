<?php
namespace Rancor\Audit\Enums;

enum Access: string
{
	case LOGIN = 'login';
	case REGISTRATION = 'registration';

	/**
	 * Method to create a message to render the Log in views
	 *
	 * @return string
	 */
	public function message()
	{
		return match($this)
		{
			Access::LOGIN => 'has logged in',
			Access::REGISTRATION => 'has registered a new account',
		};
	}
}