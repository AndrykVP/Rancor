<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Inactivity
	|--------------------------------------------------------------------------
	|
	| Here you may specify how many MONTHS until a specific resource is considered
	| inactive. This is necessary for cronjobs that cleanup relationships or logs
	| that are no longer relevant, to decrease the number of rows in database
	|
	*/

	'inactivity' => [

		'users' => 3,

		// This is used to cleanup the 'forum_unread_discussions' table
		'forums' => 3,
		
	],


	/*
	|--------------------------------------------------------------------------
	| Auth Middleware
	|--------------------------------------------------------------------------
	|
	| Here you may specify an array of middlewares to use for route authentication
	| for both web and api routes. If you use custom middlewares, they can be added
	| or replaced here.
	|
	*/

	'middleware' => [

		// If you request users to verify email, uncomment 'verified'.
		// To restrict user-side pages from banned Users, uncomment 'unbanned'.
		// If you use a custom middleware, use it here like you use it in any other route.

		'web' => [
			'auth',
			// 'verified',
			// 'unbanned',
		],


		// For User models that use an api_token column, use 'auth:api'
		// For Laravel/Sanctum, use 'auth:sanctum'. Otherwise if you use
		// a custom middleware, use its alias here

		'api' => [
			'auth:api'
		],
	],


	/*
	|--------------------------------------------------------------------------
	| Audit User Log Colors
	|--------------------------------------------------------------------------
	|
	| Here you may specify the colors you want to use for the Rank Change
	| user logs. This is particularly useful with CSS Frameworks like
	| Bootstrap, Bulma and Tailwind that use color names in their syntax
	| or simply use hexadecimal codes and modify the views accordingly.
	|
	*/

	'audit' => [
		'info' => 'blue',
		'warning' => 'yellow',
		'alert' => 'red',
	],


	/*
	|--------------------------------------------------------------------------
	| Pagination
	|--------------------------------------------------------------------------
	|
	| Specify how many resources to display per page in the index Views.
	| This pagination is used in all views that require pagination, for example
	| the Admin panel, as well as the forum Discussions
	|
	*/

	'pagination' => 10,


	/*
	|--------------------------------------------------------------------------
	| Scanner
	|--------------------------------------------------------------------------
	|
	| Configuration used in the scanner module
	|
	*/

	'scanner' => [

		// The id of the quadrant containing the home system of your
		// faction. You can find this in the database, or you can contact
		// the dev team of the Rancor package for help
		'index' => 24
	],


	/*
	|--------------------------------------------------------------------------
	| Discord
	|--------------------------------------------------------------------------
	|
	| Configuration for communication to Discord servers related to your faction.
	| It is recommended to use Webhooks rather than Bots, since bots need to be
	| self-hosted while webhooks are http requests to specific channels. However,
	| if you require more functionality than a webhook, or you have a functional bot
	| in your server, you may define your bot's key here.
	|
	*/

	'discord' => [

		// Webhook to a specific channel to remind patrol groups
		// of territories that have not been scanned in a long time
		'patrol' => env('RANCOR_DISCORD_PATROL', NULL),
		
		// Webhook to a specific channel for admin related notifications
		'admin' => env('RANCOR_DISCORD_ADMIN', NULL),
	]
];
