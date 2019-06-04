<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'userName' => str_random(10),
        'universityEmail' => $faker->unique()->email, 
        'password' => bcrypt('12345'),
        'gender' => 'MALE', 
        'imageLink' => '1553665841.png',
        'studyingYear' => '1', 
        'branchId' => '1',
        'status' => $faker->randomElement([
            'OPEN',
            'CLOSE',
            'DELETED'
        ])
    ];
});

// $factory->define(App\Branch::class, function (Faker\Generator $faker) {
//     return [
//         'name' => $faker->randomElement([
//             'Arts & Humanities',
//             'Engineering & Technology',
//             'Life Sciences & Medicine',
//             'Natural Sciences',
//             'Social Sciences & Management'
//         ]),
//         'status' => 'OPEN'
//     ];
// });

// $factory->define(App\Group::class, function (Faker\Generator $faker) {
//     return [
//         'parent_id' => $faker->randomElement([
//             0, 1, 2, 3, 4
//         ]),
//         'name' => $faker->randomElement([
//             'Sports',
//             'Arts',
//             'Sciences',
//             'Lifestyle',
//             'Yoga Lover',
//             'Tennis Titan',
//             'Weight Lifter',
//             'Gym Classer'
//         ]),
//         'status' => 'OPEN'
//     ];
// });

// $factory->define(App\RelUserGroup::class, function (Faker\Generator $faker) {
//     return [
//         'userId'    =>  $faker->randomElement([
//             1, 2, 3, 4
//         ]),
//         'groupId'   =>  $faker->randomElement([
//             1, 2, 3, 4, 5, 6, 7, 8, 9
//         ]),
//         'status' => 'OPEN'
//     ];
// });

function bcrypt($value, $options = []) {

    return app('hash')->make($value, $options);
}