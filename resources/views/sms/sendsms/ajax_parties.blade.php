<hr>
<div class="col-md-12">
    <table class="table table-bordered table-hover total-responsive">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th width="2%"><input type="checkbox" name="all" class="checkAll"> </th>
        </tr>
        </thead>
        <tbody>
        @foreach($parties as $party)
            <tr>
                <td>{{ $party->id }}</td>
                <td>{{ $party->name }}</td>
                <td>{{ $party->email }}</td>
                <td>{{ $party->mobile_number }}</td>
                <td>
                    <input class="party-phones allcheck" type="checkbox" name="check"value="{{ $party->mobile_number }}">
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>