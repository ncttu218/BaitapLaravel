
{{-- ペジネート --}}
<div class="row">
    {{-- 現在のページ数が1以上の時 --}}
    @if( $data->currentPage() > 1 )
        <div class="col-xs-1">
            <button type="button" onClick="location.href='{{ $data->url(1) }}'" class="btn btn-default btn-sm pull-left">
                <span aria-hidden="true">&laquo;</span> 先頭
            </button>
        </div>
        <div class="col-xs-1">                    
            <button type="button" onClick="location.href='{{ $data->url($data->currentPage() - 1) }}'" class="btn btn-default btn-sm pull-left">
                <span aria-hidden="true">&lsaquo;</span> 前へ
            </button>
        </div>
    @else
        <div class="col-xs-1"></div>
        <div class="col-xs-1"></div>
    @endif

    <div class="col-xs-6 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-body text-center pdg5">
                {{ $data->firstItem() }}件 ～ {{ $data->lastItem() }}件 / {{ $data->total() }} 件
            </div>
        </div>
    </div>

    {{-- 最後のページかどうかを判定(Boolean) --}}
    @if( $data->hasMorePages() )
        <div class="col-xs-1 col-xs-offset-1">
            <button type="button" onClick="location.href='{{ $data->nextPageUrl() }}'" class="btn btn-default btn-sm pull-right">
                次へ <span aria-hidden="true">&rsaquo;</span>
            </button>
        </div>
        <div class="col-xs-1">
            <button type="button" onClick="location.href='{{ $data->url($data->lastPage()) }}'" class="btn btn-default btn-sm pull-right">
                最後 <span aria-hidden="true">&raquo;</span>
            </button>
        </div>
    @else
        <div class="col-xs-1"></div>
        <div class="col-xs-1"></div>
    @endif

</div>
