<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Messages Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used by the paginator library to build
	| the simple pagination links. You are free to change them to anything
	| you want to customize your views to better match your application.
	|
	*/

	'remember-me' => 'Remember Me',
	'forgot-password' => 'Forgot Your Password?',
	'price-per-day' => '€/day',
	'yes' => 'Yes',
	'no' => 'No',
	'true' => 'True',
	'false' => 'False',
	'confirmed' => 'Confirmed',
	'canceled' => 'Canceled',
	'access-forbidden' => 'You do not have access to this resource. Please, proceed to home page.',
	'users' => [
		'created' => 'The user has been succesfully created.',
		'updated' => 'The user has been succesfully updated.',
		'deleted' => 'The user has been succesfully deleted.',
		'not-found' => 'The user has not been found.',
		'not-available' => 'This user is not available.',
		'not-modified' => 'This user has not been modified.',
		'confirm-delete' => 'Are you sure you want to delete this user? All the information related to the user may be lost. Related bookings will be lost.',
	],
	'providers' => [
		'created' => 'The provider has been succesfully created.',
		'updated' => 'The provider has been succesfully updated.',
		'deleted' => 'The provider has been succesfully deleted.',
		'not-found' => 'The provider has not been found.',
		'not-available' => 'This provider is not available.',
		'not-modified' => 'This provider has not been modified.',
		'confirm-delete' => 'Are you sure you want to delete this provider? All the information related to the provider may be lost. Related docks and bookings will be lost.',
		'no-docks' => 'There are no docks related with this provider',
	],
	'ports' => [
		'created' => 'The port has been succesfully created.',
		'updated' => 'The port has been succesfully updated.',
		'deleted' => 'The port has been succesfully deleted.',
		'not-found' => 'The port has not been found.',
		'not-available' => 'This port is not available.',
		'not-modified' => 'This port has not been modified.',
		'confirm-delete' => 'Are you sure you want to delete this port? All the information related to the port may be lost. Related providers, docks and bookings will be lost.',
		'no-docks' => 'There are no docks related with this port',
	],
	'docks' => [
		'created' => 'The dock has been succesfully created.',
		'updated' => 'The dock has been succesfully updated.',
		'deleted' => 'The dock has been succesfully deleted.',
		'not-found' => 'The dock has not been found.',
		'not-available' => 'This dock is not available.',
		'not-modified' => 'This dock has not been modified.',
		'confirm-delete' => 'Are you sure you want to delete this dock? All the information related to the dock may be lost. Related bookings and products will be lost.',
		'default-services' => 'Services will be set with the related port services values. If you want to modify them, please edit the dock once created.',
		'no-products' => 'There are no products related with this dock',
		'no-bookings' => 'There are no bookings related with this dock',
		'block' => 'Block dates',
	],
	'bookings' => [
		'created' => 'The booking has been succesfully created.',
		'updated' => 'The booking has been succesfully updated.',
		'deleted' => 'The booking has been succesfully deleted.',
		'not-found' => 'The booking has not been found.',
		'not-available' => 'This booking is not available.',
		'not-modified' => 'This booking has not been modified.',
		'delete-booking' => 'Are you sure you want to delete this booking? All the information related to the booking may be lost. Related products will be lost.',
		'no-products' => 'There are no products related with this booking',
	],
];
