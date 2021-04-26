{{-- タイトル --}}
<div class="p-entrylist-box__head" style="background: rgb(0, 0, 102);color: #FFFFFF;margin-left: -15px;margin-right: -15px;">
    <h4 class="p-entrylist-box__title" style="padding: 2px 15px;margin: 0;width: 100%;position: relative;">
        @include('api.common.admin.hobbs.column.title')
    </h4>
    @if (isset($shopName))
        <div class="p-entrylist-box__sign">
            {{ $shopName }}
        </div>
    @endif
</div>
<div class="p-entrylist-box__body">
    <table>
        <tr>
            @if (!empty($row->file1))
                <td style="font-size:10px;padding:5px;">
                    <?php
                    // ファイルパスの情報を取得する
                    $fileinfo1 = pathinfo( $row->file1 );
                    ?>
                    {{-- PDFファイルの対応 --}}
                    @if( strtolower( $fileinfo1['extension'] ) === "pdf" )
                        <a href="{{ asset_auto($row->file1) }}" target="_blank">
                            <img src="{{ $CodeUtil::getPdfThumbnail( $row->file1 ) }}" width="200" alt="{{ $row->caption1 }}">
                        </a>
                    @else
                        <img src="{{ asset_auto($row->file1) }}" alt="{{ $row->caption1 }}" width="200">
                    @endif
                    <br>
                    {!! $row->caption1 ?? '' !!}
                </td>
            @endif
            @if (!empty($row->file2))
                <td style="font-size:10px;padding:5px;">
                    <?php
                    // ファイルパスの情報を取得する
                    $fileinfo2 = pathinfo( $row->file2 );
                    ?>
                    {{-- PDFファイルの対応 --}}
                    @if( strtolower( $fileinfo2['extension'] ) === "pdf" )
                        <a href="{{ asset_auto($row->file2) }}" target="_blank">
                            <img src="{{ $CodeUtil::getPdfThumbnail( $row->file2 ) }}" width="200" alt="{{ $row->caption2 }}">
                        </a>
                    @else
                        <img src="{{ asset_auto($row->file2) }}" alt="{{ $row->caption2 }}" width="200">
                    @endif
                    <br>
                    {!! $row->caption2 ?? '' !!}
                </td>
            @endif
            @if (!empty($row->file3))
                <td style="font-size:10px;padding:5px;">
                    <?php
                    // ファイルパスの情報を取得する
                    $fileinfo3 = pathinfo( $row->file3 );
                    ?>
                    {{-- PDFファイルの対応 --}}
                    @if( strtolower( $fileinfo3['extension'] ) === "pdf" )
                        <a href="{{ asset_auto($row->file3) }}" target="_blank">
                            <img src="{{ $CodeUtil::getPdfThumbnail( $row->file3 ) }}" width="200" alt="{{ $row->caption3 }}">
                        </a>
                    @else
                        <img src="{{ asset_auto($row->file3) }}" alt="{{ $row->caption3 }}" width="200">
                    @endif
                    <br>
                    {!! $row->caption3 ?? '' !!}
                </td>
            @endif
        </tr>
    </table>
@include('api.common.admin.hobbs.column.comment')
</div>