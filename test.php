<legend>Second Semester</legend>
<div class="row">
    <div class="col-sm-6">
        <label class="" for="exampleInputEmail3">Enrollment Start Date: &nbsp;</label>
        <div class="form-group">
            <select name="setting[second_semester_enrollment_start_date_m]" class="form-control">
                <option disabled value=""> - M - </option>
                @foreach (getMonths() as $key=>$value)
                <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_enrollment_start_date_m')) }}>{{ $key . '-' .$value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select name="setting[second_semester_enrollment_start_date_d]" class="form-control">
                <option disabled value=""> - D - </option>
                @foreach (getDays() as $key=>$value)
                <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_enrollment_start_date_m')) }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <label class="" for="exampleInputEmail3">Enrollment End Date: &nbsp;</label>
        <div class="form-group">
            <select name="setting[second_semester_enrollment_end_date_m]" class="form-control">
                <option disabled value=""> - M - </option>
                @foreach (getMonths() as $key=>$value)
                <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_enrollment_end_date_m')) }}>{{ $key . '-' .$value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select name="setting[second_semester_enrollment_end_date_d]" class="form-control">
                <option disabled value=""> - D - </option>
                @foreach (getDays() as $key=>$value)
                <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_enrollment_end_date_d')) }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <label class="" for="exampleInputEmail3">Enrollment Start Date: &nbsp;</label>
        <div class="form-group">
            <select name="setting[second_semester_semester__start_date_m]" class="form-control">
                <option disabled value=""> - M - </option>
                @foreach (getMonths() as $key=>$value)
                <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_semester__start_date_m')) }}>{{ $key . '-' .$value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select name="setting[second_semester_semester__start_date_d]" class="form-control">
                <option disabled value=""> - D - </option>
                @foreach (getDays() as $key=>$value)
                <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_semester__start_date_m')) }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <label class="" for="exampleInputEmail3">Semester Start Date: &nbsp;</label>
        <div class="form-group">
            <select name="setting[second_semester_semester__end_date_m]" class="form-control">
                <option disabled value=""> - M - </option>
                @foreach (getMonths() as $key=>$value)
                <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_semester__end_date_m')) }}>{{ $key . '-' .$value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select name="setting[second_semester_semester__end_date_d]" class="form-control">
                <option disabled value=""> - D - </option>
                @foreach (getDays() as $key=>$value)
                <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_semester__end_date_d')) }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>