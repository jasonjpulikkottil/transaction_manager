@extends('admin-layout.template')

@section('admin-content')


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Transaction History</h1>
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
                
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">View Transaction History</h5>
                    </div>
                    <div class="card-body">

                        <table class="table-bordered table-responsive text-center">
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Item</th>
                                <th>Qty of change</th>
                                <th>Change Info</th>
                                
                                
                            </tr>

                            @foreach ($trn as $key => $data)

                            <tr>
                                <td>
                                    {{$data->no}}
                                </td>
                                <td>
                                    {{$data->trans_date}}
                                </td>
                                <td>
                                    {{$data->trans_time}}
                                </td>
                                <td>
                                    {{$data->description}}
                                </td>

                                <td>
                                    {{$data->qty}}
                                </td>

                                <td>
                                    {{$data->info}}
                                </td>



                            </tr>
                            @endforeach

                        </table>
                        {{ $trn->links() }}
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