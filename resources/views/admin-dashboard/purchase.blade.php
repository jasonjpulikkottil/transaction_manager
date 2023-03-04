@extends('admin-layout.template')

@section('admin-content')
<head>  @livewireStyles</head>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Purchase</h1>
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
                        <h6 class="card-title">Upload Purchase CSV file</h6>
                        <br>
                        
                        <form method="POST" action="/purchase-upload" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input class="form-control" type="file" id="purchasefile" name="purchasefile">
                            </div>
                            <br>

                            <input class="btn btn-primary float-right" value="UPLOAD" type="submit">

                        </form>

                    </div>

                    <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Insert Purchase</h5>
                    </div>
                    <div class="card-body">
                    <livewire:searchbox />
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
@livewireScripts

@endsection