<?php

return [

    /*
     * The driver to use to interact with your newsletter service.
     * Available: Spatie\Newsletter\Drivers\MailChimpDriver::class,
     *            Spatie\Newsletter\Drivers\MailcoachDriver::class,
     *            Spatie\Newsletter\Drivers\LogDriver::class,
     *            Spatie\Newsletter\Drivers\NullDriver::class
     */
    'driver' => Spatie\Newsletter\Drivers\MailChimpDriver::class,

    /**
     * These arguments will be given to the driver.
     */
    'driver_arguments' => [
        'api_key' => env('MAILCHIMP_APIKEY'),

        /*
         * When using the MailChimp driver, this should be null or your custom endpoint.
         */
        'endpoint' => null,
    ],

    /*
     * The list name to use when no list name is specified in a method.
     */
    'default_list_name' => 'subscribers',

    'lists' => [

        /*
         * This key is used to identify this list. It can be used
         * as the listName parameter provided in the various methods.
         */
        'subscribers' => [

            /*
             * When using the MailChimp driver, this should be a MailChimp list id.
             * http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id.
             */
            'id' => env('MAILCHIMP_LIST_ID'),
        ],
    ],
];
