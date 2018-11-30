<?php

require_once '../vendor/autoload.php';

// $faker = Faker\Factory::create('it_IT');

// echo $faker->name();

// echo $faker->address();

// echo $faker->paragraph(4);


// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

// create an image manager instance with favored driver
$manager = new ImageManager(array('driver' => 'gd'));

// to finally create image instances
$image = $manager->make('/img/download.jpeg')->resize(300, 200)->save('wolf.jpeg');


// $arr = ['2', '3', 'test', 'lastname'=>'Arias'];

// var_dump($arr);
