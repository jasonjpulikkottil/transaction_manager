@extends('admin-layout.template')

@section('admin-content')

<head>  @livewireStyles</head>

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
                    <livewire:searchbox /></div>
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
                    <div class="card-body">

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
                                
                            </tr>
                            @endforeach

                        </table>

                    </div>
                </div>




            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

@livewireScripts
@endsection