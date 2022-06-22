# Simple URL shortner
This is a simple URL shortner.

### First steps
This application has some requirements:

- PHP > 7.4.*
- MySQL

Install application dependencies.
```bash
$ composer install # to install application dependencies
```

Create a database and add your credentials to the `.env` file.
> 💡You can use `.env.example` as an example

```bash
$ php artisan migrate # to create application tables
```

### Endpoints
#### POST `/api/url`
Creates a new short URL in the database and locates user to informed URL.
This endpoint acepts two params:

- Url: The URL to short;
- Shorname: Optional. The short URL;

```json
{
    "url": "https://example.com/long/url/to-short",
    "shortname": "short"
}
```

This URL now is accessable at `http://your-aplication.com/short`.


#### GET `/<short_slug>`
Seaches `short_slug` in the database, registers activity and locates user to the long URL.

#### GET `/api/url/top`
Displays top 100 used URL lists.

```json
[
    {
        "id": 2,
        "title": "URL Title",
        "url": "https://example.com/long/url/to-short",
        "count": 2000
    },
    {
        "id": 1,
        "title": "Another url title",
        "url": "https://example.com/long/url",
        "count": 1546
    },
    // ...
]
```
