@if ($row->attachment)
    <a href="{{ route('inquiries.attachment.download', $row->id) }}" target="_blank"
        class="text-decoration-none text-primary">{{__('messages.common.download')}}</a>
@else
    N/A
@endif
