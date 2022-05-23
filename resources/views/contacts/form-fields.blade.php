<div class="row mb-3">
    <label for="first_name" class="col-md-4 col-form-label text-md-end asterisk">Имя</label>
    <div class="col-md-6">
        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') ?? $model->first_name }}" required autocomplete="off"
               autofocus>
        @error('first_name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="middle_name" class="col-md-4 col-form-label text-md-end">Отчество</label>
    <div class="col-md-6">
        <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name') ?? $model->middle_name }}" autocomplete="off">
        @error('middle_name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="last_name" class="col-md-4 col-form-label text-md-end">Фамилия</label>
    <div class="col-md-6">
        <input id="first_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') ?? $model->last_name }}" autocomplete="off">
        @error('last_name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="phone" class="col-md-4 col-form-label text-md-end asterisk">Телефон</label>
    <div class="col-md-6">
        <input id="phone" type="text" class="form-control inputmask @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') ?? $model->phone }}" required autocomplete="off">
        @error('phone')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="is_favourite" class="col-md-4 col-form-label text-md-end">Избранное</label>
    <div class="col-md-6">
        <input type="checkbox" class="form-check-input form-check" id="is_favourite" name="is_favourite" value="1" {{ (!empty(old('is_favourite')) || !empty($model->is_favourite)) ? 'checked' : '' }} >
        @error('is_favourite')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="row mb-0">
    <div class="col-md-8 offset-md-4">
        <button type="submit" class="btn btn-primary" name="after_save" value="return">
            Сохранить и вернуться
        </button>
        <button type="submit" class="btn btn-secondary" name="after_save" value="continue">
            @if(empty($model->id))
                Сохранить и добавить еще
            @else
                Сохранить и продолжить редактирование
        </button>
        @endif
    </div>
</div>
