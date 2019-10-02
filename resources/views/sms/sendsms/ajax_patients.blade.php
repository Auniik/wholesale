<hr>
<div class="col-md-12">
    <table class="table table-bordered table-hover total-responsive">
        <thead>
        <tr>
            <th>Patient Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th width="2%"><input type="checkbox" name="all" class="checkAll"> </th>
        </tr>
        </thead>
        <tbody>
        @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->patient_id }}</td>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->mobile_number }}</td>
                <td>
                    <input type="checkbox" class="patient-phones allcheck" value="{{ $patient->mobile_number ?? '' }}" name="check" >
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>