<?php

use function Pest\Laravel\get;

it('verifies if user can access public home page as a guest', function () {
    // Act
    $response = get(route('public.home'));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public courses page as a guest', function () {
    // Act
    $response = get(route('public.courses.index'));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public camps page as a guest', function () {
    // Act
    $response = get(route('public.camps.index'));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public about page as a guest', function () {
    // Act
    $response = get(route('public.about'));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public news page as a guest', function () {
    // Act
    $response = get(route('public.news.index'));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public contact page as a guest', function () {
    // Act
    $response = get(route('public.contact'));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public volunteer page as a guest', function () {
    // Act
    $response = get(route('public.volunteer'));

    // Assert
    $response->assertStatus(200);
});
