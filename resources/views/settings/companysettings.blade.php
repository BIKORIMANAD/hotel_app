@extends('layouts.settings')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Company Settings</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->
                    {{-- <form action="{{ route('company/settings/save') }}" method="POST">
                        @csrf
                        <input type="hidden" class="form-control" name="id" value="1">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Company Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="company_name" value="{{ $companySettings->company_name }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Contact Person</label>
                                    <input type="text" class="form-control" name="contact_person" value="{{ $companySettings->contact_person }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ $companySettings->address }}">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control select" name="country">
                                        <option value="KHMER" {{ ( $companySettings->country == 'KHMER') ? 'selected' : '' }}> KHMER</option>
                                        <option value="USA" {{ ( $companySettings->country == 'USA') ? 'selected' : '' }}> USA</option>
                                        <option value="United Kingdom" {{ ( $companySettings->country == 'United Kingdom') ? 'selected' : '' }}> United Kingdom</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" value="{{ $companySettings->city }}">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>State/Province</label>
                                    <select class="form-control select" name="state_province">
                                        <option value="Phnom Penh" {{ ( $companySettings->state_province == 'Phnom Penh') ? 'selected' : '' }}> Phnom Penh</option>
                                        <option value="Pursat" {{ ( $companySettings->state_province == 'Pursat') ? 'selected' : '' }}> Pursat</option>
                                        <option value="Kan dal" {{ ( $companySettings->state_province == 'Kan dal') ? 'selected' : '' }}> Kan dal</option>
                                        <option value="Ta Keav" {{ ( $companySettings->state_province == 'Ta Keav') ? 'selected' : '' }}> Ta Keav</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="text" class="form-control" name="postal_code" value="{{ $companySettings->postal_code }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $companySettings->email }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" class="form-control" name="phone_number" value="{{ $companySettings->phone_number }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input type="tel" class="form-control" name="mobile_number" value="{{ $companySettings->mobile_number }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Fax</label>
                                    <input type="text" class="form-control" name="fax" value="{{ $companySettings->fax }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Website Url</label>
                                    <input type="text" class="form-control" name="website_url" value="{{ $companySettings->website_url }}">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form> --}}
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->
@endsection