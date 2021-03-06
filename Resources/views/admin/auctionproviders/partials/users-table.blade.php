<div class="box box-success">

    <div class="box-header with-border">
        <h3 class="box-title text-uppercase ">
            <strong>{{trans('iauctions::auctionproviders.table.providers')}}</strong>
        </h3>
    
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    
    </div>

    <div class="box-body">
        <br>
        <div class="table-responsive">
                <table id="tableUsers" class="data-table table table-bordered table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{trans('iauctions::auctionproviders.table.fullname')}}</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($auction->auctionproviders as $auctionprovider)
                        <tr>
                            <td>{{$auctionprovider->provider->id}}</td>
                            <td>{{$auctionprovider->provider->present()->fullname}}</td>
                            <td>{{$auctionprovider->provider->email}}</td>
                            <td>
                            <span class="badge {{$auctionprovider->present()->statusLabelClass}}">{{$auctionprovider->present()->status}}</span>
                               
                            </td>         
                            <td>
                                <div class="btn-group">
                                    <button title="{{trans('iauctions::auctionproviders.title.status and products')}}" onclick="editStatus({{$auctionprovider->id}},{{$auctionprovider->status}})" type="button" class="btn btn-sm btn-info btn-flat">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>{{trans('iauctions::auctionproviders.table.fullname')}}</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>{{ trans('core::core.table.actions') }}</th>
                    </tr>
                    </tfoot>
                </table>
                <!-- /.box-body -->
        </div>
    </div>

</div>

@include('core::partials.delete-modal')

@push('js-stack')

<?php $locale = locale(); ?>

<script type="text/javascript">

    $(function(){ 

        var tableUser = $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
        });

    });

    function editStatus(auctionproviderID,auctionproviderStatus){
        
        auctionprovider_id_update=auctionproviderID;

        $.ajax({
            url:"{{url('/')}}"+"/api/iauctions/auctions/providers/"+auctionproviderID+"?include=products",
            type:'GET',
            headers:{'X-CSRF-TOKEN': "{{csrf_token()}}"},
            dataType:"json",
            success:function(result){
                
                $("#tProductsProvider tr").remove();

                $("#statusAuctionProvider option[value="+auctionproviderStatus+"]").attr('selected', 'selected');
                
               var products = result.data.products;
               for (var i=0; i < products.length; i++){
                   var newRow = $("<tr>");
                   var cols = "";

                   cols += '<td>'+products[i].id+'</td>';
                   cols += '<td>'+products[i].name+'</td>';

                   newRow.append(cols);
                   $("#tProductsProvider").append(newRow);
                }
                products.forEach(function(product, index) {

                });
               
                $('#modal-update-status').modal();
            },
            error:function(error){
                console.log("ERROR AJAX SEARCH STATUS PRODUCTS: "+error);
            }
        });//ajax

    }

    function updateStatus(auctionproviderID){

        var new_status = $('#statusAuctionProvider').val();

        $.ajax({
            url:"{{url('/')}}"+"/api/iauctions/auctionproviders/"+auctionproviderID,
            type:'POST',
            headers:{'X-CSRF-TOKEN': "{{csrf_token()}}"},
            dataType:"json",
            data:{attributes:{status:new_status}},
            beforeSend: function(){ 
                $("#btnUpdate").addClass("disabled");
            },
            success:function(result){
                if(result.success){
                    $('#statusAuctionProvider').val("");
                    $('#modal-update-status').modal("hide");
                    location.reload(true);
                }else{
                    console.log('Error, update status auctionprovider: '+result.msg);
                }
                $("#btnUpdate").removeClass("disabled");
            },
            error:function(error){
                $("#btnUpdate").removeClass("disabled");
                console.log("ERROR AJAX UPDATE STATUS: "+error);
            }
        });//ajax
       
    }

</script>


@endpush