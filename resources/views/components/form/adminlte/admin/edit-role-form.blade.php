<div class="input-info text-dark">
    <div spellcheck="false" class="form justify-content-center">
        {{-- Role name input--}}
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    {{ __('Role name *') }}
                </label>
                <input
                    value="{{ $role->name }}"
                    name="roleName"
                    type="text"
                    class="form-control @error('roleName') is-invalid @enderror">
            </div>
        </div>

        {{-- Role display name input--}}
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label>
                    {{ __('Role display name (optional)') }}
                </label>
                <input
                    value="{{ __($role->display_name) }}"
                    name="roleDisplayName"
                    type="text"
                    class="form-control @error('roleDisplayName') is-invalid @enderror">
            </div>
        </div>

        {{-- Role desc input--}}
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label>
                    {{ __('Role description (optional)') }}
                </label>
                <input
                    value="{{ $role->description }}"
                    name="roleDesc"
                    type="text"
                    class="form-control @error('roleDesc') is-invalid @enderror">
            </div>
        </div>

        {{-- Edit Role button--}}
        <div class="col-md-8">
            <button type="submit" class="btn btn-info mt-2 text-white">
                <i class="fas fa-pencil-alt mr-1"></i>
                {{ __('Edit Role') }}
            </button>
        </div>
    </div>
</div>
