@extends('admin/settings')
@section('manage-account')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="top-label">
                <label>Create Account</label>
                <label class="account-info">Allow User to manage respective campus; key, names, and clusters
                </label>


            </div>
            <form id="member_forms" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" id="step-1">
                    <input type="hidden" id="app_trailNo">
                    <!-- <label class="mp-text-fs-medium">Personal Information</label> -->
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">First Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="firstname" required />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Middle Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="middlename" required />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Last Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="lastname" required />
                    </div>


                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Contact No.</label>
                        <input class="mp-input-group__input mp-text-field" type="text" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Username/Email</label>
                        <input class="mp-input-group__input mp-text-field" type="text" required />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Password</label>
                        <input class="mp-input-group__input mp-text-field" type="text" disabled placeholder="AUTO GENERATE" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">User Level</label>
                        <input class="mp-input-group__input mp-text-field" type="text" required />
                    </div>

                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Select Campus</label>
                        <select class="mp-input-group__input mp-text-field" name="civilstatus" required>
                            <option>campus 1</option>
                            <option>campus 1</option>
                            <option>campus 1</option>
                            <option>campus 1</option>
                            <option>campus 1</option>
                        </select>
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Mange Permission</label>
                        <table class="permission-table">
                            <tr>
                                <th>Modules</th>
                                <th>Full Access</th>
                                <th>View Only</th>
                            </tr>
                            <tr>
                                <td>Settings & Configuration</td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                            </tr>

                            <tr>
                                <td>Election Module</td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                            </tr>

                            <tr>
                                <td>Loan Module</td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                            </tr>

                            <tr>
                                <td>Benefits Module</td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                            </tr>
                            <tr>
                                <td>Transaction & Equity</td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                            </tr>
                            <tr>
                                <td>Membership Application</td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                            </tr>
                            <tr>
                                <td>Members Module</td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                                <td>
                                    <input class="checkbox-color" type="checkbox" name="" id="">
                                </td>
                            </tr>
                        </table>

                    </div>
                    <a class="up-button-green btn-md button-animate-right mp-text-center" type="submit">
                        <span>Save Record</span>
                    </a>
                    <a class="up-button-grey btn-md button-animate-right mp-text-center" type="submit">
                        <span>Clear</span>
                    </a>
                    <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                </div>

            </form>
        </div>

        <div class="col-lg-8">
            <div>
                <div class="top-label">
                    <label>Data Records</label>
                </div>
                <div class="mp-mt3 table-container" style="height:calc(100%-100px) !important;">
                    <table class="members-table" style="height: auto;;" width="100%">
                        <thead>
                            <tr>
                                <th>
                                    <span>Username</span>
                                </th>
                                <th>
                                    <span>Password</span>
                                </th>
                                <th>
                                    <span>Fullname</span>
                                </th>
                                <th>
                                    <span>Campus</span>
                                </th>
                                <th>
                                    <span>User Level</span>
                                </th>
                                <th>
                                    <span>Status</span>
                                </th>
                                <th>
                                    <span>Action</span>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 100; $i++) <tr>
                                <td>akosirr</td>
                                <td>asd</td>
                                <td>AKO SI RR</td>
                                <td>UP DILIMAN</td>
                                <td>Super admin</td>
                                <td>Pending</td>
                                <td>
                                    <button class="up-button-green" style="border-radius: 10px;">
                                        view <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>

                                </td>
                                </tr>

                                @endfor
                        </tbody>
                    </table>



                </div>
                <div class="records-button" style="transform: scale(0.7);">
                    <a class="up-button-green btn-md   mp-text-center" style="margin-top:3px; width: 160px;" type="submit">
                        <span>Print</span>
                    </a>
                    <br>
                    <a class="up-button  btn-md    mp-text-center" style="margin-top:3px; width: 160px;" type="submit">
                        <span>Download</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection