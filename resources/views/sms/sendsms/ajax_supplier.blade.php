<hr>
<div class="col-md-12">
    <table class="table table-bordered table-hover total-responsive">
        <thead>
        <tr>
            <th>Supplier Id</th>
            <th>Supplier Name</th>
            <th>Supplier Email</th>
            <th>Supplier Mobile</th>
            <th width="2%"><input type="checkbox" name="all" class="checkAll"> </th>
        </tr>
        </thead>
        <tbody>
        @foreach($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->supplier_id }}</td>
                <td>{{ $supplier->company_name }}</td>
                <td>{{ $supplier->email_id }}</td>
                <td>{{ $supplier->mobile_no }}</td>
                <td><input class="supplier-phones  allcheck" type="checkbox" name="check"  value="{{ $supplier->mobile_no }}"> </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>