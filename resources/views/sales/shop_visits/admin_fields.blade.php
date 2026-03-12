<div class="row">
  <div class="col-lg-4">
    <div class="mb-5">
      <label for="city" class="form-label required">{{ __('messages.shop_visits.city') }}:</label>
      <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $visit->city) }}" required>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="mb-5">
      <label for="area" class="form-label required">{{ __('messages.shop_visits.area') }}:</label>
      <input type="text" name="area" id="area" class="form-control" value="{{ old('area', $visit->area) }}" required>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="mb-5">
      <label for="street" class="form-label required">{{ __('messages.shop_visits.street') }}:</label>
      <input type="text" name="street" id="street" class="form-control" value="{{ old('street', $visit->street) }}"
        required>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      <label for="shop_name" class="form-label required">{{ __('messages.shop_visits.shop_name') }}:</label>
      <input type="text" name="shop_name" id="shop_name" class="form-control"
        value="{{ old('shop_name', $visit->shop_name) }}" required>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      <label for="phone" class="form-label required">{{ __('messages.shop_visits.phone') }}:</label>
      <input type="text" name="phone" id="phone" class="form-control" dir="ltr"
        value="{{ old('phone', $visit->phone) }}" required>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      <label for="cards_sold" class="form-label">{{ __('messages.shop_visits.cards_sold') }}:</label>
      <input type="number" name="cards_sold" id="cards_sold" class="form-control" min="0"
        value="{{ old('cards_sold', $visit->cards_sold) }}">
    </div>
  </div>
  <div class="col-12">
    <div class="mb-5">
      <label for="notes" class="form-label">{{ __('messages.shop_visits.notes') }}:</label>
      <textarea name="notes" id="notes" class="form-control" rows="3"
        style="resize: vertical;">{{ old('notes', $visit->notes) }}</textarea>
    </div>
  </div>
  <div class="d-flex">
    <button type="submit" class="btn btn-primary me-3">{{ __('messages.common.save') }}</button>
    <a href="{{ route('admin.sales-visits.index', $visit->sales_user_id) }}"
      class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
  </div>
</div>