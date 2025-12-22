<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>{{ __('messages.vcard.vcard_contact_excel_export') }}</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="10" style="margin-top: 40px;">
    <thead>
    <tr style="background-color: dodgerblue;">
        <th style="width: 200%;font-size: 14px"><b>{{ __('messages.common.name') }}</b></th>
        <th style="width: 400%;font-size: 14px"><b>{{ __('messages.common.email') }}</b></th>
        <th style="width: 200%;font-size: 14px"><b>{{ __('messages.common.phone') }}</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($contacts as $contact)
        <tr align="center">
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->email }}</td>
            <td style="text-align: right;">
                @if($contact->region_code)
                    +{{ $contact->region_code }} {{ $contact->phone }}
                @else
                    {{ $contact->phone }}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
