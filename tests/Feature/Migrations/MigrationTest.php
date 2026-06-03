<?php

it('creates the users table with its columns', function () {
    expect(Schema::hasTable('users'))->toBeTrue()
        ->and(Schema::hasColumns('users', [
            'id', 'first_name', 'last_name', 'email', 'password',
            'role', 'phone', 'birth_date', 'address', 'number',
            'city', 'province', 'postal_code', 'diet', 'allergies',
            'avatar_path', 'remember_token', 'created_at', 'updated_at',
        ]))->toBeTrue();
});

it('creates the trainings table with its columns', function () {
    expect(Schema::hasTable('trainings'))->toBeTrue()
        ->and(Schema::hasColumns('trainings', [
            'id', 'title', 'description', 'banner', 'start_date', 'end_date',
            'type', 'price', 'participants', 'details', 'constraints',
            'address', 'number', 'city', 'province', 'postal_code',
            'user_id', 'roles', 'status',
            'created_at', 'updated_at', 'deleted_at',
        ]))->toBeTrue();
});

it('creates the camps table with its columns', function () {
    expect(Schema::hasTable('camps'))->toBeTrue()
        ->and(Schema::hasColumns('camps', [
            'id', 'title', 'description', 'banner', 'start_date', 'end_date',
            'type', 'participants', 'details', 'constraints',
            'address', 'number', 'city', 'province', 'postal_code',
            'user_id', 'roles', 'status',
            'created_at', 'updated_at', 'deleted_at',
        ]))->toBeTrue();
});

it('creates the announcements table with its columns', function () {
    expect(Schema::hasTable('announcements'))->toBeTrue()
        ->and(Schema::hasColumns('announcements', [
            'id', 'title', 'description', 'details', 'content', 'banner',
            'user_id', 'published_at', 'created_at', 'updated_at', 'deleted_at',
        ]))->toBeTrue();
});

it('creates the documents table with its columns', function () {
    expect(Schema::hasTable('documents'))->toBeTrue()
        ->and(Schema::hasColumns('documents', [
            'id', 'type', 'name', 'path', 'user_id',
            'created_at', 'updated_at', 'deleted_at',
        ]))->toBeTrue();
});

it('creates the training_registers table with its columns', function () {
    expect(Schema::hasTable('training_registers'))->toBeTrue()
        ->and(Schema::hasColumns('training_registers', [
            'id', 'notes', 'status', 'training_id', 'user_id',
            'created_at', 'updated_at',
        ]))->toBeTrue();
});

it('creates the camp_registers table with its columns', function () {
    expect(Schema::hasTable('camp_registers'))->toBeTrue()
        ->and(Schema::hasColumns('camp_registers', [
            'id', 'notes', 'status', 'camp_id', 'user_id',
            'created_at', 'updated_at',
        ]))->toBeTrue();
});

it('creates the volunteer_requests table with its columns', function () {
    expect(Schema::hasTable('volunteer_requests'))->toBeTrue()
        ->and(Schema::hasColumns('volunteer_requests', [
            'id', 'first_name', 'last_name', 'email', 'phone',
            'message', 'status', 'created_at', 'updated_at',
        ]))->toBeTrue();
});

it('creates the contact_messages table with its columns', function () {
    expect(Schema::hasTable('contact_messages'))->toBeTrue()
        ->and(Schema::hasColumns('contact_messages', [
            'id', 'full_name', 'email', 'sujet', 'message',
            'created_at', 'updated_at', 'deleted_at',
        ]))->toBeTrue();
});
