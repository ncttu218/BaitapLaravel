<?php

// 設置する並び順の値を格納
$setSortTypes = $sortTypes;

// 並び順のカラム名を指定
$setSortTypes['sort_key'] = $sort_key;
// デフォルトの並び順を指定
$setSortTypes['sort_by'] = "asc";

// 並び順の記号を取得
$sortMark = "";

// 選択されている並び順が合致する時の処理
if( $sortTypes['sort_key'] == $sort_key ){
	if( $sortTypes['sort_by'] == 'asc'){
		// 並び順の記号を取得
		$sortMark = "▲";
		
		// 並び順を指定
		$setSortTypes['sort_by'] = "desc";

	}else if($sortTypes['sort_by'] == 'desc'){
		// 並び順の記号を取得
		$sortMark = "▼";

		// 並び順を指定
		$setSortTypes['sort_by'] = "asc";
	}
}

?>

{{-- リストのヘッダーのソート部分を定義 --}}
<a id="mainlListSort-1" class="link_sort" href="{{ $url . '?' . http_build_query( $setSortTypes, '' , '&amp;' ) }}">
	{!! $name !!}<span class="sortMark">{{ $sortMark }}</span>
</a>
