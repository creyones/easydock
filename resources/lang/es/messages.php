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

	'remember-me' => 'Recuérdame',
	'forgot-password' => '¿Olvidaste Contraseña?',
	'price-per-day' => '€/día',
	'yes' => 'Si',
	'no' => 'No',
	'true' => 'Verdadero',
	'false' => 'Falso',
	'confirmed' => 'Confirmado',
	'canceled' => 'Cancelado',
	'users' => [
		'created' => 'El usuario ha sido creado correctamente.',
		'updated' => 'El usuario ha sido actualizado correctamente.',
		'deleted' => 'El usuario ha sido borrado correctamente.',
		'not-found' => 'El usuario no ha sido encontrado.',
		'not-available' => 'Este usuario no está disponible.',
		'not-modified' => 'Este usuario no ha sido modificado.',
		'confirm-delete' => '¿Está seguro de que quiere borrar este usuario? Toda la información relacionada con el usuario se perderá. Las reservas relacionadas se eliminarán.',
	],
	'providers' => [
		'created' => 'El cliente ha sido creado correctamente.',
		'updated' => 'El cliente ha sido actualizado correctamente.',
		'deleted' => 'El cliente ha sido borrado correctamente.',
		'not-found' => 'El cliente no ha sido encontrado.',
		'not-available' => 'Este cliente no está disponible.',
		'not-modified' => 'Este cliente no ha sido modificado.',
		'confirm-delete' => '¿Está seguro de que quiere borrar este cliente? Toda la información relacionada con el cliente se perderá. Los atraques y reservas relacionados se eliminarán.',
		'no-docks' => 'No hay ningun atraque relacionado con este cliente',
	],
	'ports' => [
		'created' => 'El puerto ha sido creado correctamente.',
		'updated' => 'El puerto ha sido actualizado correctamente.',
		'deleted' => 'El puerto ha sido borrado correctamente.',
		'not-found' => 'El puerto no ha sido encontrado.',
		'not-available' => 'Este puerto no está disponible.',
		'not-modified' => 'Este puerto no ha sido modificado.',
		'confirm-delete' => '¿Está seguro de que quiere borrar este puerto? Toda la información relacionada con el puerto se perderá. Las reservas y atraques relacionados se eliminarán.',
		'no-docks' => 'No hay ningun atraque relacionado con este puerto',
	],
	'docks' => [
		'created' => 'El atraque ha sido creado correctamente.',
		'updated' => 'El atraque ha sido actualizado correctamente.',
		'deleted' => 'El atraque ha sido borrado correctamente.',
		'not-found' => 'El atraque no ha sido encontrado.',
		'not-available' => 'Este atraque no está disponible.',
		'not-modified' => 'Este atraque no ha sido modificado.',
		'confirm-delete' => '¿Está seguro de que quiere borrar este atraque? Toda la información relacionada con el atraque se perderá. Las reservas y productos relacionados se eliminarán.',
		'default-services' => 'Los servicios del atraque se fijarán con los que tenga el puerto. Si quiere cambiarlos, edite el atraque una vez creado.',
		'no-products' => 'No hay ningun producto relacionado con este atraque',
		'no-bookings' => 'No hay ninguna solicitud de reserva relacionada con este atraque',
		'block' => 'Bloquear fechas',
	],
	'bookings' => [
		'created' => 'La reserva ha sido creado correctamente.',
		'updated' => 'La reserva ha sido actualizado correctamente.',
		'deleted' => 'La reserva ha sido borrado correctamente.',
		'not-found' => 'La reserva no ha sido encontrada.',
		'not-available' => 'La reserva no está disponible.',
		'not-modified' => 'La reserva no ha sido modificada.',
		'confirm-delete' => '¿Está seguro de que quiere borrar esta reserva? Toda la información relacionada con la reserva se perderá. Los productos relacionados se eliminarán.',
		'no-products' => 'No hay ningun producto relacionado con esta solicitud de reserva',
	],
];
