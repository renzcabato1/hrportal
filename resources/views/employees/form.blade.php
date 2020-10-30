@inject('cities', 'App\Http\Utilities\City')
<div class="row">
    <div class="col-sm-12">

        <!--      Wizard container        -->
        <div class="wizard-container">
            <div class="card wizard-card" data-color="green" id="wizard">

                <!--        You can switch " data-color="green" "  with one of the next bright colors: "blue", "azure", "orange", "red"       -->

                <div class="wizard-header hidden-xs hidden-sm">
                    <h3 class="wizard-title">Employee Information Portal</h3>
                    <p class="category">Fill in all the required information.</p>
                </div>

                {{-- @if(Request::is('employees/*/edit')) --}}
                <div class="row">
                    <div class="col-md-12">
                        @if (file_exists( public_path() . '/id_image/employee_image/' . $employee->id . '.png'))
                        <img id="output_employee_image" class="img-circle img-responsive" style="display: block; margin: 0 auto; height: 150px; width: auto;" src="{{asset('/id_image/employee_image/'.$employee->id. '.png?'. mt_rand(100000, 999999))}}"> @else
                        <img id="output_employee_image" class="img-circle img-responsive" style="display: block; margin: 0 auto; height: 150px; width: auto;" src="{{asset('/id_image/employee_image/preview.png')}}"> @endif
                    </div>
                </div>
                {{-- @endif --}}

                <div class="wizard-navigation hidden-xs hidden-sm">
                    <div class="progress-with-circle">
                        <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="4" style="width: 15%;"></div>
                    </div>
                    <ul>
                        <li>
                            <a href="#location" style="margin-left: 80px;" data-toggle="tab">
                                <div class="icon-circle">
                                    <i class="ti-map"></i>
                                </div>
                                Personal
                            </a>
                        </li>
                        <li>
                            <a href="#type" data-toggle="tab">
                                <div class="icon-circle">
                                    <i class="ti-direction-alt"></i>
                                </div>
                                Work
                            </a>
                        </li>
                        <li>
                            <a href="#facilities" data-toggle="tab">
                                <div class="icon-circle">
                                    <i class="ti-panel"></i>
                                </div>
                                Contact
                            </a>
                        </li>
                        <li>
                            <a href="#description" data-toggle="tab">
                                <div class="icon-circle">
                                    <i class="ti-comments"></i>
                                </div>
                                Identification
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane" id="location">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 class="info-text"> Basic Employee Information</h5>
                            </div>

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                <div class="col-sm-12">
                                    <label>Upload Image</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User'))
                                        <input id="employee_image" name="avatar" type="file" disabled class="form-control" accept="image/*" onchange="document.getElementById('output_employee_image').src = window.URL.createObjectURL(this.files[0])">
                                    @else
                                        <input id="employee_image" name="avatar" type="file" class="form-control" accept="image/*" onchange="document.getElementById('output_employee_image').src = window.URL.createObjectURL(this.files[0])">
                                    @endif

                                </div>

                                <div class="col-sm-12">
                                    <br><br>
                                    <center>
                                        @if (file_exists( public_path() . '/id_image/employee_signature/' . $employee->id . '.png'))
                                        <img src="{{url('/id_image/employee_signature/' . $employee->id . '.png?'. mt_rand(100000, 999999))}}" id="output_signature" style="width:200px;height:auto;border:1px dotted;" /> @else
                                        <img src="{{url('/id_image/employee_signature/preview.png')}}" id="output_signature" style="width:200px;height:auto;border:1px dotted;" /> @endif
                                    </center>
                                    <br>
                                    <label>Upload Signature</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User'))
                                        <input id="employee_signature" name="signature" disabled type="file" class="form-control" accept="image/png" onchange="document.getElementById('output_signature').src = window.URL.createObjectURL(this.files[0])">
                                    @else 
                                        <input id="employee_signature" name="signature" type="file" class="form-control" accept="image/png" onchange="document.getElementById('output_signature').src = window.URL.createObjectURL(this.files[0])">
                                    @endif
                                </div>

                                <div class="col-sm-12">
                                    <hr/>
                                </div>
                                <div class="col-sm-4">
                                    <label>First Name</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) {!! Form::text('first_name', null, ['class' => 'form-control', 'v-model' => 'first_name','disabled']) !!} @else {!! Form::text('first_name', null, ['class' => 'form-control', 'v-model' => 'first_name']) !!} @endif

                                </div>

                                <div class="col-sm-2">
                                    <label>Middle Name</label>
                                    <br> @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) @if($employee->gender == 'MALE' && !empty($employee->middle_name)) {!! Form::text('middle_name', null, ['class' => 'form-control', 'v-model' => 'middle_name','disabled']) !!} @else {!! Form::text('middle_name', null, ['class' => 'form-control', 'v-model' => 'middle_name']) !!} @endif @else {!! Form::text('middle_name', null, ['class' => 'form-control', 'v-model' => 'middle_name']) !!} @endif
                                </div>

                                <div class="col-sm-2">
                                    <label>Middle Initial</label>
                                    <br> @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) @if($employee->gender == 'MALE' && !empty($employee->middle_initial)) {!! Form::text('middle_initial', null, ['class' => 'form-control', 'v-model' => 'middle_initial','disabled']) !!} @else {!! Form::text('middle_initial', null, ['class' => 'form-control', 'v-model' => 'middle_initial']) !!} @endif @else {!! Form::text('middle_initial', null, ['class' => 'form-control', 'v-model' => 'middle_initial']) !!} @endif
                                </div>

                                <div class="col-sm-4">
                                    <label>Last Name</label>
                                    <br> @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) @if($employee->gender == 'MALE' && !empty($employee->last_name)) {!! Form::text('last_name', null, ['class' => 'form-control', 'v-model' => 'last_name','disabled']) !!} @else {!! Form::text('last_name', null, ['class' => 'form-control', 'v-model' => 'last_name']) !!} @endif @else {!! Form::text('last_name', null, ['class' => 'form-control', 'v-model' => 'last_name']) !!} @endif
                                </div>
                            </div>

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                <div class="col-sm-4{{ $errors->has('name_suffix') ? ' has-error' : '' }}">
                                    <label>Suffix</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) {!! Form::text('name_suffix', null, ['class' => 'form-control', 'disabled','style'=>'margin-top:5px;']) !!} @else {!! Form::text('name_suffix', null, ['class' => 'form-control','style'=>'margin-top:5px;']) !!} @endif @if ($errors->has('name_suffix'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('name_suffix') }}</strong>
                                  </span> @endif
                                </div>

                                <div class="col-sm-2{{ $errors->has('marital_status') ? ' has-error' : '' }}">
                                    <label>Marital Status</label>
                                    {{ Form::select('marital_status', $marital_statuses, null, array('id'=>'maritalStatus', 'class'=>'form-control')) }} @if ($errors->has('marital_status'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('marital_status') }}</strong>
                                  </span> @endif
                                </div>

                                <div class="col-sm-2{{ $errors->has('marital_status_attachment') ? ' has-error' : '' }}">

                                    @if($employee->marital_status == "Married" || $employee->marital_status == "Divorced")
                                    <label>Attachment @if($employee->marital_status_attachment) <a href="/files/marital_status_attachments/{{ $employee->marital_status_attachment }}" target="_blank"> - View File</a> @endif</label>
                                        {!! Form::file('marital_status_attachment',['id'=>'marital_status_attachment','class'=>'form-control','style'=>'margin-top:5px;']) !!} 
                                    @else
                                    <label>Attachment</label>
                                        {!! Form::file('marital_status_attachment',['id'=>'marital_status_attachment','class'=>'form-control','style'=>'margin-top:5px;','disabled']) !!} 
                                    @endif 
                                    @if ($errors->has('marital_status_attachment'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('marital_status_attachment') }}</strong>
                                        </span> 
                                    @endif
                                </div>

                                @if(Request::is('employees/*/edit'))
                                <div class="{{ $employee->getAge() ? 'col-sm-2' : 'col-sm-4'}} {{ $errors->has('birthdate') ? ' has-error' : '' }}">
                                    <label>Date of Birth</label>
                                    @if(Entrust::hasRole('User')) {!! Form::input('date', 'birthdate', $employee->birthdate ? $employee->birthdate->format('Y-m-d') : 'mm/dd/yyyy', ['class' => 'form-control','disabled','style'=>'margin-top:5px;']) !!} @else {!! Form::input('date', 'birthdate', $employee->birthdate ? $employee->birthdate->format('Y-m-d') : 'mm/dd/yyyy', ['class' => 'form-control','style'=>'margin-top:5px;']) !!} @endif @if ($errors->has('birthdate'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('birthdate') }}</strong>
                                    </span> @endif
                                </div>

                                @if($employee->getAge())
                                <div class="col-sm-2">
                                    <label>Age @if($employee->getAgeRange($employee->getAge())) <span style="color:red;font-size:12px;">{{$employee->getAgeRange($employee->getAge())}}</span> @endif</label>
                                    {!! Form::input('text', 'age', $employee->getAge(), ['class' => 'form-control','disabled','style'=>'margin-top:5px;']) !!}
                                </div>
                                @endif @else
                                <div class="col-sm-4 {{ $errors->has('birthdate') ? ' has-error' : '' }}">
                                    <label>Date of Birth</label>
                                    {!! Form::input('date', 'birthdate', 'mm/dd/yyyy', ['class' => 'form-control','style'=>'margin-top:5px;']) !!} @if ($errors->has('birthdate'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('birthdate') }}</strong>
                                    </span> @endif
                                </div>
                                @endif
                            </div>

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                <div class="col-sm-4{{ $errors->has('gender') ? ' has-error' : '' }}">
                                    <label>Gender</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) {{ Form::select('gender', array( '' => '--- Select Gender ---', 'MALE' => 'MALE', 'FEMALE' => 'FEMALE'), null, array('placeholder' => ' --- Select Gender ---', 'class'=>'form-control','disabled')) }} @else {{ Form::select('gender', array( '' => '--- Select Gender ---', 'MALE' => 'MALE', 'FEMALE' => 'FEMALE'), null, array('placeholder' => ' --- Select Gender ---', 'class'=>'form-control')) }} @endif

                                </div>
                                <div class="col-sm-8{{ $errors->has('birthplace') ? ' has-error' : '' }}">
                                    <label>Birthplace</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) {!! Form::text('birthplace', null, ['class' => 'form-control','style'=>'margin-top:5px;','disabled']) !!} @else {!! Form::text('birthplace', null, ['class' => 'form-control','style'=>'margin-top:5px;']) !!} @endif @if ($errors->has('birthplace'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('birthplace') }}</strong>
                              </span> @endif
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 class="info-text"> Educational Background</h5>
                            </div>
                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                <h5>Tertiary</h5>
                                <div class="col-sm-4{{ $errors->has('school_graduated') ? ' has-error' : '' }}">
                                    <label>Name of School</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) {!! Form::text('school_graduated', null, ['class' => 'form-control','disabled']) !!} @else {!! Form::text('school_graduated', null, ['class' => 'form-control']) !!} @endif @if ($errors->has('school_graduated'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('school_graduated') }}</strong>
                                        </span> @endif
                                </div>

                                <div class="col-sm-4{{ $errors->has('school_course') ? ' has-error' : '' }}">
                                    <label>Course</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) {!! Form::text('school_course', null, ['class' => 'form-control','disabled']) !!} @else {!! Form::text('school_course', null, ['class' => 'form-control']) !!} @endif @if ($errors->has('school_course'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('school_course') }}</strong>
                                        </span> @endif
                                </div>

                                <div class="col-sm-4{{ $errors->has('school_year') ? ' has-error' : '' }}">
                                    <label>Year Graduated</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) {!! Form::text('school_year', null, ['class' => 'form-control','disabled']) !!} @else {!! Form::text('school_year', null, ['class' => 'form-control']) !!} @endif @if ($errors->has('school_year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('school_year') }}</strong>
                                        </span> @endif
                                </div>
                            </div>
                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                <h5>Vocational Course</h5>

                                <div class="col-sm-4{{ $errors->has('vocational_graduated') ? ' has-error' : '' }}">
                                    <label>Name of School</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) {!! Form::text('vocational_graduated', null, ['class' => 'form-control','disabled']) !!} @else {!! Form::text('vocational_graduated', null, ['class' => 'form-control']) !!} @endif @if ($errors->has('vocational_graduated'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vocational_graduated') }}</strong>
                                        </span> @endif
                                </div>

                                <div class="col-sm-4{{ $errors->has('vocational_course') ? ' has-error' : '' }}">
                                    <label>Course</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) {!! Form::text('vocational_course', null, ['class' => 'form-control','disabled']) !!} @else {!! Form::text('vocational_course', null, ['class' => 'form-control']) !!} @endif @if ($errors->has('vocational_course'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vocational_course') }}</strong>
                                        </span> @endif
                                </div>

                                <div class="col-sm-4{{ $errors->has('vocational_year') ? ' has-error' : '' }}">
                                    <label>Year Graduated</label>
                                    @if(Request::is('employees/*/edit') && Entrust::hasRole('User')) {!! Form::text('vocational_year', null, ['class' => 'form-control','disabled']) !!} @else {!! Form::text('vocational_year', null, ['class' => 'form-control']) !!} @endif @if ($errors->has('vocational_year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vocational_year') }}</strong>
                                        </span> @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- firs part -->

                    <div class="tab-pane" id="type">
                        <h5 class="info-text">Job Information Details </h5>
                        <div class="row">

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">

                                <div class="col-sm-6{{ $errors->has('company_list') ? ' has-error' : '' }}">
                                    <label>Company</label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff') ) {!! Form::select('company_list', $companies, null, ['id'=>'company','class' => 'form-control', 'placeholder' => '****Select a Company']) !!} @else {!! Form::select('company_list', $companies, null, ['id'=>'company','class' => 'form-control', 'placeholder' => '****Select a Company','disabled']) !!} @endif @if ($errors->has('company_list'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('company_list') }}</strong>
                                  </span> @endif
                                </div>

                                <div class="col-sm-3{{ $errors->has('division') ? ' has-error' : '' }}">
                                    <label>Division</label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff') ) {!! Form::select('division', isset($divisions) ? $divisions : [], null, ['id'=>'division','class' => 'form-control', 'placeholder' => '****Select Division']) !!} 
                                    @else {!! Form::select('division', $divisions, null, ['id'=>'division','class' => 'form-control', 'placeholder' => '****Select a Company','disabled']) !!} @endif
                                </div>

                                <div class="col-sm-3{{ $errors->has('department_list') ? ' has-error' : '' }}">
                                    <label>Department</label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff') ) {!! Form::select('department_list', $departments, null, ['class' => 'form-control', 'placeholder' => '****Select a Department']) !!} @else {!! Form::select('department_list', $departments, null, ['class' => 'form-control', 'placeholder' => '****Select a Department', 'disabled']) !!} @endif @if ($errors->has('department_list'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('department_list') }}</strong>
                                  </span> @endif
                                </div>

                            </div>
                            <!-- end form-group -->

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                @if(Request::is('employees/*/edit'))
                                <div class="col-sm-6{{ $errors->has('employee_number') ? ' has-error' : '' }}">
                                    <label>Employee Number</label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff') ) {!! Form::input('text', 'employee_number', null , ['class' => 'form-control']) !!} @else {!! Form::input('text', 'employee_number', null , ['class' => 'form-control','disabled']) !!} @endif @if ($errors->has('employee_number'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('employee_number') }}</strong>
                                  </span> @endif
                                </div>
                                @endif
                                <div class="col-sm-6{{ $errors->has('ess_ee_number') ? ' has-error' : '' }}">
                                    <label>ESS Employee No.</label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff')) {!! Form::input('text', 'ess_ee_number', null , ['class' => 'form-control']) !!} @else {!! Form::input('text', 'ess_ee_number', null , ['class' => 'form-control','disabled']) !!} @endif @if ($errors->has('ess_ee_number'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('ess_ee_number') }}</strong>
                                  </span> @endif
                                </div>
                            </div>

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">

                                @if(Request::is('employees/*/edit'))
                                <div class="{{$employee->getTenure($employee->date_hired) ? 'col-sm-3' : 'col-sm-6'}} {{ $errors->has('date_hired') ? ' has-error' : '' }}">
                                    <label>Date Hired</label>
                                    @if (Entrust::hasRole('User')) {!! Form::input('date', 'date_hired', $employee->date_hired->format('Y-m-d'), ['class' => 'form-control','disabled']) !!} @else {!! Form::input('date', 'date_hired', $employee->date_hired->format('Y-m-d'), ['class' => 'form-control']) !!} @endif @if ($errors->has('date_hired'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('date_hired') }}</strong>
                                    </span> @endif
                                </div>

                                @if($employee->getTenure($employee->date_hired))
                                <div class="col-sm-3">
                                    <label>Tenure</label>
                                    {!! Form::input('text', 'tenure', $employee->getTenure($employee->date_hired), ['class' => 'form-control','disabled']) !!}
                                </div>
                                @endif @else
                                <div class="col-sm-6 {{ $errors->has('date_hired') ? ' has-error' : '' }}">
                                    <label>Date Hired</label>
                                    {!! Form::input('date', 'date_hired', 'mm/dd/yyy', ['class' => 'form-control']) !!} @if ($errors->has('date_hired'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('date_hired') }}</strong>
                                  </span> @endif
                                </div>
                                @endif

                                <div class="col-sm-6{{ $errors->has('position') ? ' has-error' : '' }}">
                                    <label>Position</label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff')) {!! Form::text('position', null, ['class' => 'form-control']) !!} @else {!! Form::text('position', null, ['class' => 'form-control','disabled']) !!} @endif @if ($errors->has('position'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('position') }}</strong>
                                  </span> @endif
                                </div>
                            </div>
                            <!-- end form-group -->

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                <div class="col-sm-6 {{ $errors->has('location_list') ? ' has-error' : '' }}">
                                    <label>Location / Site</label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff') ) {!! Form::select('location_list', $locations, null, ['class' => 'form-control', 'placeholder' => '****Select a location']) !!} @else {!! Form::select('location_list', $locations, null, ['class' => 'form-control', 'placeholder' => '****Select a location','disabled']) !!} @endif @if ($errors->has('location_list'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('location_list') }}</strong>
                                </span> @endif
                                </div>
                                <div class="col-sm-6 {{ $errors->has('area') ? ' has-error' : '' }}">
                                    <label>Area</label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff') ) {!! Form::input('text','area', null, ['class' => 'form-control','style'=>'margin-top:5px;']) !!} @else {!! Form::input('text','area', null, ['class' => 'form-control','disabled','style'=>'margin-top:5px;']) !!} @endif @if ($errors->has('area'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('area') }}</strong>
                                </span> @endif
                                </div>
                            </div>
                            @if (Entrust::hasRole('User') && $employee->bank_account_verified == 0 && !empty($employee->bank_account_number))
                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                <div class="col-sm-6">
                                    <button class="btn btn-success" id="btn-verify-account">Verify Bank Account</button>
                                </div>
                            </div>
                            @else
                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                <div class="col-sm-6{{ $errors->has('bank_name') ? ' has-error' : '' }}">
                                    <label>Bank Name</label>
                                    @if (Entrust::hasRole('User')) {!! Form::text('bank_name', null, ['class' => 'form-control','disabled']) !!} @else {!! Form::text('bank_name', null, ['class' => 'form-control']) !!} @endif @if ($errors->has('bank_name'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('bank_name') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-sm-6{{ $errors->has('bank_account_number') ? ' has-error' : '' }}">
                                    <label>Bank Account Number</label>
                                    @if (Entrust::hasRole('User')) {!! Form::text('bank_account_number', null, ['class' => 'form-control','disabled']) !!} @else {!! Form::text('bank_account_number', null, ['class' => 'form-control']) !!} @endif @if ($errors->has('bank_account_number'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('bank_account_number') }}</strong>
                                    </span> @endif
                                </div>
                            </div>
                            @endif @role('Administrator')
                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                <div class="col-sm-6{{ $errors->has('classification') ? ' has-error' : '' }}">
                                    <label>Classification</label>
                                    {{ Form::select('classification', array( 'Probationary' => 'Probationary', 'Regular' => 'Regular', 'Consultant' => 'Consultant', 'Project' => 'Project Based'), null, array('placeholder' => ' --- Select classification ---', 'class'=>'form-control' )) }} @if ($errors->has('classification'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('classification') }}</strong>
                                      </span> @endif
                                </div>

                                <div class="col-sm-6{{ $errors->has('status') ? ' has-error' : '' }}">
                                    <label>Status</label>
                                    {{ Form::select('status', array( 'Active' => 'Active', 'Inactive' => 'Inactive', 'On-hold' => 'On-hold', 'Notification' => 'Notification'), null, array('placeholder' => ' --- Select status ---', 'class'=>'form-control' )) }} @if ($errors->has('status'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('status') }}</strong>
                                      </span> @endif
                                </div>
                            </div>
                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                <div class="col-sm-6{{ $errors->has('level') ? ' has-error' : '' }}">
                                    <label>Level</label>
                                    {{ Form::select('level', $levels, null, array('placeholder' => ' --- Select level ---', 'class'=>'form-control' )) }} @if ($errors->has('level'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('level') }}</strong>
                                    </span> @endif
                                </div>
                            </div>

                            @if(Request::is('employees/*/edit'))
                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                <div class="col-sm-6{{ $errors->has('date_regularized') ? ' has-error' : '' }}">
                                    <label>Date Regularized</label>
                                    {!! Form::input('date', 'date_regularized', 'mm/dd/yyyy', ['class' => 'form-control']) !!} @if ($errors->has('date_regularized'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('date_regularized') }}</strong>
                                    </span> @endif
                                </div>

                                <div class="col-sm-6{{ $errors->has('date_resigned') ? ' has-error' : '' }}">
                                    <label>Date Resigned</label>
                                    {!! Form::input('date', 'date_resigned', 'mm/dd/yyyy', ['class' => 'form-control']) !!} @if ($errors->has('date_resigned'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('date_resigned') }}</strong>
                                    </span> @endif
                                </div>
                            </div>
                            @endif @endrole

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">
                                @if(str_contains(Request::path(), 'edit'))
                                <div class="col-sm-12{{ $errors->has('job_remarks') ? ' has-error' : '' }}">
                                    <label>Job Remarks</label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff')) {!! Form::textarea('job_remarks', null, ['class' => 'form-control', 'rows' => '3', 'cols' => '50']) !!}
                                    <span class="help-block">Indicate info/data to be updated (ex. Company - LFUG to MTPCI)</span> @else {!! Form::textarea('job_remarks', null, ['class' => 'form-control','disabled', 'rows' => '3', 'cols' => '50']) !!}
                                    <span class="help-block">Indicate info/data to be updated (ex. Company - LFUG to MTPCI)</span> @endif @if ($errors->has('job_remarks'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('job_remarks') }}</strong>
                                    </span> @endif
                                </div>
                                @endif
                            </div>
                            <!-- end form-group -->

                            @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff'))
                            <div class="form-group" style="padding-left: 45px; padding-right: 45px;">
                                <label>Assign Head (ex. ESS Approver, BU Head, Cluster Head)</label>

                                <div class="table-responsive">
                                    <table class="table table-hover" id="tab_assign_head">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th class="text-center">
                                                    Name
                                                </th>
                                                <th class="text-center">
                                                    Position
                                                </th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <a id="add_head_row" class="btn btn-sm  btn-fill  pull-left"><i class="ion-plus"></i> Add Row</a>
                                                    <a id='delete_head_row' class="pull-right btn btn-fill  btn-sm "><i class="ion-minus"></i> Delete Row</a>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody id="assign-tbody">
                                            @if(Request::is('employees/*/edit')) @if($employee->assign_heads) @foreach($employee->assign_heads as $key => $assign_head)
                                            <tr id='headr{{$key}}'>
                                                <td align="center">

                                                    <input type="hidden" name="assign_head[{{$key}}][id]" value="{{$assign_head->id}}"> {{ Form::checkbox('assign_head['.$key.'][delete]',null,null, array('id'=>'headr-check-'.$assign_head->id,'id'=>$key,'class'=>'delete-checkbox')) }}
                                                    <span>Delete</span>
                                                </td>

                                                <td class="{{ $errors->has('head_name[]') ? ' has-error' : '' }}" width="50%">
                                                    {{ Form::select('assign_head['.$key.'][head_name]', $employees, $assign_head->employee_head_id, array('class'=>'chosen-select','id'=>'head_name_'.$key,'placeholder'=>'--Select Name--')) }}
                                                </td>

                                                <td class="{{ $errors->has('head_position[]') ? ' has-error' : '' }}" width="50%">
                                                    {{ Form::select('assign_head['.$key.'][head_position]', $head_positions, $assign_head->head_id, array('class'=>'chosen-select','id'=>'head_position_'.$key,'placeholder'=>'--Select Position--')) }}
                                                </td>
                                            </tr>
                                            @endforeach @else
                                            <tr id='headr0'>
                                                <td>1</td>
                                                <td class="{{ $errors->has('assign_head[0][head_name]') ? ' has-error' : '' }}" width="50%">

                                                    {{ Form::select('assign_head[0][head_name]', $employees, null, array('class'=>'chosen-select','id'=>'head_name_0','placeholder'=>'--Select Name--')) }}
                                                </td>
                                                <td class="{{ $errors->has('assign_head[0][head_position]') ? ' has-error' : '' }}" width="50%">
                                                    {{ Form::select('assign_head[0][head_position]', $head_positions, null, array('class'=>'chosen-select','id'=>'head_position_0','placeholder'=>'--Select Position--')) }}
                                                </td>
                                            </tr>
                                            @endif @else
                                            <tr id='headr0'>
                                                <td>1</td>
                                                <td class="{{ $errors->has('head_name[]') ? ' has-error' : '' }}" width="50%">

                                                    {{ Form::select('assign_head[0][head_name]', $employees, null, array('class'=>'chosen-select','id'=>'head_name_0','placeholder'=>'--Select Name--')) }}
                                                </td>
                                                <td class="{{ $errors->has('head_position[]') ? ' has-error' : '' }}" width="50%">
                                                    {{ Form::select('assign_head[0][head_position]', $head_positions, null, array('class'=>'chosen-select','id'=>'head_position_0','placeholder'=>'--Select Position--')) }}
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                    <!-- end second part -->

                    <div class="tab-pane" id="facilities">
                        <h5 class="info-text">Contact Details </h5>
                        <div class="row">

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">

                                <div class="col-sm-6{{ $errors->has('current_address') ? ' has-error' : '' }}">
                                    <label>Current Address</label>
                                    {!! Form::textarea('current_address', null, ['class' => 'form-control', 'rows' => '4', 'cols' => '50']) !!} @if ($errors->has('current_address'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('current_address') }}</strong>
                            </span> @endif
                                </div>

                                <div class="col-sm-6{{ $errors->has('permanent_address') ? ' has-error' : '' }}">
                                    <label>Permanent Address</label>
                                    {!! Form::textarea('permanent_address', null, ['class' => 'form-control', 'rows' => '4', 'cols' => '50']) !!} @if ($errors->has('permanent_address'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('permanent_address') }}</strong>
                            </span> @endif
                                </div>

                            </div>
                            <!-- end form-group -->

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">

                                <div class="col-sm-6{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                    <label>Landline</label>
                                    {!! Form::text('phone_number', null, ['class' => 'form-control', "data-inputmask" => "'mask': '9999-999'", 'data-mask']) !!} @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                                </span> @endif
                                </div>

                                <div class="col-sm-6{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
                                    <label>Mobile Number</label>
                                    {{-- {!! Form::text('mobile_number', null, ['class' => 'form-control', "data-inputmask" => "'mask': '+639999999999'", 'data-mask']) !!} --}} {!! Form::text('mobile_number', null, ['class' => 'form-control']) !!} @if ($errors->has('mobile_number'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('mobile_number') }}</strong>
                                </span> @endif
                                </div>
                            </div>

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">

                                <div class="col-sm-4{{ $errors->has('contact_person') ? ' has-error' : '' }}">
                                    <label>Contact Person</label>
                                    {!! Form::text('contact_person', null, ['class' => 'form-control']) !!} @if ($errors->has('contact_person'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('contact_person') }}</strong>
                                  </span> @endif
                                </div>

                                <div class="col-sm-4{{ $errors->has('contact_relation') ? ' has-error' : '' }}">
                                    <label>Contact Relation</label>
                                    {!! Form::text('contact_relation', null, ['class' => 'form-control']) !!} @if ($errors->has('contact_relation'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('contact_relation') }}</strong>
                                  </span> @endif
                                </div>

                                <div class="col-sm-4{{ $errors->has('contact_number') ? ' has-error' : '' }}">
                                    <label>Contact Number</label>
                                    {{-- {!! Form::text('contact_number', null, ['class' => 'form-control', "data-inputmask" => "'mask': '+639999999999'", 'data-mask']) !!} --}} {!! Form::text('contact_number', null, ['class' => 'form-control']) !!} @if ($errors->has('contact_number'))
                                    <span class="help-block">
                                  <strong>{{ $errors->first('contact_number') }}</strong>
                                  </span> @endif
                                </div>

                            </div>

                            <div class="form-group" style="padding-left: 45px; padding-right: 45px;">
                              <label>HMO Dependents (By hierarchy *For Single - Mother, Father, Child *For Married - Spouse, Child)</label>

                              <div class="table-responsive">
                                  <table class="table table-hover" id="tab_assign_head">
                                      <thead>
                                          <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th class="text-center">
                                                Name
                                            </th>
                                            <th class="text-center">
                                                Gender
                                            </th>
                                            <th class="text-center">
                                                Date of birth
                                            </th>
                                            <th class="text-center">
                                                Relationship
                                            </th>
                                          </tr>
                                      </thead>
                                      <tfoot>
                                          <tr>
                                              <td colspan="5">
                                                  <a id="add_dependent_head_row" class="btn btn-sm  btn-fill  pull-left"><i class="ion-plus"></i> Add Row</a>
                                                  <a id='delete_dependent_head_row' class="pull-right btn btn-fill  btn-sm "><i class="ion-minus"></i> Delete Row</a>
                                              </td>
                                          </tr>
                                      </tfoot>
                                      <tbody id="dependent-tbody">
                                         @if(count($employee->dependents) > 0) 
                                          @foreach($employee->dependents as $key => $dependent)
                                          <tr id='dependent-headr{{$key}}'>
                                              <td align="center" width="5%">
                                                  <input type="hidden" name="dependent[{{$key}}][id]" value="{{$dependent->id}}"> {{ Form::checkbox('dependent['.$key.'][delete]',null,null, array('id'=>'dependent-headr-check-'.$dependent->id,'id'=>$key,'class'=>'delete-dependent-checkbox')) }}
                                                  <span>Delete</span>
                                              </td>

                                              <td class="{{ $errors->has('dependent_name[]') ? ' has-error' : '' }}" width="20%">
                                                {!! Form::text('dependent['.$key.'][dependent_name]', $dependent->dependent_name, ['class' => 'form-control']) !!}
                                                @if ($errors->has('dependent_name'))
                                                  <span class="help-block">
                                                    <strong>{{ $errors->first('dependent_name[]') }}</strong>
                                                  </span> 
                                                @endif
                                              </td>
                                              <td class="{{ $errors->has('dependent_gender[]') ? ' has-error' : '' }}" width="20%">
                                                {{ Form::select('dependent['.$key.'][dependent_gender]', array('MALE'=>'MALE','FEMALE'=>'FEMALE'), $dependent->dependent_gender, array('class'=>'chosen-select','id'=>'dependent_gender_' . $key,'placeholder'=>'--Select Gender--')) }}
                                                @if ($errors->has('dependent_gender'))
                                                  <span class="help-block">
                                                    <strong>{{ $errors->first('dependent_gender[]') }}</strong>
                                                  </span> 
                                                @endif
                                              </td>
                                              
                                              <td class="{{ $errors->has('bdate[]') ? ' has-error' : '' }}" width="20%">
                                                {!! Form::input('date', 'dependent['.$key.'][bdate]',  $dependent->bdate->format('Y-m-d'), ['class' => 'form-control']) !!}
                                                @if ($errors->has('bdate'))
                                                  <span class="help-block">
                                                    <strong>{{ $errors->first('bdate[]') }}</strong>
                                                  </span> 
                                                @endif
                                              </td>
                                              
                                              <td class="{{ $errors->has('relation[]') ? ' has-error' : '' }}" width="20%">
                                                {!! Form::text('dependent['.$key.'][relation]', $dependent->relation, ['class' => 'form-control']) !!}
                                                @if ($errors->has('relation'))
                                                  <span class="help-block">
                                                    <strong>{{ $errors->first('relation[]') }}</strong>
                                                  </span> 
                                                @endif
                                              </td>
                                          </tr>
                                          @endforeach 
                                        @else
                                          <tr id='dependent-headr0'>
                                              <td width="5%" align="center" >1</td>
                                              <td width="20%">
                                                {!! Form::text('dependent[0][dependent_name]', null, ['class' => 'form-control']) !!}
                                              </td>
                                              <td width="20%">
                                                {{ Form::select('dependent[0][dependent_gender]', array('MALE'=>'MALE','FEMALE'=>'FEMALE'), null, array('class'=>'chosen-select','id'=>'dependent_gender_0','placeholder'=>'--Select Gender--')) }}
                                              </td>
                                              
                                              <td width="20%">
                                                {!! Form::input('date', 'dependent[0][bdate]',  'mm/dd/yyyy', ['class' => 'form-control']) !!}
                                              </td>
                                              
                                              <td width="20%">
                                                {!! Form::text('dependent[0][relation]', null, ['class' => 'form-control']) !!}
                                              </td>
                                          </tr>
                                        @endif
                                      </tbody>
                                  </table>
                              </div>
                          </div>

{{-- 
                            <div class="form-group" style="padding-left: 45px; padding-right: 45px;">
                                <label>HMO Dependents (By hierarchy *For Single - Mother, Father, Child *For Married - Spouse, Child)</label>

                                <div class="table-responsive">
                                    <table class="table table-hover" id="tab_logic">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th class="text-center">
                                                    Name
                                                </th>
                                                <th class="text-center">
                                                    Gender
                                                </th>
                                                <th class="text-center">
                                                    Date of birth
                                                </th>
                                                <th class="text-center">
                                                    Relationship
                                                </th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <a id="add_row" class="btn btn-sm  btn-fill  pull-left"><i class="ion-plus"></i> Add Row</a>
                                                    <a id='delete_row' class="pull-right btn btn-fill  btn-sm "><i class="ion-minus"></i> Delete Row</a>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            @foreach($employee->dependents as $dependent)
                                            <tr id='addr0'>
                                                <td>
                                                    <i class="pe-7s-check" style="font-size: 20px;"></i>
                                                </td>

                                                <td class="{{ $errors->has('dependent_name[]') ? ' has-error' : '' }}">
                                                    <span class="form-control">
                                                      {{$dependent->dependent_name}}
                                                    </span>
                                                </td>

                                                <td class="{{ $errors->has('dependent_gender[]') ? ' has-error' : '' }}">
                                                    <span class="form-control">
                                                      {{$dependent->dependent_gender}}
                                                    </span>
                                                </td>

                                                <td class="{{ $errors->has('bdate[]') ? ' has-error' : '' }}">
                                                    <span class="form-control">
                                                      {{ date('F d, Y', strtotime($dependent->bdate)) }}
                                                    </span>
                                                </td>

                                                <td class="{{ $errors->has('relation[]') ? ' has-error' : '' }}">
                                                    <span class="form-control">
                                                        {{$dependent->relation}}
                                                    </span>
                                                </td>

                                            </tr>
                                            @endforeach

                                            <tr id='addr0'>
                                                <td>
                                                    1
                                                </td>

                                                <td class="{{ $errors->has('dependent_name[]') ? ' has-error' : '' }}">
                                                    <input type="text" name='dependent_name[]' placeholder='Name' class="form-control" id='name_0' />

                                                </td>

                                                <td class="{{ $errors->has('dependent_gender[]') ? ' has-error' : '' }}">
                                                    <input type="text" name='dependent_gender[]' placeholder='Gender' class="form-control" id='dependent_gender_0' />
                                                </td>

                                                <td class="{{ $errors->has('bdate[]') ? ' has-error' : '' }}">
                                                    <input type="date" name='bdate[]' class="form-control" id='bdate_0' />
                                                </td>

                                                <td class="{{ $errors->has('relation[]') ? ' has-error' : '' }}">
                                                    <input type="text" name='relation[]' placeholder='Relationship' class="form-control" id='relation_0' />
                                                </td>

                                            </tr>
                                            <tr id='addr1'></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}

                        </div>
                    </div>
                    <!-- end third part -->

                    <div class="tab-pane" id="description">
                        <div class="row">
                            <h5 class="info-text"> Government Indentification Details </h5>

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">

                                <div class="col-sm-4{{ $errors->has('sss_number') ? ' has-error' : '' }}">
                                    <label>SSS </label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff') ) {!! Form::text('sss_number', null, ['class' => 'form-control', "data-inputmask" => "'mask': '99-9999999-9'", 'data-mask']) !!} @else {!! Form::text('sss_number', null, ['class' => 'form-control', "data-inputmask" => "'mask': '99-9999999-9'", 'data-mask', 'disabled']) !!} @endif @if ($errors->has('sss_number'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('sss_number') }}</strong>
                                    </span> @endif
                                </div>

                                <div class="col-sm-4{{ $errors->has('hdmf') ? ' has-error' : '' }}">
                                    <label>HDMF </label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff')) {!! Form::text('hdmf', null, ['class' => 'form-control', "data-inputmask" => "'mask': '9999-9999-9999'", 'data-mask']) !!} @else {!! Form::text('hdmf', null, ['class' => 'form-control', "data-inputmask" => "'mask': '9999-9999-9999'", 'data-mask','disabled']) !!} @endif @if ($errors->has('hdmf'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('hdmf') }}</strong>
                                    </span> @endif
                                </div>

                                <div class="col-sm-4{{ $errors->has('phil_number') ? ' has-error' : '' }}">
                                    <label>Philhealth </label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff')) {!! Form::text('phil_number', null, ['class' => 'form-control', "data-inputmask" => "'mask': '9999-9999-9999'", 'data-mask']) !!} @else {!! Form::text('phil_number', null, ['class' => 'form-control', "data-inputmask" => "'mask': '9999-9999-9999'", 'data-mask', 'disabled']) !!} @endif @if ($errors->has('phil_number'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('phil_number') }}</strong>
                                    </span> @endif
                                </div>

                            </div>
                            <!-- end form-group -->

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">

                                <div class="col-sm-4{{ $errors->has('tax_number') ? ' has-error' : '' }}">
                                    <label>TIN</label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff')) {!! Form::text('tax_number', null, ['class' => 'form-control', "data-inputmask" => "'mask': '999-999-999'", 'data-mask']) !!} @else {!! Form::text('tax_number', null, ['class' => 'form-control', "data-inputmask" => "'mask': '999-999-999'", 'data-mask','disabled']) !!} @endif @if ($errors->has('tax_number'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('tax_number') }}</strong>
                                    </span> @endif
                                </div>

                                <div class="col-sm-4{{ $errors->has('tax_status') ? ' has-error' : '' }}">
                                    <label>Tax status</label>
                                    @if (Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff')) {{ Form::select('tax_status', array( 'S' => 'S', 'S1' => 'S1', 'S2' => 'S2', 'S3' => 'S3', 'S4' => 'S4', 'M' => 'M', 'M1' => 'M1', 'M2' => 'M2', 'M3' => 'M3', 'M4' => 'M4'), null, array('placeholder' => ' --- Select Tax Status ---', 'class'=>'form-control','required')) }} @else {{ Form::select('tax_status', array( 'S' => 'S', 'S1' => 'S1', 'S2' => 'S2', 'S3' => 'S3', 'S4' => 'S4', 'M' => 'M', 'M1' => 'M1', 'M2' => 'M2', 'M3' => 'M3', 'M4' => 'M4'), null, array('placeholder' => ' --- Select Tax Status ---', 'class'=>'form-control', 'disabled' )) }} @endif @if ($errors->has('tax_status'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('tax_status') }}</strong>
                                      </span> @endif
                                </div>

                            </div>
                            <!-- end form-group -->

                            <div class="form-group" style="padding-left: 30px; padding-right: 30px;">

                                @if(str_contains(Request::path(), 'edit'))
                                <div class="col-sm-12{{ $errors->has('id_remarks') ? ' has-error' : '' }}">
                                    <label>Remarks</label>
                                    {!! Form::textarea('id_remarks', null, ['class' => 'form-control', 'rows' => '3', 'cols' => '50']) !!}
                                    <span class="help-block">Indicate info/data to be updated (ex. SSS - 30-74125896 to 33-98521478-3)</span> @if ($errors->has('id_remarks'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('id_remarks') }}</strong>
                                    </span> @endif
                                </div>
                                @endif

                            </div>
                            <!-- end form-group -->

                            <div class="col-md-12">
                                <div class="alert alert-dismissible alert-warning terms-condition">
                                    <p>Terms and Conditions</p>
                                    <label class="checkbox" for="checkbox1" style="float: none; display: inline-block; vertical-align: middle;">
                                        <input type="checkbox" id="checkme" data-toggle="checkbox">
                                    </label>
                                    <strong>    
                                    I certify that the information provided is true and correct to the best of my knowledge.
                                    </strong>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- end fourth part -->

                </div>
                <div class="wizard-footer">
                    <div class="pull-right">
                        <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' value='Next' />
                        <input type="button" class="btn btn-finish btn-fill btn-success btn-wd inputButton" name="sendNewSms" value="Finish" disabled="disabled" id="sendNewSms" data-toggle="modal" data-target="#myModal">
                    </div>

                    <div class="pull-left">
                        <input type='button' class='btn btn-previous btn-default btn-wd' name='previous' value='Previous' />
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- wizard container -->
    </div>
</div>
<!-- row -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="margin-top: 100px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirm Changes</h4>
            </div>
            <div class="modal-body text-center">
                <p>
                    Are you sure you want to save changes?
                </p>
            </div>
            <div class="modal-footer">
                <div class="left-side">
                    <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Cancel</button>
                </div>
                <div class="divider"></div>
                <div class="right-side">
                    {!! Form::submit($submitButtonText, ['class' => 'btn btn-danger btn-simple']) !!}
                </div>

            </div>
        </div>
    </div>
</div>

@if(Request::is('employees/*/edit')) @if (Entrust::hasRole('User') && $employee->bank_account_verified == 0 && !empty($employee->bank_account_number))
<div class="modal fade" id="verifyAccountNumber" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="margin-top: 100px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Verify your bank account number</h4>
            </div>
            <div class="modal-body">
                <span style="font-size:18px;">Bank name: {{$employee->bank_name}}</span>
                <div id="my-tab-content" class="tab-content text-center">
                    <div class="tab-pane active" id="home">
                        <div class="form-group{{ $errors->has('verify_bank_account_number') ? ' has-error' : '' }}">
                            <div class="input-group">
                                {!! Form::number('verify_bank_account_number', null, ['id'=>'verify-bank-account-number','min'=>'0','maxlength'=>'25','class' => 'form-control','placeholder' => 'Enter your account number','autocomplete'=>'off']) !!} @if ($errors->has('verify_bank_account_number'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('verify_bank_account_number') }}</strong>
                                  </span> @endif
                                <span class="input-group-btn">
                                    <button class="btn btn-fill btn-success btn-submit" id="btn-verify-account-number">Verify</button>
                                  </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif @endif @section('marital_attachment')
<script>
    $('#maritalStatus').on('change', function() {
        if (this.value == "Married" || this.value == "Divorced") {
            $("#marital_status_attachment").prop('disabled', false);
        } else {
            $("#marital_status_attachment").prop('disabled', true);
        }
    });
</script>
@endsection @section('verify_bank_account')
<script>
    $(window).on('load', function() {
        $('#verifyAccountNumber').modal('show');

        $('#btn-verify-account').click(function(e) {
            e.preventDefault();
            $('#verifyAccountNumber').modal('show');
        });
        $('#btn-verify-account-number').click(function(e) {
            e.preventDefault();

            var account_number = "{!!$employee->bank_account_number!!}";
            var account_number = "{!!$employee->bank_account_number!!}";
            var inputted_account_number = $('#verify-bank-account-number').val();

            if (inputted_account_number) {
                if (account_number == inputted_account_number) {
                    $.ajax({
                            method: "POST",
                            url: "/verify-account-number/" + "{!! $employee->id !!}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                bank_account_verified: "1"
                            }
                        })
                        .done(function(msg) {
                            $('#verifyAccountNumber').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Bank Account Verified',
                                html: 'Your bank account has been successfully verified.',
                                showConfirmButton: true,
                                onClose: () => {
                                    location.reload();
                                }
                            });
                        });

                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please try Again',
                        html: 'Your account number: <span style="color:red;font-weight: 600;">' + inputted_account_number + '</span> <br> doesn' + "'" + 't match our record. ',
                        showConfirmButton: true,
                    });
                }
            } else {
                alert('Please input account number to proceed.');
            }
        });
    });
</script>
@endsection @section('assigned_head_list')
<script>
    $(document).ready(function() {

        $('.chosen-select').chosen();

        var employees = JSON.parse('@if (Entrust::hasRole("Administrator") || Entrust::hasRole("HR Staff")) {!! $employees !!} @else [] @endif');
        var name_options = '<option value="--Select Name--">--Select Name--</option>';
        $.each(employees, function(index, value) {
            name_options += '<option value="' + index + '">' + value + '<option>';
        });

        var head_positions = JSON.parse('@if (Entrust::hasRole("Administrator") || Entrust::hasRole("HR Staff")) {!! $head_positions !!} @else [] @endif');
        var position_options = '<option value="--Select Position--">--Select Position--</option>';
        $.each(head_positions, function(index, value) {
            position_options += '<option value="' + index + '">' + value + '<option>';
        });

        $("#add_head_row").click(function() {
            var hdr = $('#assign-tbody tr').last().attr('id');
            if (hdr) {
                var hdr = hdr.replace("headr", "");
                hdr++;
            } else {
                var hdr = 0;
            }

            $('#assign-tbody').append(
                "<tr id=headr" + hdr + "><td align='center'>" + (hdr + 1) + "</td><td width='50%'><select class='chosen-select' id='head_name_" + hdr + "' name='assign_head[" + hdr + "][head_name]'>" + name_options + "<select></td><td width='50%'> <select class='chosen-select' id='head_position_" + hdr + "' name='assign_head[" + hdr + "][head_position]'>" + position_options + "<select> </td></tr>"
            );
            $('.chosen-select').chosen();
        });

        $("#delete_head_row").click(function() {
            var hdr = $('#assign-tbody tr').last().attr('id');
            var hdr = hdr.replace("headr", "");
            if (hdr > 0) {
                $("#headr" + hdr).remove();
            }

        });

        $('.delete-checkbox').change(function() {
            var id = $(this).attr('id')
            if (this.checked) {
                $("#headr" + id).css("background-color", "#FF4D4D");
            } else {
                $("#headr" + id).css("background-color", "#FFFFFF");

            }
        });

        var employee_signature = document.getElementById("employee_signature");

        employee_signature.addEventListener("change", function(event) {
            var files = employee_signature.files;
        }, false);

        var employee_image = document.getElementById("employee_image");

        employee_image.addEventListener("change", function(event) {
            var files = employee_image.files;
        }, false);

    });
</script>
@endsection @section('dependent_list')
<script>

    $(document).ready(function() {
        $('.chosen-select').chosen();

        $("#add_dependent_head_row").click(function() {
            var dependent_hdr = $('#dependent-tbody tr').last().attr('id');
            if (dependent_hdr) {
                var dependent_hdr = dependent_hdr.replace("dependent-headr", "");
                dependent_hdr++;
            } else {
                var dependent_hdr = 0;
            }
            $('#dependent-tbody').append(
                '<tr id="dependent-headr'+dependent_hdr+'"><td width="5%" align="center">'+(dependent_hdr + 1)+'</td><td width="20%"><input class="form-control" name="dependent['+dependent_hdr+'][dependent_name]" type="text"></td><td width="20%"><select class="chosen-select" placeholder="--Select Gender--" id="dependent_gender_'+dependent_hdr+'" ="" name="dependent['+dependent_hdr+'][dependent_gender]" style="display: none;"><option selected="selected" disabled="disabled" hidden="hidden" value="">--Select Gender--</option><option value="MALE">MALE<option><option value="FEMALE">FEMALE<option></select></td><td width="20%"><input class="form-control" name="dependent['+dependent_hdr+'][bdate]" type="date" value="yyyy-MM-dd"></td><td width="20%"><input class="form-control" name="dependent['+dependent_hdr+'][relation]" type="text"></td></tr>'
            );
            $('.chosen-select').chosen();
        });

        $("#delete_dependent_head_row").click(function() {
            var dependent_hdr = $('#dependent-tbody tr').last().attr('id');
            var dependent_hdr = dependent_hdr.replace("dependent-headr", "");
            if (dependent_hdr > 0) {
                $("#dependent-headr" + dependent_hdr).remove();
            }
        });

        $('.delete-dependent-checkbox').change(function() {
            var id = $(this).attr('id')
            if (this.checked) {
                $("#dependent-headr" + id).css("background-color", "#FF4D4D");
            } else {
                $("#dependent-headr" + id).css("background-color", "#FFFFFF");

            }
        });

        $("#company").change(function () {
            var company_id = $(this).val();
            $('#division').empty();
            $.getJSON( "/get_division/" + company_id, function( data ) {
                if(Object.keys(data).length > 0){
                    $.each( data, function( key, val ) {
                        $('#division').append('<option id="'+key+'">'+ val +'</option>');
                    });    
                }else{
                    $('#division').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">****Select Division</option>');
                    
                }
               
            });                    
        });

    });
</script>
@endsection