
## Event-Driven Notification System


Develop a simplified event-driven notification service. This service should receive various user events (e.g., user signup, subscription renewal, or payment failure) and send notifications to users based on these events.

### Prerequisites
- PHP 8.x
- Composer
- Laravel 10
- MySQL
- Gmail

### Setup Guide

#### 1. Clone the repository
```bash
git clone <repository-url>
cd event-driven-notification

# composer install
# php artisan migrate --seed
# php artisan queue:work

# Project Structure Overview

## 1. Route Definition
- **File:** `routes/web.php`
  - Defines the route for handling user events.
  - Example Route: 
    ```php
    Route::post("/user-event", [\App\Http\Controllers\Api\EventController::class, 'handleUserEvent']);
    ```

## 2. Event Handling
- **Controller:** `App\Http\Controllers\Api\EventController`
  - **Method:** `handleUserEvent()` 
    - Triggers the `UserEvent`.

- **Event:** `App\Events\UserEvent`
  - Defines the structure and data of the event.

- **Listener:** `App\Listeners\UserListener`
  - Listens for `UserEvent` and prepares and sends notifications.

- **Notification:** `App\Notifications\UserNotified`
  - Formats and sends the notification.

## 3. Request Validation
- **Request Class:** `App\Http\Requests\UserEventRequest`
  - Validates incoming event data.

## 4. Enums
- **Enum Class:** `App\Enums\EventType`
  - Defines different types of events:
    - `SIGNUP`
    - `RENEWAL`
    - `PAYMENT_FAILURE`

## 5. Notification Structure
- **Notification Class:** `App\Notifications\UserNotified`
  - Formats the email content based on event type.

## 6. User Database Seeding
- **Seeder:** `Database\Seeders\UserSeeder`
  - Creates dummy users for testing.

# Code Flow Explanation

## 1. Route Definition
In `routes/web.php`, you define the POST route `/user-event`, which maps to the `handleUserEvent` method in `EventController`. This is where incoming event data is processed.

## 2. Event Handling - EventController
- The `EventController`'s `handleUserEvent()` method receives the POST request.
- It accepts a `UserEventRequest` instance for validating the request data (`eventType`, `userId`, and `metaData`).
- If valid, it dispatches a new `UserEvent` with the required data (`userId`, `eventType`, `metaData`).
- It then returns a JSON response indicating that the event was created successfully.

## 3. Request Validation - UserEventRequest
- The `UserEventRequest` class handles validation, ensuring that:
  - `eventType` is required and a string,
  - `userId` is an integer,
  - `metaData` is an array.
- If validation fails, Laravel automatically returns a 422 response with error details.

## 4. Event - UserEvent
- `UserEvent` is triggered with three pieces of information: `userId`, `eventType`, and `metaData`.
- This event is passed to the listener `UserListener`, which handles the notification based on the event type.

## 5. Listener - UserListener
- `UserListener` listens for `UserEvent`.
- When `UserEvent` is received, the `handle()` method retrieves the User by `userId`.
- It checks if the user exists and calls `getMessage()` to get the appropriate message based on `eventType`.
- The `getMessage()` method returns different messages depending on whether `eventType` is `SIGNUP`, `RENEWAL`, or `PAYMENT_FAILURE`.
- Finally, the listener triggers the `UserNotified` notification with the prepared message and `metaData`.

## 6. Notification - UserNotified
- `UserNotified` formats the notification.
- In the `toMail()` method, it creates a `MailMessage` instance with a subject and body content, personalized based on the `metaData` (e.g., name).
- This notification is sent via the specified mail configuration when the queue is processed.

## 7. Queue Processing - `php artisan queue:work`
- The command `php artisan queue:work` processes queued jobs, including sending notifications.
- Since `UserListener` implements `ShouldQueue`, it will run in the background and use Laravel’s queue system to process the email.

## 8. Enums - EventType
- `EventType` is an enum that defines various event types (`SIGNUP`, `RENEWAL`, `PAYMENT_FAILURE`), ensuring consistent and maintainable use of event types throughout the codebase.

## 9. Database Seeder - UserSeeder
- `UserSeeder` generates dummy users with randomized names and email addresses to help test the notification flow.
- After seeding, you can use `userId` values to test different notifications.

# Example Code Flow in Action (Based on the Postman Request)

## Postman Request
- A POST request is sent to `/user-event` with the following data:
  - `eventType`: `"signup"`
  - `userId`: `1`
  - `metaData`: 
    ```json
    {
      "name": "Lovers Jain"
    }
    ```

## Controller Processing
- The `EventController` receives the request.
- It validates the request via `UserEventRequest`.
- If validation passes, it dispatches a `UserEvent` with the specified data (`userId`, `eventType`, `metaData`).

## Event Handling in Listener
- `UserListener` picks up the `UserEvent`.
- It retrieves the User with `id` 1 from the database.
- Based on the `SIGNUP` event type, it constructs a welcome message (e.g., "Welcome to our service, Lovers Jain!").
- It then sends a `UserNotified` notification, passing the constructed message and `metaData`.

## Notification Email
- `UserNotified` formats the email with the constructed message and `metaData`.
- The email is then sent through the mail system.

## Queue Processing
- The notification is queued and will be sent once the command `php artisan queue:work` is running.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
