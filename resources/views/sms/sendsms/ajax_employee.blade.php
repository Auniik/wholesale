<hr>
<div class="col-md-12">
    <table class="table table-bordered table-hover total-responsive">
        <thead>
        <tr>
            <th>Employee Id</th>
            <th>Employee Name</th>
            <th>Employee Email</th>
            <th>Employee Mobile</th>
            <th width="2%"><input type="checkbox" name="all" class="checkAll"> </th>
        </tr>
        </thead>
        <tbody>
        @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->user->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->phone }}</td>
                <td><input type="checkbox" class="employee-phones allcheck" value="{{ $employee->phone }}" name="check" > </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>