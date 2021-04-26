
// 数字だけが入力されているかを調べる
function checkNumOnly( txt_obj ){
    // 入力された値を取得
    var txtValue = txt_obj.value;

    //入力値に 0～9 以外があれば
    if( txtValue.match( /[^0-9]+/ ) ){
        // 0～9 以外を削除
        txt_obj.value = txtValue.replace( /[^0-9]+/g,"" );
    }
    return true;
}


// 数字だけが入力されているかを調べる
function checkCarMileage( txt_obj ){
    // 入力された値を取得
    var txtValue = txt_obj.value;

    //入力値に 0～9 以外があれば
    if( txtValue.match( /[^0-9-]+/ ) ){
        // 0～9 以外を削除
        txt_obj.value = txtValue.replace( /[^0-9-]+/g,"" );
    }
    return true;
}


// 英数字だけが入力されているかを調べる
function checkAlphaNumOnly( txt_obj ){
    // 入力された値を取得
    var txtValue = txt_obj.value;

    //入力値に 0～9, a～z, A-Z 以外があれば
    if( txtValue.match( /[^0-9a-zA-ZA-Z-]/ ) ){
        // 0～9, a～z, A-Z 以外を削除
        txt_obj.value = txtValue.replace( /[^0-9a-zA-ZA-Z-]/g,"" );
    }
    return true;
}


// 数字とカンマと小数点が入力されているかを調べる
function checkPriceOnly( txt_obj ){
    // 入力された値を取得
    var txtValue = txt_obj.value;

    //入力値に 0～9と小数点 以外があれば
    if( txtValue.match( /[^0-9,.]+/ ) ){
        // 0～9と小数点 以外を削除
        txt_obj.value = txtValue.replace( /[^0-9,.]+/g,"" );
    }
    return true;
}
//追加
function limitText(limitField, limitCount, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    } else {
        limitCount.value = limitNum - limitField.value.length;
    }
    return true;
}
