# Pipeline Pattern for API Architecture
## Overview
This sample project aims to showcase an alternative architecture for building APIs using the pipeline pattern, highlighting its simplicity and effectiveness compared to traditional MVC frameworks. The project emphasizes the removal of the View and Controller components, making the case that they are often unnecessary in API development.

## Introduction
Traditional PHP development often relies on the Model-View-Controller (MVC) pattern, which separates the concerns of data manipulation (Model), user interface (View), and application logic (Controller). However, nowadays the backend and frontend is getting further away from each other, as modern JavaScript frameworks replace backend rendering, only leaving an API behind.When building APIs, the need for a View component diminishes significantly, as APIs mainly focus on data exchange. This project proposes an alternative approach that prioritizes simplicity and streamlines the architecture by leveraging pipelines.

The pipeline pattern allows you to apply a series of operations, or filters, to incoming data before it reaches the final processing stage. Pipes act as conduits for passing data between filters, transforming and manipulating it along the way. By employing this pattern, you can achieve a more streamlined and flexible API architecture that eliminates the unnecessary overhead (both cognitive and computational) associated with traditional MVC frameworks.

## Getting Started
To get started with the project, follow these steps:

Clone the repository:

```bash
git clone https://github.com/szogyenyid/php-api-pipeline.git
```
Install the required dependencies using Composer:

```bash
composer install
```

Start an Apache webserver and access the API using your preferred HTTP client.

Project Structure
The project follows a simple structure:

```css
.
├── src/
│   ├── Filters/
│   │   ├── FilterInterface.php
│   │   └── ...
│   ├── Handlers/
│   │   ├── AbstractHandler.php
│   │   └── ...
│   ├── Payload.php
|   └── ResponseException.php
├── index.php
├── composer.json
└── README.md
```
- src/Filters: Contains the implementation of various filters used for data transformation.
- src/Handlers: Contains the request handlers responsible for processing different incoming requests.
- index.php: Entry point for the API application.
- composer.json: Project dependencies and configuration.
- README.md: This file.

## Usage
To use the pipeline pattern in your API, follow these guidelines:

1. Define the necessary filters in the src/Filters directory.
2. Configure the desired request handling process in index.php.
3. Start the server and access the API endpoints.

## Filtering Data
Filters in the project are responsible for transformations and data manipulation based on the request. To create a new filter, follow these steps:

1. Create a new filter class in the src/Filters directory.
2. Implement the FilterInterface interface.
3. Override the `__invoke` magic-method to define the desired data transformation logic.
4. Register the filter in the request handler.
```php
<?php
// ExampleFilter.php

namespace App\Filters;

use App\Payload;

class ExampleFilter implements FilterInterface
{
    public function __invoke(Payload $payload): Payload
    {
        // Apply the desired transformation to the response data
        // and return the modified payload object.

        return $payload;
    }
}
```
## Contributing
Contributions to this sample project are welcome! If you have any ideas, improvements, or bug fixes, please submit a pull request. Make sure to follow the existing coding style and provide relevant tests.

## License
This project is licensed under the MIT License.

Feel free to explore the provided sample project and experiment with the pipeline pattern as an alternative to MVC frameworks for API development. Remember to adapt the project to your specific needs and extend it as necessary. Happy coding!