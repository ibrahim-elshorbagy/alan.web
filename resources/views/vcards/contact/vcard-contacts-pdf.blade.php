<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>{{ __('messages.vcard.vcard_contact_list') }}</title>
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div style="text-align: center;">
            <img src="{{ $companyLogo }}" alt="Logo" width="80px">
        </div>
        <div style="text-align: center;">
            <h3>{{ $appName }}</h3>
        </div>
        <div>
            <p>
                <b>{{ __('messages.vcard.vcard_name') }}: </b><span style="color: grey">{{ $vcard->name }}</span>
            </p>
        </div>
        <table width="100%" cellspacing="0" cellpadding="10" style="font-size: 14px" align="center">
            <thead>
                <tr>
                    <th style="border: 1px solid #000;">
                        {{ __('messages.common.name') }}</th>
                    <th style="border: 1px solid #000;">
                        {{ __('messages.common.email') }}
                    </th>
                    <th style="border: 1px solid #000;">
                        {{ __('messages.common.phone') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($contacts->isEmpty())
                    <tr align="center">
                        <td colspan="3" style="border: 1px solid #000;">
                            {{ __('messages.vcard.no_contact_found') }}
                        </td>
                    </tr>
                @endif
                    @foreach ($contacts as $contact)
                        <tr align="center" style="border-bottom: 1px solid #000;!important;">
                            <td style="border: 1px solid #000;"  width="30%">{{ $contact->name }}</td>
                            <td style="border: 1px solid #000;"  width="40%">{{ $contact->email }}</td>
                            <td style="border: 1px solid #000;"  width="30%">{{ $contact->region_code ? '+' . $contact->region_code . ' ' : '' }}{{ $contact->phone }}</td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </body>

</html>
