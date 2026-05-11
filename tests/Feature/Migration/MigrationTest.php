<?php

it('creates the users table with the correct columns', function () {
    expect(Schema::hasTable('users'))->toBeTrue();

    expect(Schema::hasColumns('users', [
        'id', 'first_name', 'last_name', 'email', 'password',
        'role', 'phone', 'birth_date', 'diet', 'avatar_path',
        'created_at', 'updated_at',
    ]))->toBeTrue();
});
