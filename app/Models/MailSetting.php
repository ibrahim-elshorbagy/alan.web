<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    use HasFactory;

    protected $table = 'mail_settings';

    protected $fillable = [
        'id',
        'mail_protocol',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'sender_email_address',
        'mail_encryption',
    ];

    protected $casts = [
        'id' => 'integer',
        'mail_protocol' => 'integer',
        'mail_host' => 'string',
        'mail_port' => 'integer',
        'mail_username' => 'string',
        'mail_password' => 'string',
        'sender_email_address' => 'string',
        'mail_encryption' => 'string',
    ];

    const SMTP = 1;

    const MAIL_LOG = 2;

    const SENDMAIL = 3;

    const TYPE = [
        self::SMTP => 'SMTP',
        self::MAIL_LOG => 'log',
        self::SENDMAIL => 'SENDMAIL',
    ];

    const TLS = 1;

    const SSL = 2;

    const NULL = 3;

    const ENCRYPTION_TYPE = [
        self::TLS => 'tls',
        self::SSL => 'ssl',
        self::NULL => 'null',
    ];

    public static $rules = [
        'mail_protocol' => 'required',
        'mail_host' => 'required|max:100',
        'mail_port' => 'required|integer|min:1',
        'mail_username' => 'required|max:100',
        'mail_password' => 'required|min:6|max:190',
        'mail_encryption' => 'required',
        'sender_email_address' => 'required|email:filter|max:100',
    ];
}
