@extends('admin-layout.template')

@section('admin-content')


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sales Return</h1>
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
                        <h6 class="card-title">Upload Sales Return CSV file</h6>
                        <br>
                        
                        <form method="POST" action="/salesreturn-upload" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input class="form-control" type="file" id="salesreturnfile" name="salesreturnfile">
                            </div>
                            <br>

                            <input class="btn btn-primary float-right" value="UPLOAD" type="submit">

                        </form>


                    </div>
                </div>



            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection