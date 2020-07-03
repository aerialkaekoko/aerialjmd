<?php

return [

    // All the sections for the settings page
    'sections' => [
        'app' => [
            'title' => 'General Settings',
            'descriptions' => 'Application general settings.', // (optional)
            'icon' => 'fa fa-cog', // (optional)

            'inputs' => [
                [
                    'name' => 'app_name', // unique key for setting
                    'type' => 'text', // type of input can be text, number, textarea, select, boolean, checkbox etc.
                    'label' => 'App Name', // label for input
                    // optional properties
                    'placeholder' => 'Application Name', // placeholder for input
                    'class' => 'form-control', // override global input_class
                    'style' => '', // any inline styles
                    'rules' => 'required|min:2|max:20', // validation rules for this input
                    'value' => 'QCode', // any default value
                    'hint' => 'You can set the app name here', // help block text for input
                ],

                [
                    'name' => 'logo',
                    'type' => 'image',
                    'label' => 'Upload logo',
                    'hint' => 'Must be an image and cropped in desired size',
                    'rules' => 'image|max:500',
                    'disk' => 'public', // which disk you want to upload, default to 'public'
                    'path' => '/', // path on the disk, default to '/',
                    'preview_class' => 'thumbnail', // class for preview of uploaded image
                    'preview_style' => 'height:40px', // style for preview

                ],
                [
                    'name' => 'banner',
                    'type' => 'image',
                    'label' => 'Upload banner',
                    'hint' => 'Must be an image and cropped in desired size',
                    'rules' => 'image|max:500',
                    'disk' => 'public', // which disk you want to upload, default to 'public'
                    'path' => '/', // path on the disk, default to '/',
                    'preview_class' => 'thumbnail', // class for preview of uploaded image
                    'preview_style' => 'height:40px', // style for preview
                ],
                [
                    'name' => 'background',
                    'type' => 'image',
                    'label' => 'Upload Background',
                    'hint' => 'Must be an image and cropped in desired size',
                    'rules' => 'image|max:500',
                    'disk' => 'public', // which disk you want to upload, default to 'public'
                    'path' => '/', // path on the disk, default to '/',
                    'preview_class' => 'thumbnail', // class for preview of uploaded image
                    'preview_style' => 'height:40px', // style for preview
                ],
                [
                    'type' => 'textarea',
                    'name' => 'address',
                    'label' => 'address',
                    'rows' => 4,
                    'cols' => 10,
                    'placeholder' => 'Luxury Salon Building 30F, Yodogawa-ku, Osaka 542-0081, Osaka.',
                ],
                [
                    'name' => 'jmd_email',
                    'type' => 'email',
                    'label' => 'Admin Email',
                    'placeholder' => 'Application from email',
                    'rules' => 'required|email',
                ],
                [
                    'name' => 'phone', // unique key for setting
                    'type' => 'number', // type of input can be text, number, textarea, select, boolean, checkbox etc.
                    'label' => 'App Name', // label for input
                    // optional properties
                    'placeholder' => '+91231239817238', // placeholder for input
                    'class' => 'form-control', // override global input_class
                    'style' => '', // any inline styles
                    'rules' => 'required|min:2|max:20', // validation rules for this input
                    'value' => '+91231239817238', // any default value
                    'hint' => 'You can set Phone number here', // help block text for input
                ],

            ],
        ],
        'email' => [
            'title' => 'Email Settings',
            'descriptions' => 'How app email will be sent.',
            'icon' => 'fa fa-envelope',

            'inputs' => [
                [
                    'name' => 'from_email',
                    'type' => 'email',
                    'label' => 'From Email',
                    'placeholder' => 'Application from email',
                    'rules' => 'required|email',
                ],
                [
                    'name' => 'from_name',
                    'type' => 'text',
                    'label' => 'Email from Name',
                    'placeholder' => 'Email from Name',
                ],
                [
                    'name' => 'insurance_month_range',
                    'type' => 'number',
                    'label' => 'Insurance Month Range',
                    'placeholder' => 'Enter Month Range',
                ],
            ],
        ],
    ],

    // Setting page url, will be used for get and post request
    'url' => 'settings',

    // Any middleware you want to run on above route
    'middleware' => [],

    // View settings
    'setting_page_view' => 'settings',
    'flash_partial' => 'app_settings::_flash',

    // Setting section class setting
    'section_class' => 'card mb-3',
    'section_heading_class' => 'card-header',
    'section_body_class' => 'card-body',

    // Input wrapper and group class setting
    'input_wrapper_class' => 'form-group',
    'input_class' => 'form-control',
    'input_error_class' => 'has-error',
    'input_invalid_class' => 'is-invalid',
    'input_hint_class' => 'form-text text-muted',
    'input_error_feedback_class' => 'text-danger',

    // Submit button
    'submit_btn_text' => 'Save Settings',
    'submit_success_message' => 'Settings has been saved.',

    // Remove any setting which declaration removed later from sections
    'remove_abandoned_settings' => false,

    // Controller to show and handle save setting
    'controller' => '\QCod\AppSettings\Controllers\AppSettingController',

    // settings group
    'setting_group' => function () {
        // return 'user_'.auth()->id();
        return 'default';
    },
];
