<?php


use App\Support\PostFixtures;

Route::middleware('api')->group(function (){
    Route::get('post-content', function(){
        return PostFixtures::getFixture()->random();
    });
});

Route::middleware('web')->group(function (){});
