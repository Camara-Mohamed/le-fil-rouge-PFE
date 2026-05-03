<?php

use function Pest\Laravel\get;

it('verifies if user can access public home page as a guest', function () {
    // Act
    $response = get(route('public.home', ['locale' => app()->getLocale()]));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public courses page as a guest', function () {
    // Act
    $response = get(route('public.trainings.index', ['locale' => app()->getLocale()]));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public camps page as a guest', function () {
    // Act
    $response = get(route('public.camps.index', ['locale' => app()->getLocale()]));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public about page as a guest', function () {
    // Act
    $response = get(route('public.about', ['locale' => app()->getLocale()]));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public news page as a guest', function () {
    // Act
    $response = get(route('public.announcements.index', ['locale' => app()->getLocale()]));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public contact page as a guest', function () {
    // Act
    $response = get(route('public.contact', ['locale' => app()->getLocale()]));

    // Assert
    $response->assertStatus(200);
});

it('verifies if user can access public volunteer page as a guest', function () {
    // Act
    $response = get(route('public.volunteer', ['locale' => app()->getLocale()]));

    // Assert
    $response->assertStatus(200);
});
