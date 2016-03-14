<?php

return [

	/*
	|--------------------------------------------------------------------------
	| válidoation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the válidoator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "El campo :attribute debe ser aceptado.",
	"active_url"           => "El campo :attribute no es una válida URL.",
	"after"                => "El campo :attribute debe ser posterior a :date.",
	"alpha"                => "El campo :attribute solo debe contener letras.",
	"alpha_dash"           => "El campo :attribute solo debe contener letras, números, y dashes.",
	"alpha_num"            => "El campo :attribute solo debe contener letras y números.",
	"array"                => "El campo :attribute debe ser un array.",
	"before"               => "El campo :attribute debe ser anterior a :date.",
	"between"              => [
		"numeric" => "El campo :attribute debe ser entre :min y :max.",
		"file"    => "El campo :attribute debe ser entre :min y :max kilobytes.",
		"string"  => "El campo :attribute debe ser entre :min y :max characters.",
		"array"   => "El campo :attribute debe tener entre :min y :max items.",
	],
	"boolean"              => "El campo :attribute debe ser true or false.",
	"confirmed"            => "El campo :attribute no coinciden",
	"date"                 => "El campo :attribute no es una fecha válida.",
	"date_format"          => "El campo :attribute no sigue el formato :format.",
	"different"            => "El campo :attribute y :other debe ser diferent.",
	"digits"               => "El campo :attribute debe ser :digits dígitos.",
	"digits_between"       => "El campo :attribute debe ser entre :min y :max dígitos.",
	"email"                => "El campo :attribute debe ser un email válido.",
	"filled"               => "El campo :attribute es obligatorio.",
	"exists"               => "El valor de :attribute es inválido.",
	"image"                => "El campo :attribute debe ser una imagen.",
	"in"                   => "El valor de :attribute es inválido.",
	"integer"              => "El campo :attribute debe ser un entero.",
	"ip"                   => "El campo :attribute debe ser una IP válida.",
	"max"                  => [
		"numeric" => "El campo :attribute no debe ser mayor que :max.",
		"file"    => "El campo :attribute no debe ser mayor que :max kilobytes.",
		"string"  => "El campo :attribute no debe ser mayor que :max characters.",
		"array"   => "El campo :attribute no debe tener más de :max items.",
	],
	"mimes"                => "El campo :attribute debe ser un archivo de tipo: :values.",
	"min"                  => [
		"numeric" => "El campo :attribute debe ser al menos :min.",
		"file"    => "El campo :attribute debe ser al menos :min kilobytes.",
		"string"  => "El campo :attribute debe ser al menos :min characters.",
		"array"   => "El campo :attribute debe tener al menos :min items.",
	],
	"not_in"               => "El campo :attribute selecionado es inválido.",
	"numeric"              => "El campo :attribute debe ser un número.",
	"regex"                => "El campo :attribute format is inválido.",
	"required"             => "El campo :attribute es obligatorio.",
	"required_if"          => "El campo :attribute es obligatorio cuando :other es :value.",
	"required_with"        => "El campo :attribute es obligatorio cuando :values está presente.",
	"required_with_all"    => "El campo :attribute es obligatorio cuando :values está presente.",
	"required_without"     => "El campo :attribute es obligatorio cuando :values no está presente.",
	"required_without_all" => "El campo :attribute es obligatorio cuando none of :values están presente.",
	"same"                 => "El campo :attribute y :other deben coincidir.",
	"size"                 => [
		"numeric" => "El campo :attribute debe ser :size.",
		"file"    => "El campo :attribute debe ser :size kilobytes.",
		"string"  => "El campo :attribute debe ser :size caractéres.",
		"array"   => "El campo :attribute debe contener :size items.",
	],
	"unique"               => "El campo :attribute ya ha sido utilizado.",
	"url"                  => "El campo :attribute formato es inválido.",
	"timezone"             => "El campo :attribute debe ser una zona válida.",

	/*
	|--------------------------------------------------------------------------
	| Custom válidoation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom válidoation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
	  'username' => [
	    'unique' => 'El nombre de usuario ya está ocupado.',
	  ],
	  'email' => [
	    'unique' => 'La dirección de correo ya está ocupada.',
	  ],
	],


	/*
	|--------------------------------------------------------------------------
	| Custom válidoation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
