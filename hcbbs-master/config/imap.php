<?php
/*
* File:     imap.php
* Category: config
* Author:   M. Goldenbaum
* Created:  24.09.16 22:36
* Updated:  -
*
* Description:
*  -
*/

return [

    /*
    |--------------------------------------------------------------------------
    | IMAP default account
    |--------------------------------------------------------------------------
    |
    | The default account identifier. It will be used as default for any missing account parameters.
    | If however the default account is missing a parameter the package default will be used.
    | Set to 'false' [boolean] to disable this functionality.
    |
    */
    'default' => env('IMAP_DEFAULT_ACCOUNT', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Default date format
    |--------------------------------------------------------------------------
    |
    | The default date format is used to convert any given Carbon::class object into a valid date string.
    | These are currently known working formats: "d-M-Y", "d-M-y", "d M y"
    |
    */
    'date_format' => 'd-M-Y',

    /*
    |--------------------------------------------------------------------------
    | Available IMAP accounts
    |--------------------------------------------------------------------------
    |
    | Please list all IMAP accounts which you are planning to use within the
    | array below.
    |
    */
    'accounts' => [

        'default' => [ // account identifier
            
            // ローカル環境
            /*'host' => '127.0.0.1',
            'port' => 110,
            'encryption' => false,
            'validate_cert' => true,
            'username' => 'upload',
            'password' => '12345',
            'protocol' => 'pop3',*/
            
            // ステージング環境
            /*'host' => 'mail.hondanet.co.jp',
            'port' => 143,
            'encryption' => false,
            'validate_cert' => false,
            'username' => 'aws-upload@hondanet.co.jp',
            'password' => 'mut0063',
            'protocol' => 'imap',*/
            
            'host' => 'imap.gmail.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => false,
            'username' => 'muttestemailblog@gmail.com',
            'password' => '$12345#M',
            'protocol' => 'imap',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Available IMAP options
    |--------------------------------------------------------------------------
    |
    | Available php imap config parameters are listed below
    |   -Delimiter (optional):
    |       This option is only used when calling $oClient->
    |       You can use any supported char such as ".", "/", (...)
    |   -Fetch option:
    |       IMAP::FT_UID  - Message marked as read by fetching the message
    |       IMAP::FT_PEEK - Fetch the message without setting the "read" flag
    |   -Body download option
    |       Default TRUE
    |   -Attachment download option
    |       Default TRUE
    |   -Flag download option
    |       Default TRUE
    |   -Message key identifier option
    |       You can choose between 'id', 'number' or 'list'
    |       'id'     - Use the MessageID as array key (default, might cause hickups with yahoo mail)
    |       'number' - Use the message number as array key (isn't always unique and can cause some interesting behavior)
    |       'list'   - Use the message list number as array key (incrementing integer (does not always start at 0 or 1)
    |   -Fetch order
    |       'asc'  - Order all messages ascending (probably results in oldest first)
    |       'desc' - Order all messages descending (probably results in newest first)
    |   -Open IMAP options:
    |       DISABLE_AUTHENTICATOR - Disable authentication properties.
    |                               Use 'GSSAPI' if you encounter the following
    |                               error: "Kerberos error: No credentials cache
    |                               file found (try running kinit) (...)"
    |                               or ['GSSAPI','PLAIN'] if you are using outlook mail
    |   -Decoder options (currently only the message subject and attachment name decoder can be set)
    |       'utf-8' - Uses imap_utf8($string) to decode a string
    |       'mimeheader' - Uses mb_decode_mimeheader($string) to decode a string
    |
    */
    'options' => [
        'delimiter' => '/',
        'fetch' => \Webklex\IMAP\IMAP::FT_UID,
        'fetch_body' => true,
        'fetch_attachment' => true,
        'fetch_flags' => true,
        'message_key' => 'id',
        'fetch_order' => 'asc',
        'open' => [
            // 'DISABLE_AUTHENTICATOR' => 'GSSAPI'
        ],
        'decoder' => [
            'message' => [
                'subject' => 'utf-8' // mimeheader
            ],
            'attachment' => [
                'name' => 'utf-8' // mimeheader
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Available masking options
    |--------------------------------------------------------------------------
    |
    | By using your own custom masks you can implement your own methods for
    | a better and faster access and less code to write.
    |
    | Checkout the two examples custom_attachment_mask and custom_message_mask
    | for a quick start.
    |
    | The provided masks below are used as the default masks.
     */
    'masks' => [
        'message' => \Webklex\IMAP\Support\Masks\MessageMask::class,
        'attachment' => \Webklex\IMAP\Support\Masks\AttachmentMask::class
    ]
];
