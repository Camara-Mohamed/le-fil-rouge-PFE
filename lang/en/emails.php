<?php

return [
    // Actions
    'created'      => 'created',
    'modified'     => 'modified',
    'has_created'  => 'created',
    'has_modified' => 'modified',

    // Notification subjects
    'announcement_subject'      => 'New announcement: :title',
    'document_subject'          => 'New document: :name',
    'member_changed_subject'    => 'Your account has been updated',
    'new_comment_subject'       => 'New comment: :title',
    'new_register_subject'      => 'New registration: :title',
    'participants_full_subject' => 'Full: :title',
    'upcoming_event_subject'    => 'Reminder: :title in 7 days',
    'registration_accepted'     => 'Registration accepted',
    'registration_refused'      => 'Registration refused',

    // Notification body
    'new_comment'                => 'New comment',
    'left_comment_on'            => 'left a comment on',
    'new_registration'           => 'New registration',
    'registered_to'              => 'just registered for',
    'participants_full'          => 'Maximum reached',
    'participants_full_line'     => 'has reached the maximum number of participants.',
    'participants_full_action'   => 'You can set its status to Confirmed.',
    'upcoming_event'             => 'Upcoming event',
    'upcoming_event_line1'       => 'The event :title is coming in 7 days!',
    'upcoming_event_line2'       => 'Start date: :date',
    'registration_accepted_line' => 'Your registration for :title has been accepted.',
    'registration_refused_line'  => 'Your registration for :title has been refused.',
    'member_changed_role'        => 'Your role has been updated:',
    'member_changed_status'      => 'Your status has been updated:',

    // Contact (admin)
    'contact_title'   => 'New contact message',
    'contact_from'    => 'From',
    'contact_subject' => 'Subject',
    'contact_message' => 'Message',

    // Contact confirmation (sender)
    'contact_confirmation_title' => 'Message received!',
    'contact_confirmation_hello' => 'Hi :name!',
    'contact_confirmation_body'  => 'We have received your message and will get back to you as soon as possible.',
    'contact_confirmation_sign'  => 'The Le Fil Rouge team',

    // Volunteer request (admin)
    'volunteer_request_title'   => 'New volunteer request',
    'volunteer_request_name'    => 'Name',
    'volunteer_request_email'   => 'Email',
    'volunteer_request_phone'   => 'Phone',
    'volunteer_request_message' => 'Message',

    // Volunteer confirmation (candidate)
    'volunteer_confirmation_title' => 'Request received!',
    'volunteer_confirmation_hello' => 'Hi :name!',
    'volunteer_confirmation_body'  => 'We have received your request to join Le Fil Rouge. We will get back to you shortly!',
    'volunteer_confirmation_sign'  => 'The Le Fil Rouge team',

    // New volunteer welcome
    'new_volunteer_title'    => 'Welcome to Le Fil Rouge!',
    'new_volunteer_hello'    => 'Hi :name!',
    'new_volunteer_created'  => 'Your account has been created. Here are your login credentials:',
    'new_volunteer_email'    => 'Email',
    'new_volunteer_password' => 'Password',
    'new_volunteer_cta'      => 'Log in',
    'new_volunteer_note'     => 'Remember to change your password on your first login.',

    'document_sent' => 'sent a new document.',

    // Model status
    'published'            => 'published',
    'refused'              => 'refused',
    'model_training'       => 'the training',
    'model_camp'           => 'the camp',
    'model_status_line'    => ':modelLabel :title has been :action.',

    // Layout
    'footer' => '© :year Le Fil Rouge — All rights reserved.',
];
