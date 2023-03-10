@extends('admin-layout.template')

@section('admin-content')

<head>
    @livewireStyles
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4iFJnHvroAYC0f4zIwV+nUrKsXlL4WOgIcN4nK3Zg5T0UksdQRVvSvZe3tfukgM+" crossorigin="anonymous">

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Stock</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- /.col-md-6 -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0">File Upload</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Upload Stock CSV file</h6>
                        <br>

                        <form method="POST" action="/stock-upload" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input class="form-control" type="file" id="stockfile" name="stockfile">
                            </div>
                            <br>

                            <input class="btn btn-primary float-right" value="UPLOAD" type="submit">

                        </form>


                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Insert To Stock Database</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <livewire:searchbox />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="m-0">Export Stock Database</h5>
            </div>
            <div class="card-body">
                <h6 class="card-title">Download stock database as CSV file</h6>

                <form method="POST" action="/stock-export">
                    @csrf

                    <input class="btn btn-primary float-right" value="DOWNLOAD" type="submit">

                </form>
            </div>
        </div>

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="m-0">View Stock Database</h5>
            </div>
            <div class="card-body d-flex">
                <div>
                    <table id="tblData" class="table-bordered table-responsive text-center data-table">
                        <tr>
                            <th>No</th>
                            <th>Description of Goods</th>
                            <th>Qty</th>
                            <th>Barcode</th>
                            <th>Action</th>

                        </tr>

                        @foreach ($stock as $key => $data)

                        <tr>
                            <td class="tdno">
                                {{$data->no}}
                            </td>
                            <td class="tditem">
                                {{$data->description}}
                            </td>
                            <td class="tdqty">
                                {{$data->qty}}
                            </td>
                            <td class="tdbar">
                                {{$data->barcode}}

                            </td>

                            <td class="d-flex flex-fill">
                                <div class="p-1">
                                    <button class="p-1 btn btn-warning btn-sm showDiv btn-edit">Edit</button>
                                </div>

                                <div class="p-1">
                                    <button class="btn btn-danger btn-sm btn-delete">Delete</button>
                                </div>


                                <!--form class="p-1" method="post" action="{{ url('stockdestroy/'.$data->no) }}">
                                    @csrf
                                    <input type="submit" class="btn btn-danger btn-sm" value="Delete" />
                                </form-->


                            </td>

                        </tr>
                        @endforeach

                    </table>

                    {{ $stock->links() }}
                </div>
                <div class="m-3">


                </div>
            </div>
        </div>

    </div>
    <!-- /.col-md-6 -->
</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#tblData').on('click', '.btn-edit', function() {

            let item = $(this).parent().parent().parent().find(".tditem").html();
            item = item.replace(/^\s+|\s+$/g, '');
            $(this).parent().parent().parent().find(".tditem").html("<input type='text' value='" + item + "' class='form-control txtitem' placeholder='Enter Item'/>");

            const qty = $(this).parent().parent().parent().find(".tdqty").html();

            $(this).parent().parent().parent().find(".tdqty").html("<input type='number' value='" + parseInt(qty) + "' class='form-control txtqty' placeholder='Enter Qty'/>");


            let bar = $(this).parent().parent().parent().find(".tdbar").html();
            bar = bar.replace(/^\s+|\s+$/g, '');
            $(this).parent().parent().parent().find(".tdbar").html("<input type='text' value='" + bar + "' class='form-control txtbar' placeholder='Enter Barcode'/>");

            $(this).parent().parent().html("<button  class='w-100 p-1 btn btn-success btn-sm showDiv btn-update' >Update</button>");
        });
        $('#tblData').on('click', '.btn-delete', function() {

            const num = parseInt($(this).parent().parent().parent().find(".tdno").html());
            let item = $(this).parent().parent().parent().find(".tditem").html();
            item = item.replace(/^\s+|\s+$/g, '');
            const qty = parseInt($(this).parent().parent().parent().find(".tdqty").html());
            let bar = $(this).parent().parent().parent().find(".tdbar").html();
            bar = bar.replace(/^\s+|\s+$/g, '');
          //  $(this).parent().parent().remove();
            $.ajax({
                url: "{{ route('ajaxdelete') }}",
                method: 'Post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    inno: num,
                    instock: item,
                    inbarcode: bar,
                    inqty: qty
                },
                success: function(res) {
                    if (res.status == 'success') {
                       
                        $('.data-table').load(location.href + ' .data-table');


                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                    console.log('Response:', xhr.responseText);
                }
            })




        });

        $('#tblData').on('click', '.btn-update', function() {

            const num = $(this).parent().parent().find(".tdno").html();

            let item = $(this).parent().parent().parent().find(".txtitem").val();
            item = item.replace(/^\s+|\s+$/g, '');
            //$(this).parent().parent().parent().find(".tditem").html("" + item + "");

            const qty = $(this).parent().parent().parent().find(".txtqty").val();
            //$(this).parent().parent().parent().find(".tdqty").html("" + parseInt(qty) + "");


            let bar = $(this).parent().parent().parent().find(".txtbar").val();
            bar = bar.replace(/^\s+|\s+$/g, '');
           // $(this).parent().parent().parent().find(".tdbar").html("" + bar + "");


          // $(this).parent().html("<td class='d-flex flex-fill'><div class='p-1'><button class='p-1 btn btn-warning btn-sm showDiv btn-edit'>Edit</button></div><div class='p-1'><button class='btn btn-danger btn-sm btn-delete'>Delete</button></div></td>");
      
            $.ajax({
                url: "{{ route('ajaxedit') }}",
                method: 'Post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    inno: parseInt(num),
                    instock: item,
                    inbarcode: bar,
                    inqty: parseInt(qty)
                },
                success: function(res) {
                    if (res.status == 'success') {


                        $('.data-table').load(location.href + ' .data-table');


                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                    console.log('Response:', xhr.responseText);
                }
            })




        });




    });
</script>


@livewireScripts
@endsection