'use strict';

$('#form_id, .p-edit-form').submit(function(e) {
    if (!$('#comp_check').is(':checked')) {
        alert('利用規約違反がないことを確認し、チェックを入れてください');
        return false;
    } else if (typeof HANSHA_CODE !== 'undefined' && HANSHA_CODE === '8153883'
        && $('input[name=to_date]').val().trim() === '') {
        alert('掲載終了日が未設定です。必ず設定してください');
        return false;
    } else if (typeof HANSHA_CODE !== 'undefined' && HANSHA_CODE === '8153883'
        && $('input[name=to_date]').val().trim() !== '' &&
        !$('input[name=to_date]').val().trim().match(/^\d\d\d\d-\d\d-\d\d$/)) {
        alert('掲載終了日のフォーマットが正しくないです');
        return false;
    }
    return true;
});

function filesel3_disp(){
	console.log('sel3');
	$('#filesel3').show();
	$('#filefree').hide();
}
function filefree_disp(){
	console.log('free');
	$('#filesel3').hide();
	$('#filefree').show();
}

$('.p-edit-section__item').on('dragover', function (event) {
    return false ;
}).on('drop', function (event) {
	alert('この領域に画像をドロップすることは出来ません。');
    return false ;
});

// 日付と時間の選択のUIの定義
$.datetimepicker.setLocale( 'ja' );
/*
 * 日時入力で必要
 */
$('.datetimepicker').datetimepicker({
    format: 'Y-m-d',
    inline: false,
    timepicker: false,
    lang: 'ja'
});
