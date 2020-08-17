<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const BASE_URL = '/api/v1';
    const STORES = '/stores';
    const PRODUCTS = '/products';

}
