<?php

use Faker\Generator as Faker;

$factory->define(Modules\News\Models\News::class, function (Faker $faker) {
    $title = $faker->sentence(rand(3, 10));
    $content = $faker->paragraphs(rand(1,4), true);
    return [
        'title' => ['ru' => $title, 'en' => $title],
        'content' => ['ru' => $content, 'en' => $content]
    ];
});
