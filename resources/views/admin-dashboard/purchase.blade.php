@extends('admin-layout.template')

@section('admin-content')

<head> @livewireStyles


    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

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

                

<!-- NEW -->
 <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Uploaded Items</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="tblData" class="table table-bordered data-table">
                                <tr>
                                    <th>No</th>
                                    <th>Description of Goods</th>
                                    <th>Qty</th>
                                </tr>

                                @foreach ($purchase as $key => $data)

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



                                </tr>
                                @endforeach

                            </table>

                            {{ $purchase->links() }}
              </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->

            
          </div>
          <!-- /.col -->
		  
		  <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Incorrectly Picked Items </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="tblmis" class="table table-bordered check-table">
                                <tr>
                                    <th>No</th>
                                    <th>Description of Goods</th>
                                    <th>Extra Qty</th>

                                </tr>

                                @foreach ($purchasemismatch as $key2 => $data2)

                                <tr>
                                    <td class="tdno">
                                        {{$data2->no}}
                                    </td>
                                    <td class="tditem">
                                        {{$data2->description}}
                                    </td>
                                    <td class="tdqty">
                                        {{$data2->qty}}
                                    </td>



                                </tr>
                                @endforeach

                            </table>
              </div>
              <!-- /.card-body -->
              
              <!-- /.card-body -->

            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
         
		  <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Scanned Items</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="tblmis" class="table table-bordered scan-table">
    <tr>
        <th>No</th>
        <th>Description of Goods</th>
        <th>Qty</th>

    </tr>

    @foreach ($scanneditems as $key3 => $data3)

    <tr  style="background-color:  {{$data3->color}};">
        <td class="tdno">
            {{$data3->no}}
        </td>
        <td class="tditem">
            {{$data3->description}}
        </td>
        <td class="tdqty">
            {{$data3->qty}}
        </td>

    </tr>
    @endforeach

</table>
              </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
     
   
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<!-- NEW -->

</div>







                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Check</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" id="checkform">

                            <div class="row">
                                <div class="col">
                                    <input type="text" name="scanbarcode" id="scanbarcode" class="form-control" placeholder="Barcode">
                                </div>
                            </div>
                            <br>
                            <!--input class="btn btn-primary float-right" value="INSERT"  id="INSERT" type="submit"-->
                        </form>
                    </div>
                </div>
            </div>


        </div>
        <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).ready(function() {

        $('#scanbarcode').off('input').on('input', function(event)

            {

                setTimeout(function() {



                    event.preventDefault();
                    let inbarcode = $('#scanbarcode').val();


                    $.ajax({
                        url: "{{ route('ajaxcheck') }}",
                        method: 'Post',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            inbarcode: inbarcode
                        },
                        success: function(res) {
                            if (res.status == 'success') {



                                $('#scanbarcode').val('');
                                $('.data-table').load(location.href + ' .data-table');
                                $('.check-table').load(location.href + ' .check-table');
                                $('.scan-table').load(location.href + ' .scan-table');


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





<!-- /.content -->
@livewireScripts

@endsection