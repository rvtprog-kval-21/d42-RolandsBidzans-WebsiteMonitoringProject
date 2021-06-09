<div class="input-info text-dark">
    <div spellcheck="false" class="form justify-content-center">
        {{-- Members dropbox --}}
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    {{__('Member')}}
                </label>
                <select name="member" class="form-control @error('type') is-invalid @enderror">
                    <option hidden disabled selected value>{{ __('Please choose member') }}*</option>
                    <optgroup label="{{ __('Members') }}">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @if (old('member') == $user->id) {{ 'selected' }} @endif>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Assign Role button--}}
        <div class="col-md-12">
            <button type="submit" class="btn btn-info mt-2 text-white">
                <i class="fas fa-pencil-alt mr-1"></i>
                {{ __('Assign Role') }}
            </button>
        </div>
    </div>
</div>
