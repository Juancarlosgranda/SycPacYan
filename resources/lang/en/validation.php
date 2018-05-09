<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "The :attribute must be accepted.",
	"active_url"           => "The :attribute is not a valid URL.",
	"after"                => "The :attribute must be a date after :date.",
	"alpha"                => "The :attribute may only contain letters.",
	"alpha_dash"           => "The :attribute may only contain letters, numbers, and dashes.",
	"alpha_num"            => "The :attribute may only contain letters and numbers.",
	"array"                => "The :attribute must be an array.",
	"before"               => "The :attribute must be a date before :date.",
	"between"              => [
		"numeric" => "The :attribute must be between :min and :max.",
		"file"    => "The :attribute must be between :min and :max kilobytes.",
		"string"  => "The :attribute must be between :min and :max characters.",
		"array"   => "The :attribute must have between :min and :max items.",
	],
	"boolean"              => "The :attribute field must be true or false.",
	"confirmed"            => "The :attribute confirmation does not match.",
	"date"                 => "The :attribute is not a valid date.",
	"date_format"          => "The :attribute does not match the format :format.",
	"different"            => "The :attribute and :other must be different.",
	"digits"               => "The :attribute must be :digits digits.",
	"digits_between"       => "The :attribute must be between :min and :max digits.",
	"email"                => "El campo :attribute no es un correo electrónico.",
	"filled"               => "The :attribute field is required.",
	"exists"               => "The selected :attribute is invalid.",
	"image"                => "The :attribute must be an image.",
	"in"                   => "The selected :attribute is invalid.",
	"integer"              => "The :attribute must be an integer.",
	"ip"                   => "The :attribute must be a valid IP address.",
	"max"                  => [
		"numeric" => "The :attribute may not be greater than :max.",
		"file"    => "The :attribute may not be greater than :max kilobytes.",
		"string"  => "The :attribute may not be greater than :max characters.",
		"array"   => "The :attribute may not have more than :max items.",
	],
	"mimes"                => "The :attribute must be a file of type: :values.",
	"min"                  => [
		"numeric" => "The :attribute must be at least :min.",
		"file"    => "The :attribute must be at least :min kilobytes.",
		"string"  => "The :attribute must be at least :min characters.",
		"array"   => "The :attribute must have at least :min items.",
	],
	"not_in"               => "The selected :attribute is invalid.",
	"numeric"              => "The :attribute must be a number.",
	"regex"                => "The :attribute format is invalid.",
	"required"             => "El campo :attribute esta vacío, debe ingresar un valor.",
	"required_if"          => "The :attribute field is required when :other is :value.",
	"required_with"        => "The :attribute field is required when :values is present.",
	"required_with_all"    => "The :attribute field is required when :values is present.",
	"required_without"     => "The :attribute field is required when :values is not present.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => "The :attribute and :other must match.",
	"size"                 => [
		"numeric" => "The :attribute must be :size.",
		"file"    => "The :attribute must be :size kilobytes.",
		"string"  => "The :attribute must be :size characters.",
		"array"   => "The :attribute must contain :size items.",
	],
	"unique"               => "El campo :attribute ya existe.",
	"url"                  => "The :attribute format is invalid.",
	"timezone"             => "The :attribute must be a valid zone.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [
		'alm_desc'=>'DESCRIPCIÓN',
		'fam_desc'=>'DESCRIPCIÓN',
		'cat_desc'=>'DESCRIPCIÓN',
		'um_desc'=>'DESCRIPCIÓN',
		'um_abrev'=>'ABREVIATURA',
		'conv_fact'=>'FACTOR DE CONVERSIÓN',
		'um_id1'=>'UNIDAD DE MEDIDA 1',
		'um_id2'=>'UNIDAD DE MEDIDA 2',
		'prod_id'=>'PRODUCTO',
		'prod_cod'=>'CÓDIGO',
		'prod_desc'=>'DESCRIPCIÓN',
		'prod_obs'=>'OBSERVACIONES',
		'cat_id'=>'CATEGORÍA',
		'um_id'=>'UNIDAD DE MEDIDA',		
		'ent_id'=>'ENTIDAD (CLIENTE Ó PROVEEDOR)',
		'ent_ruc'=>'RUC Ó DNI',
		'ent_rz'=>'RAZÓN SOCIAL',
		'ent_dir'=>'DIRECCIÓN',
		'ent_ciu'=>'CIUDAD',
		'ent_tel'=>'TELEFONO',
		'ent_correo' => 'CORREO',
		'vend_dni'=>'DNI',
		'vend_nom'=>'NOMBRE',
		'vend_tel'=>'TELEFONO',
		'vend_ciu'=>'CIUDAD',
		'vend_dpto'=>'DEPARTAMENTO',
		'vend_id'=>'VENDEDOR',
		'comp_id'=>'COPROBANTE',
		'comp_nro'=>'NRO. COMPROBANTE',
		'comp_fecha'=>'FECHA',
		'comp_guia'=>'GUÍA',
		'ocv_nro'=>'NRO. NOTA DE PEDIDO',
		'ocv_fecha'=>'FECHA',
		'ie_comp'=>'NRO. COMPROBANTE',
		'ie_ruc'=>'RUC',
		'ie_rz'=>'RAZÓN SOCIAL',
		'ie_fecha'=>'FECHA',
		'ie_tipcambio'=>'TIPO DE CAMBIO',
		'dcomp_cant'=>'CANTIDAD',
		'dcomp_prec'=>'PRECIO'

	],
];
