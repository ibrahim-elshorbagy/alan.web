<div class="modal fade" id="dnsRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.custom_domain.step_guide') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="dns-container">
                    <h1 class="dns-title">{{ __('messages.custom_domain.custom_domain_msg1') }}</h1>
                    
                    <div class="dns-note">
                        <strong>{{ __('messages.custom_domain.note') }}:</strong>
                        <p>{{ __('messages.custom_domain.custom_domain_note') }}</p>
                    </div>
                    
                    <h2 class="dns-subtitle">1. {{ __('messages.custom_domain.custom_domain_setp1') }}</h2>
                    <ul class="dns-list">
                        <li>{{ __('messages.custom_domain.custom_domain_msg2') }}</li>
                        <li>{{ __('messages.custom_domain.custom_domain_msg3') }}</li>
                    </ul>

                    <h2 class="dns-subtitle">2. {{ __('messages.custom_domain.custom_domain_step2') }}</h2>
                 
                    <table class="dns-table">
                        <tr>
                            <th>Type</th>
                            <th>Host</th>
                            <th>Value</th>
                            <th>Proxy Status</th>
                            <th>TTL</th>
                        </tr>
                        <tr>
                            <td>CNAME</td>
                            <td>@</td>
                            <td>vcards-custom.com</td>
                            <td>DNS only</td>
                            <td>Auto</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>