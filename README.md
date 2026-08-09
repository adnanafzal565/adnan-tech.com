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

## Email Template API

Building transactional emails can be tedious. You have to design the HTML, create a plain-text version, add variables, test the template, and repeat the process for every type of email.

This API makes that easier by providing ready-to-use email templates that you can render directly from your application.

### Features

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

### How It Works

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

## Contributing

This repository is primarily maintained by Adnan Afzal. At this stage, external contributions are not being accepted.

## License

Copyright © Adnan Tech.

All rights reserved.

The source code in this repository may not be copied, redistributed, or used commercially without prior written permission.