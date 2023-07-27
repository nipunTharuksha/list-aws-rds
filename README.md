# AWS RDS Viewer App

The AWS RDS Viewer App is a Laravel-based web application that allows you to view and manage RDS instances across multiple AWS regions. This app is built using Vue, TailwindCSS, and leverages the AWS SDK for PHP via the `aws/aws-sdk-php-laravel` package.

## Requirements

- PHP 7.4 or higher
- Composer
- Node.js and NPM
- AWS account with appropriate access credentials

## Tech Stack

- Laravel 9.0
- Vue 3.0
- TailwindCSS
- AWS SDK for PHP Laravel Package (`aws/aws-sdk-php-laravel`)

## Installation

1. Clone the repository to your local development environment.

2. Install PHP dependencies using Composer:

```bash
composer install
```

3. Install JavaScript dependencies using NPM:

```bash
npm install
```

4. Create a copy of the `.env.example` file and rename it to `.env`. Update the following AWS environment variables with your own AWS credentials:

```dotenv
AWS_ACCESS_KEY_ID=your_aws_access_key_id
AWS_SECRET_ACCESS_KEY=your_aws_secret_access_key
AWS_REGION=your_aws_region
```

## Usage

To start the local development server, run the following command:

```bash
php artisan serve
```

Access the app in your web browser at `http://localhost:8000`.

## Demo

Watch the app in action by clicking on the link below:

[View Demo](https://drive.google.com/file/d/1Wj6r7NoGhk-fojVgnQKZ0uyP_PxWVdct/view?usp=sharing)

## Features

- View all RDS instances across multiple regions with pagination
- Filter instances by region
- Start / Stop instances
- View logs of a particular instance with pagination
- Refresh instance lists

## Service Integration

All actions related to the RDS client are available at `app/services/RDSService.php`. This service handles interactions with the AWS SDK for PHP Laravel package to manage RDS instances.

---
