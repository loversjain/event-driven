
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
# Postman - POST /user-event
- Request
{
  "eventType" : "signup",
  "userId" : 1,
  "metaData" : {
    "name" : "Lovers Jain"
  }
}
- Response
{
  "status": "Event created",
  "status_code": 200
}
## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
