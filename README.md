# Adnan Tech

Official source code for **https://adnan-tech.com**.

This repository contains the Laravel application that powers my website, where I publish software products, technical articles, developer resources, and online tools.

## About

Adnan Tech is a platform dedicated to helping developers build better applications through practical resources and ready-to-use solutions.

The website includes:

- 🛒 Premium Laravel products
- 📦 Source code packages
- 📝 Technical blog posts and tutorials
- 🛠️ Online developer tools
- 📚 Programming guides and resources
- 🚀 New projects and experiments

## Tech Stack

- Laravel
- PHP
- MySQL
- Bootstrap 5
- JavaScript
- HTML5
- CSS3
- React

## Repository Status

This project is currently under active development.

Features, architecture, and documentation will continue to evolve as the website grows.

## Website

Visit the live website:

**https://adnan-tech.com**

# Job Runner API

Run developer-defined webhooks through a simple API.

The Job Runner allows developers to register their own endpoint, receive a unique job URL, and trigger that endpoint through the API.

When a developer calls the job URL, the API:

1. Finds the registered endpoint.
2. Sends the request data to the developer's endpoint.
3. The developer's application performs the required action.

## How It Works

```text
Your Application
      |
      | POST /jobs/{job_id}/run
      | JSON data
      v
Job Runner API
      |
      | Request to registered endpoint
      | JSON/data
      v
Developer's Endpoint
      |
      | Performs action
_________________________
```

## 1. Create an Endpoint

Register your endpoint with the API.

For example, your application has:

```text
https://example.com/api/webhook
```

Register this endpoint.

The API will provide you with a URL similar to:

```text
https://adnan-tech.com/apps/job_runner/jobs/2/run
```

This is the URL your application will call whenever you want the registered endpoint to execute.

## 2. Generate a Webhook Secret

Generate a webhook secret from the API.

The API returns the secret only once:

```json
{
    "status": "success",
    "message": "Copy this secret now — it will not be shown again.",
    "secret": "whsec_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
}
```

Store this secret securely in your application.

For example:

```env
WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

The secret should never be committed to your repository.

## 3. Trigger Your Endpoint

Call the job URL provided by the API:

```bash
curl -X POST "https://adnan-tech.com/apps/job_runner/jobs/2/run" \
    -H "X-API-KEY: YOUR_API_KEY" \
    -H "Content-Type: application/json" \
    -d '{
        "name": "John Doe",
        "email": "john@example.com"
    }'
```

The request data will be forwarded to your registered endpoint.

## 4. Receive the Webhook

Your endpoint receives the data together with the webhook secret.

The secret is sent using the:

```http
X-Webhook-Secret
```

header.

Example Laravel endpoint:

```php

// routes/api.php

use Illuminate\Support\Facades\Route;

Route::post("/webhook", function () {
    $secret = request()->header('X-Webhook-Secret');

    if (empty($secret)) {
        return response()->json([
            'status' => 'error',
            'message' => 'No secret.'
        ]);
    }

    if (!hash_equals(env("WEBHOOK_SECRET"), $secret)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized.',
        ]);
    }

    return response()->json([request()->all()]);
});
```

And in `.env`:

```env
WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

## Request Data

If you trigger the job with:

```json
{
    "name": "John Doe",
    "email": "john@example.com"
}
```

your registered endpoint receives the same data.

The webhook secret is provided separately through the `X-Webhook-Secret` header.

This keeps the secret separate from the application payload.

## Security

### Keep Your API Key Secret

Your API key authenticates requests to the Job Runner API.

Never expose it in frontend JavaScript, public repositories, or client-side applications.

Store it securely:

```env
API_KEY=your_api_key
```

### Keep Your Webhook Secret Secret

Your webhook secret authenticates requests coming from the Job Runner to your endpoint.

Store it in an environment variable:

```env
WEBHOOK_SECRET=whsec_...
```

Never commit it to Git.

### Verify the Webhook Secret

Always verify the `X-Webhook-Secret` header before processing the webhook.

Use a constant-time comparison such as:

```php
hash_equals($expected_secret, $received_secret)
```

Do not process the webhook before authentication succeeds.

### Use HTTPS

Your registered endpoint should use HTTPS:

```text
https://example.com/api/webhook
```

Avoid sending webhook secrets over plain HTTP in production.

## Endpoint Responses

Your endpoint should return a normal HTTP response.

For example:

```json
{
    "status": "success",
    "message": "Webhook processed successfully."
}
```

The Job Runner API can return your endpoint's response to the application that triggered the job.

For example:

```json
{
    "status": "success",
    "message": "Webhook processed successfully."
}
```

HTTP status codes from your endpoint are also preserved.

## Failed Webhooks

If your endpoint returns an unsuccessful HTTP status code, the job execution is considered unsuccessful.

For example:

```http
HTTP/1.1 401 Unauthorized
```

or:

```http
HTTP/1.1 500 Internal Server Error
```

The API records the execution result, response, and execution duration.

## Execution History

Each job execution can be recorded with information such as:

- Request payload
- Response
- Execution status
- Execution duration
- Job
- Timestamp

This allows you to inspect previous webhook executions and troubleshoot failed requests.

## Example Use Case

Suppose you have an application that needs to trigger an action whenever a new customer registers.

You register:

```text
https://yourapp.com/api/webhooks/customer-created
```

The API gives you:

```text
https://adnan-tech.com/apps/job_runner/jobs/2/run
```

Your application then calls:

```bash
curl -X POST "https://adnan-tech.com/apps/job_runner/jobs/2/run" \
    -H "X-API-KEY: YOUR_API_KEY" \
    -H "Content-Type: application/json" \
    -d '{
        "name": "John Doe",
        "email": "john@example.com"
    }'
```

The Job Runner calls:

```text
https://yourapp.com/api/webhooks/customer-created
```

with:

```http
X-Webhook-Secret: whsec_...
```

and:

```json
{
    "name": "John Doe",
    "email": "john@example.com"
}
```

Your application verifies the secret and performs the required action.

## Why Use It?

The Job Runner separates **triggering an action** from **implementing the action**.

Your application only needs to call one API endpoint. The registered endpoint contains the actual business logic.

This makes it useful for:

- Triggering background workflows
- Connecting different applications
- Running custom automation
- Calling internal APIs
- Triggering notifications
- Executing custom business logic
- Connecting third-party services to your own application

## Summary

The basic workflow is:

```text
1. Register your endpoint
2. Receive your job URL
3. Generate your webhook secret
4. Store the secret securely
5. Call your job URL with your API key
6. Receive the request on your endpoint
7. Verify X-Webhook-Secret
8. Perform your action
9. Return your response
```

Your endpoint remains completely under your control. The Job Runner simply provides the authenticated mechanism for triggering it.

# Email Template API

Building transactional emails can be tedious. You have to design the HTML, create a plain-text version, add variables, test the template, and repeat the process for every type of email.

This API makes that easier by providing ready-to-use email templates that you can render directly from your application.

## Features

- Ready-made templates for authentication, e-commerce, SaaS, notifications, support, security, marketing, and more.
- Customize existing templates or create your own.
- Add dynamic variables to your templates.
- Automatically detect variables from your HTML.
- Get the rendered HTML through a simple API request.
- HTML and plain-text versions.
- Real-time template preview.
- API key management and usage tracking.
- Request history.
- Code examples for PHP, JavaScript, TypeScript, Python, Node.js, Java, C#, Go, and cURL.
- Rate limiting.

## How It Works

1. Create an API key.
2. Select or create a template.
3. Add your variables.
4. Send the variables to the API.
5. Get the rendered HTML back.

```javascript
const response = await fetch("YOUR_API_ENDPOINT", {
    method: "POST",
    headers: {
        "X-API-KEY": "YOUR_API_KEY",
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        variables: {
            name: "John",
            verification_code: "123456"
        }
    })
});

const html = await response.text();
```

### Contributing

This repository is primarily maintained by Adnan Afzal. At this stage, external contributions are not being accepted.

### License

Copyright © Adnan Tech.

All rights reserved.

The source code in this repository may not be copied, redistributed, or used commercially without prior written permission.