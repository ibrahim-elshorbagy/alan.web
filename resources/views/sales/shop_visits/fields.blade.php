<div class="row">
  <div class="col-lg-4">
    <div class="mb-5">
      <label for="city" class="form-label required">{{ __('messages.shop_visits.city') }}:</label>
      <input type="text" name="city" id="city" class="form-control"
        value="{{ old('city', isset($visit) ? $visit->city : (isset($lastVisit) ? $lastVisit->city : '')) }}"
        placeholder="{{ __('messages.shop_visits.city_placeholder') }}" required>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="mb-5">
      <label for="area" class="form-label required">{{ __('messages.shop_visits.area') }}:</label>
      <input type="text" name="area" id="area" class="form-control"
        value="{{ old('area', isset($visit) ? $visit->area : (isset($lastVisit) ? $lastVisit->area : '')) }}"
        placeholder="{{ __('messages.shop_visits.area_placeholder') }}" required>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="mb-5">
      <label for="street" class="form-label required">{{ __('messages.shop_visits.street') }}:</label>
      <input type="text" name="street" id="street" class="form-control"
        value="{{ old('street', isset($visit) ? $visit->street : (isset($lastVisit) ? $lastVisit->street : '')) }}"
        placeholder="{{ __('messages.shop_visits.street_placeholder') }}" required>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      <label for="shop_name" class="form-label required">{{ __('messages.shop_visits.shop_name') }}:</label>
      <input type="text" name="shop_name" id="shop_name" class="form-control"
        value="{{ old('shop_name', isset($visit) ? $visit->shop_name : '') }}"
        placeholder="{{ __('messages.shop_visits.shop_name_placeholder') }}" required>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      <label for="phone" class="form-label required">{{ __('messages.shop_visits.phone') }}:</label>
      <input type="text" name="phone" id="phone" class="form-control" dir="ltr"
        value="{{ old('phone', isset($visit) ? $visit->phone : '') }}"
        placeholder="{{ __('messages.shop_visits.phone_placeholder') }}" required>
    </div>
  </div>
  <div class="col-12">
    <div class="mb-5">
      <label for="notes" class="form-label">{{ __('messages.shop_visits.notes') }}:</label>
      <textarea name="notes" id="notes" class="form-control" rows="3" style="resize: vertical;"
        placeholder="{{ __('messages.shop_visits.notes_placeholder') }}">{{ old('notes', isset($visit) ? $visit->notes : '') }}</textarea>
    </div>
  </div>
  <div class="d-flex">
    <button type="submit" class="btn btn-primary me-3">{{ __('messages.common.save') }}</button>
    <a href="{{ route('sales.shop-visits.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
  </div>
</div>