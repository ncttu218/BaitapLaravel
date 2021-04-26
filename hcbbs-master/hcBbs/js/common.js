function toggleAttention(element){
    $(element).toggleClass('is-open').next().stop().slideToggle(300);
}

$('.js-attention-toggle').on('click',function(e){
    e.preventDefault();
    toggleAttention(this);
});

$('#js-caution-close').on('click',function(e){
    e.preventDefault();
    $('#js-caution').fadeOut();
});

// 日付選択の設定
$('.datetimepicker').datetimepicker({
    timepicker : false,         // 時間の選択肢を有効にするフラグ
    closeOnDateSelect : true,   // クリックすると、カレンダーを閉じるフラグ
    scrollMonth : false,        // スクロールをする時、カレンダーの日付が動くフラグ
    scrollInput : false         // スクロールをする時、フォーム値の日付が動くフラグ
});
