<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tạo nhóm quyền
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{URL::route('admin.groupUser_view')}}"><i class="fa fa-group"></i> Danh sách nhóm quyền</a></li>
        <li class="active">Tạo nhóm quyền</li>
    </ol>
</section>
<section class="content">
    {{ Form::open(array('class'=>'form-horizontal','id'=>'permission','files' => true,'method' => 'POST')) }}
    @if(isset($error))
        <div class="alert alert-danger" role="alert">
            @foreach($error as $er)
                <p>{{$er}}</p>
            @endforeach
        </div>
    @endif
    <div class="box box-info">
        <div class="box-header">
            {{--<h3 class="box-title">Nhập thông tin nhóm</h3>--}}
        </div>
        <div class="box-body">
            <div class="col-sm-2">
                <div class="form-group">
                    <i>Mã nhóm</i>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="group_user_name"
                           value="@if(isset($data['group_user_name'])){{$data['group_user_name']}}@endif">
                </div>
            </div>
            <div class="clearfix"></div>

            <div valign="top" class="col-sm-2">
                <div class="form-group">
                    <i>Danh sách quyền</i>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="widget-box widget-color-blue2">
                    <div class="widget-header">
                        <h4 class="widget-title lighter smaller">Choose Categories</h4>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-8">
                            <ul id="tree1" class="tree tree-selectable" role="tree"><li aria-expanded="false" role="treeitem" data-template="treebranch" class="tree-branch hide">				<div class="tree-branch-header">					<span class="tree-branch-name">						<i class="icon-folder ace-icon tree-plus"></i>						<span class="tree-label"></span>					</span>				</div>				<ul role="group" class="tree-branch-children"></ul>				<div role="alert" class="tree-loader hide"><div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div></div>						</li><li role="treeitem" data-template="treeitem" class="tree-item hide">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-times"></i>				  <span class="tree-label"></span>				</span>			</li><li aria-expanded="true" role="treeitem" class="tree-branch tree-open">				<div class="tree-branch-header">					<span class="tree-branch-name">						<i class="icon-folder ace-icon tree-minus"></i>						<span class="tree-label">For Sale</span>					</span>				</div>				<ul role="group" class="tree-branch-children"><li role="treeitem" class="tree-item tree-selected">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-check"></i>				  <span class="tree-label">Appliances</span>				</span>			</li><li role="treeitem" class="tree-item tree-selected">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-check"></i>				  <span class="tree-label">Arts &amp; Crafts</span>				</span>			</li><li role="treeitem" class="tree-item tree-selected">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-check"></i>				  <span class="tree-label">Clothing</span>				</span>			</li><li role="treeitem" class="tree-item tree-selected">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-check"></i>				  <span class="tree-label">Computers</span>				</span>			</li><li role="treeitem" class="tree-item tree-selected">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-check"></i>				  <span class="tree-label">Jewelry</span>				</span>			</li><li role="treeitem" class="tree-item tree-selected">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-check"></i>				  <span class="tree-label">Office &amp; Business</span>				</span>			</li><li role="treeitem" class="tree-item tree-selected">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-check"></i>				  <span class="tree-label">Sports &amp; Fitness</span>				</span>			</li></ul>				<div role="alert" class="tree-loader hide"><div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div></div>						</li><li aria-expanded="true" role="treeitem" class="tree-branch tree-open">				<div class="tree-branch-header">					<span class="tree-branch-name">						<i class="icon-folder ace-icon tree-minus"></i>						<span class="tree-label">Vehicles</span>					</span>				</div>				<ul role="group" class="tree-branch-children"><li aria-expanded="false" role="treeitem" class="tree-branch">				<div class="tree-branch-header">					<span class="tree-branch-name">						<i class="icon-folder ace-icon tree-plus"></i>						<span class="tree-label">Cars</span>					</span>				</div>				<ul role="group" class="tree-branch-children"></ul>				<div role="alert" class="tree-loader hide"><div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div></div>						</li><li role="treeitem" class="tree-item">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-times"></i>				  <span class="tree-label">Motorcycles</span>				</span>			</li><li role="treeitem" class="tree-item">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-times"></i>				  <span class="tree-label">Boats</span>				</span>			</li></ul>				<div role="alert" class="tree-loader hide"><div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div></div>						</li><li aria-expanded="true" role="treeitem" class="tree-branch">				<div class="tree-branch-header">					<span class="tree-branch-name">						<i class="icon-folder ace-icon tree-plus"></i>						<span class="tree-label">Rentals</span>					</span>				</div>				<ul role="group" class="tree-branch-children"></ul>				<div role="alert" class="tree-loader hide"><div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div></div>						</li><li aria-expanded="false" role="treeitem" class="tree-branch">				<div class="tree-branch-header">					<span class="tree-branch-name">						<i class="icon-folder ace-icon tree-plus"></i>						<span class="tree-label">Real Estate</span>					</span>				</div>				<ul role="group" class="tree-branch-children"></ul>				<div role="alert" class="tree-loader hide"><div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div></div>						</li><li aria-expanded="false" role="treeitem" class="tree-branch">				<div class="tree-branch-header">					<span class="tree-branch-name">						<i class="icon-folder ace-icon tree-plus"></i>						<span class="tree-label">Pets</span>					</span>				</div>				<ul role="group" class="tree-branch-children hide"><li role="treeitem" class="tree-item">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-times"></i>				  <span class="tree-label">Cats</span>				</span>			</li><li role="treeitem" class="tree-item">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-times"></i>				  <span class="tree-label">Dogs</span>				</span>			</li><li role="treeitem" class="tree-item">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-times"></i>				  <span class="tree-label">Horses</span>				</span>			</li><li role="treeitem" class="tree-item">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-times"></i>				  <span class="tree-label">Reptiles</span>				</span>			</li></ul>				<div role="alert" class="tree-loader hide"><div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div></div>						</li><li role="treeitem" class="tree-item">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-times"></i>				  <span class="tree-label">Tickets</span>				</span>			</li><li role="treeitem" class="tree-item">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-times"></i>				  <span class="tree-label">Services</span>				</span>			</li><li role="treeitem" class="tree-item">				<span class="tree-item-name">				  <i class="icon-item ace-icon fa fa-times"></i>				  <span class="tree-label">Personals</span>				</span>			</li></ul>
                        </div>
                    </div>
                </div>
            </div>
            <div colspan="2" class="col-sm-10">
                <?php $i = 1 ?>
                @foreach($arrPermissionByController as $key => $val)
                    <div class="col-sm-4" @if($i%3 == 1) style="clear: left" @endif>
                        <div class="panel panel-default">
                            <div class="panel-heading"><b>@if($key || $key != ''){{$key}}@else Khac @endif</b></div>
                            <div class="panel-body">
                                @foreach($val as $k => $v)
                                    <div class="checkbox clearfix">
                                        <label title="{{$v['permission_name']}}">
                                            <input type="checkbox" value="{{$v['permission_id']}}"

                                                  ame="permission_id[]" @if(isset($data['strPermission'])) @if(in_array($v['permission_id'],$data['strPermission']))

                                                  hecked @endif @endif>  {{$v['permission_name']}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <?php $i++; ?>
                @endforeach
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12 text-right">
            <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
        </div>
    </div>
    {{ Form::close() }}
</section>