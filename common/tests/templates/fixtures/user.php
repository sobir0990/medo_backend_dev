<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
	$index,
	$faker->userName,
	$faker->phoneNumber,
	$faker->email,
	Yii::$app->security->generatePasswordHash('password_'.$i),
	'10',
	time()+$i,
	time()+$i,
];