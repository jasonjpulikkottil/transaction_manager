@extends('admin-layout.template')

@section('admin-content')

<head> 
    @livewireStyles
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4iFJnHvroAYC0f4zIwV+nUrKsXlL4WOgIcN4nK3Zg5T0UksdQRVvSvZe3tfukgM+" crossorigin="anonymous">


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
                <table class="table-bordered table-responsive text-center data-table">
                    <tr>
                        <th>No</th>
                        <th>Description of Goods</th>
                        <th>Qty</th>
                        <th>Barcode</th>

                    </tr>

                    @foreach ($stock as $key => $data)

                    <tr>
                        <td>
                            {{$data->no}}
                        </td>
                        <td>
                            {{$data->description}}
                        </td>
                        <td>
                            {{$data->qty}}
                        </td>
                        <td>
                            {{$data->barcode}}
                        </td>

                        <td  class="d-flex flex-fill">
                           
                            <button  class="p-1 btn btn-warning btn-sm showDiv" >Edit</button>
                            
                            <form  class="p-1"method="post" action="{{ url('stockdestroy/'.$data->no) }}">
                                @csrf
                                <input type="submit" class="btn btn-danger btn-sm" value="Delete" />
                            </form>
                           

                        </td>

                    </tr>
                    @endforeach

                </table>

                {{ $stock->links() }}
</div>
<div class="m-3">
    
<div class="card card-primary card-outline"  id="hiddenDiv"  style="display:none;">
            <div class="card-header">
                EDIT
            </div>
    <form method="post" id="inputform">
        @csrf
        <div class="row">
            <div class="col">
                <input type="text" name="inbarcode2" id="inbarcode2" class="form-control" placeholder="Barcode" value="">
            </div>
            <div class="col">
                <input type="text"  name="instock2" id="instock2" class="form-control" placeholder="Item" value="">
            </div>
            <div class="col">
                <input type="number" name="inqty2" id="inqty2" class="form-control" placeholder="Qty" value="">
            </div>
        </div>
        <br>
        <input class="btn btn-primary float-right" value="Save"  id="Save" type="submit">
    </form>

</div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.showDiv').click(function() {
            $('#hiddenDiv').toggle();
        });
    });
</script>



@livewireScripts
@endsection