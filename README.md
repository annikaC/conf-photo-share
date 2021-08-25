# Conference Photo Share

The company conference is coming soon, virtual or IRL. Most years we share photos over WhatsApp, and it's a nightmare. Surely there's a better way?

Inside the `/stacks` there are CloudFormation templates which will setup this entire project in AWS. It will also setup CodePipeline and CodeBuild for CI/CD pipelines and automatic deployments.

This project is a simple photo upload page. You click upload in the top right, and it will appear on the main page. There is also a custom built Q&A section where people can post questions anonymously and also anonymously vote on questions to make them higher on the question board.

This project requires Pusher credentials for the best experience.
## Pre-requisites
- Composer
- Docker
- Yarn

## How to run

- `cp .env.example .env` (then get credentials from Jack)
- `composer install`
- `sail up` to start Docker containers
- `yarn watch` to build frontend