<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).ready(function() {

        //$('#inputform').off('submit').on('submit', function(event) 
        $('#inbarcode').off('input').on('input', function(event)
            {

                setTimeout(function() {



                    event.preventDefault();
                let instock = $('#instock').val();
                let inbarcode = $('#inbarcode').val();

                let inqty = $('#inqty').val();


                $.ajax({
                    url: "{{ route('ajaxinsert') }}",
                    method: 'Post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        instock: instock,
                        inbarcode: inbarcode,
                        inqty: inqty
                    },
                    success: function(res) {
                        if (res.status == 'success') {



                            // console.log("test");
                            //Command: toastr["success"]("Product added Successfully")
                            $('#inbarcode').val('');
                             $('#instock').val('');
                             $('#inqty').val('');
                            
                            $('.data-table').load(location.href + ' .data-table');


                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                        console.log('Response:', xhr.responseText);
                    }
                })


                }, 2000);


            })



    })
</script>