# Conference Photo Share

The company conference is coming soon, virtual or IRL. Most years we share photos over WhatsApp, and it's a nightmare.
Surely there's a better way?

Inside the `/stacks` there are CloudFormation templates which will setup this entire project in AWS. It will also setup
CodePipeline and CodeBuild for CI/CD pipelines and automatic deployments.

This project is a simple photo upload page. You click upload in the top right, and it will appear on the main page.

## Pre-requisites

- Docker
- Pusher credentials
- AWS credentials
- S3 bucket

## How to run

First we need to install composer, so we can get access to sail. This will run composer in a container, and also set up
our environment variables.

```shell
docker run --rm \
  -v $(pwd):/opt \
  -w /opt \
  laravelsail/php80-composer:latest bash \
  -c "composer install && cp .env.example .env && php artisan key:generate"
```

Now we have sail, we can use sail to run any future commands. At this point I recommend filling in any missing
environment variables (Pusher, AWS, etc) ask Jack for help with this.

Next, to get everything up and running.

- `./vendor/bin/sail up -d` to start Docker containers
- `./vendor/bin/sail artisan migrate` to run migrations
- `./vendor/bin/sail yarn install` and then `./vendor/bin/sail yarn watch` to build frontend and rebuild on any new
  changes
