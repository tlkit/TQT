<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="javascript:void(0)"> Bảng báo giá</a></li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST', 'role'=>'form','files' => true))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label>Nhập file báo giá</label>
                    <div class="clearfix"></div>
                    <label class="ace-file-input">
                        <input type="file" id="price_list" name="price_list">
{{--
                        <span data-title="Chọn file excel" class="ace-file-container"></span>
--}}
                    </label>
                </div>
                <div class="form-group col-sm-12 text-right">
                    <button  class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                </div>
                {{ Form::close() }}
                <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script type="text/javascript">

    $(document).ready(function(){
        $('#price_list').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Nhập file báo giá',
            btn_change:'Nhập file báo giá',
            droppable:false,
            onchange:null,
            thumbnail:false, //| true | large
            whitelist:'xls|xlsx|doc|docx|pdf',
            blacklist:'exe|php|rar'
            //onchange:''
            //
        });
    })
</script>
