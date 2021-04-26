/*
 * submitボタン無効にするとformに渡せないので
 * ボタンで処理が分岐する場合はhiddenに入れてformに渡す
 */
function setHiddenValue(button) {
  if (button.name) {
    var q = document.createElement('input');
    q.type = 'hidden';
    q.name = button.name;
    q.value = button.value;
    button.form.appendChild(q);
  }
}
/*
 * ボタンが押されたらすべてのボタンを無効にする（２度押し防止）
 */
function setDisabled(){
  $(".button_check").attr('disabled', true);
}

$(function () {
    /*
     * submitボタンが押されたらすべてのボタンを無効にする（２度押し防止）
     */
    $('form').submit(function () {
      $(this).find(':submit').attr('disabled', 'disabled');
      $(".button_check").attr('disabled', true);
    });
  
    /*
     * アカウント管理、拠点管理、販社セレクトイベント
     */
    $('select[name="hansha_code"]').change(function(){
        getHanshaDatas();
    });
  
});

// 拠点リスト作成
var getHanshaDatas = function() {
    var url = './shop-list';
    var hansha_code = $('[name="hansha_code"]').val();
    var shop = $('[name="shop"]').val();
    if (!! hansha_code) {
        url = url + '/' + hansha_code;
    }

    // ajax通信のオプションを設定
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        headers: {
            // GET以外は必ずトークンのチェックを行うこと
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // ajax通信が成功したとき
        success: function(data, textStatus) {
            // 担当のプルダウンを生成
            generateShopList(data, shop);
        },
        // ajax通信が失敗したとき
        error: function(xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(errorThrown);
            console.log('getShopDatas : ' + textStatus);
        }
    });
}

// 選択した販社に応じた拠点のoptionタグを生成
var generateShopList = function(data, shop) {
    // <option>を空にする
    $('select[name="shop"]').empty();
    // データが空だろうがなかろうが共通で作るoption
//    $('select[name="shop"]').append($('<option>').val('').text('----'));
    // 取得データが空の時は何もしない
    if ($.isEmptyObject(data) === false) {
        // 取得したデータをもとに<option>を生成する
        options = $.map(data, function(shop_name, id) {
            // 選択状態にするかどうか
            var isSelected = (id === shop);

            // タグ生成時にオブジェクトで属性を指定
            $option = $('<option>', { value: id, text: shop_name, selected: isSelected});

            return $option;
        });

        // Append Outside of Loops
        $('select[name="shop"]').append(options);
    }
};

