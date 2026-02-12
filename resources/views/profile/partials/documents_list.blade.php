@if ($documents->count() > 0)
  <h6>{{ __('messages.documents.uploaded_documents') }}</h6>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>{{ __('messages.documents.file_name') }}</th>
          <th>{{ __('messages.documents.uploaded_at') }}</th>
          <th>{{ __('messages.common.action') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($documents as $document)
          <tr>
            <td>{{ $document->file_name }}</td>
            <td>{{ $document->created_at->format('Y-m-d H:i') }}</td>
            <td>
              <a href="{{ Storage::url($document->file_path) }}" target="_blank"
                class="btn btn-sm btn-info">{{ __('messages.documents.view') }}</a>
              <a href="{{ Storage::url($document->file_path) }}" download
                class="btn btn-sm btn-success">{{ __('messages.documents.download') }}</a>
              @if (auth()->user()->hasRole('super_admin'))
                <button class="btn btn-sm btn-danger delete-document"
                  data-id="{{ $document->id }}">{{ __('messages.documents.delete') }}</button>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@else
  <p class="text-muted">{{ __('messages.documents.no_documents') }}</p>
@endif
