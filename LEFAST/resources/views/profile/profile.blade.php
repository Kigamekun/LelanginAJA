@extends('layouts.base')
@section('menu')
    <li class="menu-item ">
        <a href="/" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Dashboard', app()->getLocale()) }}</div>
        </a>
    </li>

    {{-- <li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{GoogleTranslate::trans('Account', app()->getLocale()) }}</span>
</li> --}}
    <li class="menu-item active">
        <a href="{{ route('profile.edit') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Account Setting', app()->getLocale()) }}</div>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('auction-list') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-list-ul"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Auction List', app()->getLocale()) }}</div>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('bookmarks') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-bookmark"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Bookmarks', app()->getLocale()) }}</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{ route('history') }}" class="menu-link">

            <i class="menu-icon tf-icons bx bx-history"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('History', app()->getLocale()) }}</div>
        </a>
    </li>


    <li class="menu-item ">
        <a href="{{ route('help-center') }}" class="menu-link">

            <i class="menu-icon tf-icons bx bx-support"></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Help Center', app()->getLocale()) }}</div>
        </a>
    </li>
    <li class="menu-item ">
        <a href="{{ route('appointment') }}" class="menu-link">

           <i class='menu-icon tf-icons bx bx-group'></i>
            <div data-i18n="Analytics">{{GoogleTranslate::trans('Appointment', app()->getLocale()) }}</div>
        </a>
    </li>
@endsection


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{GoogleTranslate::trans('Account Settings', app()->getLocale()) }} /</span> {{GoogleTranslate::trans('Account', app()->getLocale()) }}</h4>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> {{GoogleTranslate::trans('Account', app()->getLocale()) }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notifications') }}"><i class="bx bx-bell me-1"></i>
                            {{GoogleTranslate::trans('Notifications', app()->getLocale()) }}</a>
                    </li>

                </ul>
                <div class="card mb-4">
                    <h5 class="card-header">{{GoogleTranslate::trans('Profile Details', app()->getLocale()) }}</h5>
                    <!-- Account -->
                    <form id="formAccountSettings" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="
                                @if (strpos($user->thumb, "https://")!==false)
                                {{ $user->thumb }}
                                @else

                                {{ url('avatar/'.$user->thumb) }}
                                @endif
                                " alt="user-avatar" class="d-block rounded" height="100"
                                    width="100" id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" name="avatar"
                                            onchange="loadFile(event)" hidden accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>

                                    <p class="text-muted mb-0">{{GoogleTranslate::trans('Allowed JPG, GIF or PNG. Max size of 800K', app()->getLocale()) }}</p>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">

                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="name" class="form-label">First Name</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ $user->name }}" autofocus />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="text" id="email" value="{{ $user->email }}"
                                        placeholder="john.doe@example.com" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">ID (+62)</span>
                                        <input type="text" id="phoneNumber" name="phone" class="form-control"
                                            value="{{ $user->phone }}" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ $user->address }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="state" class="form-label">State</label>
                                    <input class="form-control" type="text" id="state" name="state"
                                        value="{{ $user->state }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="zipCode" class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" id="zipCode" name="zipcode"
                                        value="{{ $user->zipcode }}" maxlength="6" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="country">Country</label>
                                    <select id="country" name="country" class="select2 form-select">

                                        @if (!is_null($user->country))
                                        <option value="{{$user->country}}">{{$user->country}}</option>
                                        @else
                                        <option value="">Select</option>
                                        @endif

                                        <option value="Australia">Australia</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="Canada">Canada</option>
                                        <option value="China">China</option>
                                        <option value="France">France</option>
                                        <option value="Germany">Germany</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Korea">Korea, Republic of</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Philippines">Philippines</option>
                                        <option value="Russia">Russian Federation</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                    </select>
                                </div>

                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">{{GoogleTranslate::trans('Save changes', app()->getLocale()) }}</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
            <div class="card">
                <h5 class="card-header">{{GoogleTranslate::trans('Delete Account', app()->getLocale()) }}</h5>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading fw-bold mb-1">{{GoogleTranslate::trans('Are you sure you want to delete your account?', app()->getLocale()) }}</h6>
                            <p class="mb-0">{{GoogleTranslate::trans('Once you delete your account, there is no going back. Please be certain.', app()->getLocale()) }}
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('profile.destroy') }}" id="formAccountDeactivation" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="accountActivation"
                                id="accountActivation" />
                            <label class="form-check-label" for="accountActivation">{{GoogleTranslate::trans('I confirm my account
                                deactivation', app()->getLocale()) }}</label>
                        </div>
                        <button type="submit" class="btn btn-danger deactivate-account">{{GoogleTranslate::trans('Deactivate Account', app()->getLocale()) }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script language="javascript">
        var loadFile = function(event) {
            var image = document.getElementById('uploadedAvatar');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endsection
