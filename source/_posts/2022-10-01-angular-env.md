---
extends: _layouts.post
section: content
title: Fighting with Angular Environments
date: 2022-12-01
description: Angular has a fantastic way of setting configurations for our application if our application has only one company as its users. But, what if we need to deploy our application, with different variables each time?
cover_image: /assets/img/post-cover-image-10.png
featured: false
categories: [angular, configuration, environment, environments, saas]
---

<p>Angular has a fantastic way of setting configurations for our application if our application has only one company as its users. But, what if we need to deploy our application, with different variables each time? (Like in a white-labeled SaaS deployment or on-prem deployment).</p>

## How Angular Env works

<p>Angular works through the magic of the <code>src/environments/environment.ts</code> file, which is substituted every time with the correct version, which lives alongside it.</p>

<p>If you deep dive into the configuration of our angular.json file you will notice this:</p>

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

<p>As you see, when we deploy for a specific environment, Angular copies its environment file and uses it to substitute with the original one, and will be taken by the rest of the application for processing.</p>

## But I can’t have 2000 configuration files around!

<p>Exactly! That’s the problem we’re going to solve right now.</p>

<p>We will need two (dev) dependencies tho:</p>

```json
dotenv handlebars
```

<p>You can simply install them through the following code:</p>

```json
npm i --save-dev dotenv handlebars
```

## Creating our configuration template

<p>In the <code>src/environments</code> folder we will create a <code>environment.hbs</code> file, with the following content:</p>

```javascript
export const environment = {
  production: {{PRODUCTION}},
  apiURL: '{{BACKEND_URL}}',
  authURL: '{{AUTH_URL}}'
}
```

<p>Obviously, feel free to adapt it to your needs, remember to refer to the handlebars documentation, which will come quite handy if you’re new to handlebars templating engine.</p>

## Parsing the template

<p>Now comes the fun part, in the root of your project, let’s create a <code>env-config.js</code> file that looks like the following:</p>

```javascript
require('dotenv')
const path = require('path')
const fs = require('fs')
const hbs = require('handlebars')
const envPath = path.join(__dirname, 'src', 'environments')
const templateFilePath = path.join(envPath, 'environment.hbs')
const environmentFilePath = path.join(envPath, 'environment.ts')
const template = hbs.compile(fs.readFileSync(templateFilePath, { encoding: 'utf-8' }))
const data = {
  PRODUCTION: process.env.PRODUCTION || false,
  BACKEND_URL: process.env.BACKEND_URL || 'http://localhost:3000',
  AUTH_URL: process.env.AUTH_URL || 'http://localhost:3000/auth'
}
fs.writeFileSync(environmentFilePath, template(data), { encoding: 'utf-8' })
```

<p>What does it do? Let’s go through it together.</p>

<ol>
  <li>Loads the <code>dotenv</code> library, which will read our <code>.env</code> file in our local machines and feed it into the <code>process.env</code> variable.</li>
  <li>Loads our <code>environment.hbs</code> template file and feeds it into the handlebars <code>compile</code> API, which will return us a function that we can later use to fill in the gaps.</li>
  <li>Configures the data we need to fill in our template. As you might notice, the keys in the object match the placeholders in the handlebars template (<code>{{PRODUCTION}}</code>, etc.). You can also configure default values.</li>
  <li>Sends the data to the template (<code>template(data)</code>), then saves the content to <code>src/environments/environment.ts</code>.</li>
</ol>

<p>And voilà! Our environment file is ready for our custom n-th environment!</p>

## Processing the template at each build

<p>We need to create a new script in our <code>package.json</code> file, let’s call it <code>config</code>.</p>

```json
{
  ...
  "scripts": {
    "ng": "ng",
    "config": "node env-config.js",
    ...
  }
  ...
}
```

<p>And now, we need to refer to it every time we build or need to serve our application:</p>

```json
{
  ...
  "scripts": {
    "ng": "ng",
    "config": "node env-config.js",
    "start": "npm run config && ng serve --configuration=local",
    "build": "npm run config && ng build --configuration=production --output-hashing=all",
    "build-dev": "npm run config && ng build --configuration=development --output-hashing=all",
    "build-local": "npm run config && ng build --configuration=local",
    "watch": "npm run config && ng build --watch --configuration local",
    "test": "npm run config && ng test",
    ...
  }
  ...
}
```

<p>And here, folks, is how we parametrize the environment of an Angular application through the environment variables of the machines that build it.</p>
