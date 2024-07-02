<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'slug' => 'laravel',
                'name' => 'Laravel',
                'description' => 'Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in most web projects.',
            ],
            [
                'slug' => 'graphql',
                'name' => 'GraphQL',
                'description' => 'GraphQL is a query language for APIs and a runtime for executing those queries by using a type system you define for your data. It was developed by Facebook in 2012 and released as an open-source project in 2015.',
            ],
            [
                'slug' => 'vuejs',
                'name' => 'Vue.js',
                'description' => 'Vue.js is a progressive framework for building user interfaces. Unlike other monolithic frameworks, Vue is designed from the ground up to be incrementally adoptable. The core library is focused on the view layer only, and is easy to pick up and integrate with other libraries or existing projects.',
            ],
            [
                'slug' => 'nextjs',
                'name' => 'Next.js',
                'description' => 'Next.js is an open-source React front-end development web framework that enables functionality such as server-side rendering and generating static websites for React based web applications.',
            ],
            [
                'slug' => 'reactjs',
                'name' => 'React.js',
                'description' => 'React is a JavaScript library for building user interfaces. Learn what React is all about on our homepage or in the tutorial.',
            ],
            [
                'slug' => 'tailwindcss',
                'name' => 'Tailwind CSS',
                'description' => 'Tailwind CSS is a highly customizable, low-level CSS framework that gives you all of the building blocks you need to build bespoke designs without any annoying opinionated styles you have to fight to override.',
            ],
            [
                'slug' => 'alpinejs',
                'name' => 'Alpine.js',
                'description' => 'Alpine.js offers you the reactive and declarative nature of big frameworks like Vue or React at a much lower cost. You get to keep your DOM, and sprinkle in behavior as you see fit.',
            ],
            [
                'slug' => 'inertiajs',
                'name' => 'Inertia.js',
                'description' => 'Inertia.js lets you quickly build modern single-page React, Vue and Svelte apps using classic server-side routing and controllers.',
            ],
            [
                'slug' => 'jetstream',
                'name' => 'Jetstream',
                'description' => 'Jetstream is a beautifully designed application scaffolding for Laravel. Jetstream provides the perfect starting point for your next Laravel application and includes login, registration, email verification, two-factor authentication, session management, API support via Laravel Sanctum, and optional team management.',
            ],
            [
                'slug' => 'livewire',
                'name' => 'Livewire',
                'description' => 'Livewire is a full-stack framework for Laravel that makes building dynamic interfaces simple, without leaving the comfort of Laravel.',
            ],
            [
                'slug' => 'fortify',
                'name' => 'Fortify',
                'description' => 'Laravel Fortify is a frontend agnostic authentication backend for Laravel. Fortify powers the registration, authentication, and two-factor authentication features of Laravel Jetstream.',
            ],
            [
                'slug' => 'sanctum',
                'name' => 'Sanctum',
                'description' => 'Laravel Sanctum provides a featherweight authentication system for SPAs (single page applications), mobile applications, and simple, token-based APIs.',
            ],
            [
                'slug' => 'passport',
                'name' => 'Passport',
                'description' => 'Laravel Passport is an OAuth2 server and API authentication package that is simple and enjoyable to use.',
            ],
        ];


        /*
            if there is already a topic with the same slug, it will not be inserted into the database
            it will be updated instead
         */
        Topic::upsert($data, ['slug']);
    }
}
