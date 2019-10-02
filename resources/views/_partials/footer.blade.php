
        <!-- /#page-wrapper -->

    </div>
        <input type="hidden" value="{{URL::to('')}}" id="rootUrl">
    <!-- /#wrapper -->
  <!-- jQuery -->
    <script src="{{asset('public/backend/plugin/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('public/js/jquery-1.10.2.js')}}"></script>
    <script src="{{asset('public/ui/jquery-ui.js')}}"></script>


    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('public/backend/plugin/bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{asset('public/backend/plugin/metisMenu/metisMenu.min.js')}}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{asset('public/backend/plugin/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('public/js/validator.js')}}"></script>
    <script src="{{asset('public/js/sweetalert2.all.min.js')}}"></script>

    <!-- DataTables JavaScript -->
    <script src="{{asset('public/backend/plugin/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/backend/plugin/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('public/backend/plugin/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{asset('public/backend/js/chosen.jquery.js')}}"></script>
        <script src="{{ asset('public/backend/plugin/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{asset('public/backend/js/sb-admin-2.js')}}"></script>
    <script src="{{asset('public/js/tinymce/tinymce.min.js')}}"></script>

        <script src="{{asset('public/backend/js/custom.js')}}"></script>
        <script>
            $('#datepicker').datepicker();
            $('#datepicker').on('changeDate', function() {
                $('#my_hidden_input').val(
                    $('#datepicker').datepicker('getFormattedDate')

                );
            });

            function loadSubMenu(id){
                $('#loadSubmenuHere').load("{{URL::to('sub-menu-load')}}/"+id);
            }
            function confirmDelete(){
                return confirm("Do You Sure Want To Delete This Data ?");
            }
        </script>

    @if(Session::has('error'))
    <script type="text/javascript">
        swal({
          type: 'error',
          title: '{{Session::get("error")}}',
          showConfirmButton: true
        })
    </script>
    @endif
    <script type="text/javascript">
        function deleteConfirm(id){
            swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                $("#"+id).submit();
              }
            })
        }
        
    </script>

