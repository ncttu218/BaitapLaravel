┏┌┌┌  {{ $hansha_name ?? '' }}
┏┏┌┌　拠点ブログで本社承認がありました。
┏┏┏┌　内容は以下の通りです。
┏┏┏┏

----------------------------------------------------
店舗：{{ $shop_name ?? '' }}
タイトル：{{ $post_title ?? '' }}
投稿内容：
{!! $post_content ?? '' !!}
----------------------------------------------------
本社管理者用画面から承認処理を行なって下さい
{!! $admin_page_url ?? '' !!}
※本社担当用管理画面から「公開OK」に設定されたもののみ表示されます。
　「公開OK」に設定されていないものは表示されません。

{{ $hansha_name ?? '' }} 拠点ブログ管理システム