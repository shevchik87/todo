# Todo application
## Install

To run the application successfully, you need to install ``docker`` and ``docker-compose`` on your computer.

Clone this repository and go to todo's directory

``git clone https://github.com/shevchik87/todo && cd todo``

Run docker-compose

``docker-compose up``

Run migration

``docker-compose exec app php bin/console doctrine:migrations:migrate --no-interaction ``

Load fixtures

`` docker-compose exec app php bin/console doctrine:fixtures:load --no-interaction``

That's all, your application is ready on address ``http://127.0.0.1:8080/``

## Usage

For each request  you need an Authorization's header with value ``Bearer token1``

## Available endpoints

``POST  /api/v1/tasks`` - create new task
Required parameters

``content`` - is title of task

``due_date`` - deadline, should be  greater or equal current date

Body example
```json
{
  "content":"New test task",
  "due_date": "2020-12-31"
}
```

``PATCH /api/v1/tasks/{id}/complete`` - mark task as completed


``GET /api/v1/tasks`` - get all active tasks

``GET /api/v1/tasks/{id}`` - get specific task

``{id}`` - task id







