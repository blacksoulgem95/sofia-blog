---
extends: _layouts.post
section: content
title: Fighting with Angular Environments
date: 2022-12-01
description: Angular has a fantastic way of setting configurations for our application if our application has only one company as its users. But, what if we need to deploy our application, with different variables each time?
cover_image: /assets/images/angular-env/cover.jpg
featured: false
categories: [ angular, configuration, environment, environments, saas ]
---

Angular is fantastic when it comes to managing configurations—**as long as your app has only one customer, one setup,
and one deployment target.** In that scenario, life is simple: you define your `environment.ts` file, Angular swaps it
during build time, and you’re good to go.

But what if you’re building a **multi-tenant SaaS**, or deploying the same app to **different companies with slightly
different configurations** (like different API endpoints, login URLs, or feature flags)? Suddenly, your neat setup turns
into a mess of duplicated files. And let’s be honest—**no one wants to maintain 2000 environment files** just because
each client has a different backend URL.

Let’s see how we can fix this problem with a little help from **dotenv** and **Handlebars**.

---

## How Angular Environments Work

Out of the box, Angular uses the **`src/environments/environment.ts`** file to manage environment variables.

When you look at your `angular.json`, you’ll see something like this:

```json
{
  "development": {
    "buildOptimizer": false,
    "optimization": false,
    "vendorChunk": true,
    "extractLicenses": false,
    "sourceMap": true,
    "namedChunks": true,
    "fileReplacements": [
      {
        "replace": "src/environments/environment.ts",
        "with": "src/environments/environment.dev.ts"
      }
    ]
  }
}
```

What’s happening here is simple: when you build the app for `development`, Angular **replaces** the default
`environment.ts` with `environment.dev.ts`. When you build for production, it does the same with `environment.prod.ts`,
and so on.

That’s fine when you have a handful of environments. But if you’re building a **white-labeled SaaS** or an **on-premise
application**, suddenly you could end up with dozens—or even hundreds—of environment files. And no one wants that.

---

## The Problem: Too Many Files

Here’s the real pain:

* Every new client might mean another environment file.
* Changing a common variable means editing multiple files.
* Your repo quickly becomes cluttered.

We need a **dynamic way** to generate environment files at build time, instead of manually creating them all.

---

## Step 1: Install the Tools

We’ll use two (dev) dependencies:

```bash
npm i --save-dev dotenv handlebars
```

* **dotenv** lets us load variables from a `.env` file into `process.env`.
* **Handlebars** is a templating engine that makes it easy to generate files with placeholders.

---

## Step 2: Create a Configuration Template

Inside `src/environments`, create a file called `environment.hbs`:

```javascript
export const environment = {
    production: {
{
    PRODUCTION
}
},
apiURL: '{{BACKEND_URL}}',
    authURL
:
'{{AUTH_URL}}'
}
```

This is just like a normal Angular environment file, but with **placeholders** (`{{PRODUCTION}}`, `{{BACKEND_URL}}`,
etc.) instead of hardcoded values.

You can add as many keys as you need—feature flags, service URLs, tenant IDs—whatever your project requires.

---

## Step 3: Parse the Template

Now the fun part: let’s generate our actual `environment.ts` from this template.

In your project root, create a file called `env-config.js`:

```javascript
require('dotenv')
const path = require('path')
const fs = require('fs')
const hbs = require('handlebars')

const envPath = path.join(__dirname, 'src', 'environments')
const templateFilePath = path.join(envPath, 'environment.hbs')
const environmentFilePath = path.join(envPath, 'environment.ts')

const template = hbs.compile(
    fs.readFileSync(templateFilePath, {encoding: 'utf-8'})
)

const data = {
    PRODUCTION: process.env.PRODUCTION || false,
    BACKEND_URL: process.env.BACKEND_URL || 'http://localhost:3000',
    AUTH_URL: process.env.AUTH_URL || 'http://localhost:3000/auth'
}

fs.writeFileSync(environmentFilePath, template(data), {encoding: 'utf-8'})
```

**What’s happening here?**

1. `dotenv` loads values from your `.env` file into `process.env`.
2. We load our `environment.hbs` template and compile it with Handlebars.
3. We define the data we want to inject (reading from `process.env`, with fallbacks).
4. We run the template with the data, then save the result as `src/environments/environment.ts`.

The end result: **one generated environment file, customized for your build.**

---

## Step 4: Run It During Builds

We now need to make sure the script runs before each build or serve.

Update your `package.json` like this:

```json
{
  "scripts": {
    "ng": "ng",
    "config": "node env-config.js",
    "start": "npm run config && ng serve --configuration=local",
    "build": "npm run config && ng build --configuration=production --output-hashing=all",
    "build-dev": "npm run config && ng build --configuration=development --output-hashing=all",
    "build-local": "npm run config && ng build --configuration=local",
    "watch": "npm run config && ng build --watch --configuration=local",
    "test": "npm run config && ng test"
  }
}
```

Now, every time you run `npm run build` or `npm start`, the config script will run first, generating the right
`environment.ts` from your `.env` file.

---

## The Payoff

With this setup:

* You only maintain **one template file** (`environment.hbs`).
* Each machine, CI/CD pipeline, or deployment server can inject its own environment variables.
* You avoid an explosion of environment files while keeping builds clean and consistent.

In short, you’ve turned Angular’s environment system into a **flexible, dynamic configuration pipeline**.

No more clutter, no more duplicated files. Just one template, one script, and as many environments as you need.
