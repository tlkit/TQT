<section class="content-header">
    <h1>
        Chi tiết chiến dịch "{{$campaign['seo_campaign_name']}}"
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li><a href="{{URL::route('campaign.view')}}"><i class="fa fa-dashboard"></i>Danh sách campaign</a></li>
        <li class="active">Chi tiết campaign</li>
    </ol>
</section>
<section class="content">
    <div class="col-sm-12 clearfix">
        <p>
            <span><b>Ngày chạy :</b></span>
            <span>{{date('d-m-Y',$campaign['seo_campaign_start_time'])}}</span>
        </p>
        <p>
            <span><b>Dự án :</b></span>
            <span>{{$aryProject[$campaign['seo_campaign_project_id']]}}</span>
        </p>
        <p>
            <span><b>Bảng từ khóa :</b></span>
        </p>
        <table class="table table-bordered table-hover">
            <tbody role="alert">
                <tr role="row">
                    <th width="3%" class="text-center">ID</th>
                    <th width="10%" class="text-center">Keyword</th>
                    <th width="10%" class="text-center">Before Description</th>
                    <th width="10%" class="text-center">After Description</th>
                    <th width="5%" class="text-center">Rank</th>
                    <th width="10%" class="text-center">Landing page</th>
                    <th width="8%" class="text-center">Category</th>
                    <th width="8%" class="text-center">Group(key)</th>
                    <th width="5%" class="text-center">Number Search</th>
                    <th width="5%" class="text-center">Max Link</th>
                    <th width="5%" class="text-center">Daily Link</th>
                    <th width="5%" class="text-center">SL đã chạy</th>
                    <th width="5%" class="text-center">Last time</th>
                </tr>
                @if($campaign->keyword)
                    @foreach($campaign->keyword as $key)
                    <tr role="row">
                        <td class="text-center">{{$key['seo_keyword_id']}}</td>
                        <td class="text-center">{{$key['seo_keyword_key']}}</td>
                        <td class="text-center">{{$key['seo_keyword_description_before']}}</td>
                        <td class="text-center">{{$key['seo_keyword_keyword_description_after']}}</td>
                        <td class="text-center">{{$key['seo_keyword_rank']}}</td>
                        <td class="text-center">{{$key['seo_keyword_landing_url']}}</td>
                        <td class="text-center">@if(isset($aryCategory[$key['seo_keyword_category']])){{$aryCategory[$key['seo_keyword_category']]}}@endif</td>
                        <td class="text-center">{{$key['seo_keyword_group']}}</td>
                        <td class="text-center">{{$key['seo_keyword_number_search']}}</td>
                        <td class="text-center">{{$key['seo_keyword_max_link_vt']}}</td>
                        <td class="text-center">{{$key['seo_keyword_daily_link_vt']}}</td>
                        <td class="text-center">{{$key['seo_keyword_run_link_vt']}}</td>
                        <td class="text-center">@if($key['seo_keyword_run_last_time'] > 0){{date('d-m-Y H:i:s', $key['seo_keyword_run_last_time'])}} @else -- @endif</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="text-right">
            <a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
        </div>

    </div>
</section>
