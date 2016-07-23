# JSON error handler

[![Build Status](https://img.shields.io/travis/weew/http-app-error-handler-json.svg)](https://travis-ci.org/weew/http-app-error-handler-json)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/http-app-error-handler-json.svg)](https://scrutinizer-ci.com/g/weew/http-app-error-handler-json)
[![Test Coverage](https://img.shields.io/coveralls/weew/http-app-error-handler-json.svg)](https://coveralls.io/github/weew/http-app-error-handler-json)
[![Version](https://img.shields.io/packagist/v/weew/http-app-error-handler-json.svg)](https://packagist.org/packages/weew/http-app-error-handler-json)
[![Licence](https://img.shields.io/packagist/l/weew/http-app-error-handler-json.svg)](https://packagist.org/packages/weew/http-app-error-handler-json)

## Table of contents

- [Installation](#installation)
- [Introduction](#introduction)
- [Usage](#usage)

## Installation

`composer require weew/http-app-error-handler-json`

## Introduction

This package provides visualisation of errors and exceptions in JSON format for the [weew/http-app](https://github.com/weew/http-app) package. 

## Usage

To enable this provider simply register it on the kernel.

```php
$app->getKernel()->addProviders([
    ErrorHandlerProvider::class,
    JsonErrorHandlerProvider::class,
]);
```
