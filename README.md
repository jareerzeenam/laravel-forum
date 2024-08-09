# Laravel Forum

![Laravel Forum](https://github.com/jareerzeenam/laravel-forum/blob/main/public/assets/featured.png)

---
This is a Laravel [Jetstream](https://laravel.com/docs/11.x/starter-kits#laravel-jetstream) project built
with [Vue 3](https://vuejs.org/guide/extras/composition-api-faq.html) (
Composition API) and [Inertia.js](https://inertiajs.com/). The application follows Test
Driven Development (TDD) principles using [Pest PHP](https://pestphp.com/).

## Features

**User Authentication:** Provided by Laravel Jetstream with Inertia.js and Vue 3.

**CRUD Operations for Posts:**

- Create, Read, Update, and Delete posts.
- Advanced filtering and pagination.
- Search posts by title and content.
- Filter posts by category.

**Post Interactions:**

- Like/Dislike posts.
- Add comments to posts.
- Like/Dislike comments.
- Disable editing of comments after 1 hour using Laravel Policies.

**Advanced Search:**

- Integrated with [Laravel Scout](https://laravel.com/docs/11.x/scout) and [Algolia](https://algolia.com/) for advanced
  search functionality.

**Rich Text Editor:**

- Implemented with the [Tiptap](https://tiptap.dev/docs/editor/getting-started/overview) headless editor to provide a
  robust WYSIWYG editor for creating and editing posts.

**Performance Optimization:**

- Optimized database queries to avoid extra calls and load only necessary relationships.
- Leveraged lazy loading and selected specific fields to prevent data overload.

**Authorization:**

- Used [Laravel Policies](https://laravel.com/docs/11.x/authorization#creating-policies) to handle various
  authorizations throughout the application.

## Installation

Follow these steps to get the project up and running on your local machine.

1. **Clone the repository:**
   ```bash
   git clone https://github.com/jareerzeenam/laravel-forum.git
   cd laravel-forum
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Set up the environment:**
    - Copy the `.env.example` file to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Update the `.env` file with your database credentials and other settings.

4. **Generate the application key:**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations:**
   ```bash
   php artisan migrate
   ```

6. **Seed the database:**
   ```bash 
    php artisan db:seed
    ```

7. **Install and configure [Algolia](https://algolia.com/) (for search):**
    - Register for an Algolia account and get your API keys.
    - Add your Algolia credentials to the `.env` file:
      ```plaintext
      ALGOLIA_APP_ID=your-app-id
      ALGOLIA_SECRET=your-algolia-secret
      ```

8. **Run the Laravel queue worker:**
    - Laravel uses queues to handle background tasks. Ensure the queue worker is running to push updates to Algolia when
      a post is created, deleted, or edited:
      ```bash
      php artisan queue:work
      ```
    - You can also use a process manager like Supervisor to keep the queue worker running continuously in production.

9. **Run the development server:**
   ```bash
   php artisan serve
   npm run dev
   ```

## Testing

This project uses Pest PHP for testing. To run the test suite, use the following command:

```bash
php artisan test
```

## Usage

- Access the application via the development server.
- Register or log in to start using the application.
- You can create, edit, and manage posts, as well as interact with other users' posts through likes and comments.
- Ensure the Laravel queue worker is running to sync your posts with Algolia for search indexing.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any changes or enhancements.

## License

This project is open-source and available under the [MIT license](LICENSE).

---
