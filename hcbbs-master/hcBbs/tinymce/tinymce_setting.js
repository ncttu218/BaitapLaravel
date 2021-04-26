var editorImageList = {};
/**
 * エディター上に削除した画像を一覧から消す関数
 * 
 * @param {string} content
 * @returns {void}
 */
var checkImageExistence = function(content) {
    if (myDropzone.files.length === 0) {
        return;
    }
    let match;
    const pattern = /\"([^\"]+?data\/image\/[0-9]+?\/[0-9_]+\.[a-zA-Z]+?)\"/;
    const regex = RegExp(pattern,'g');
    editorImageList = {};
    // エディター上の画像
    while ((match = regex.exec(content)) !== null) {
        let imageUrl = match[1];
        editorImageList[imageUrl] = true;
    }
    // 一覧上の画像
    for(let key in myDropzone.files) {
        const file = myDropzone.files[key];
        const fileUrl = typeof file.xhr !== 'undefined' ? file.xhr.responseText : file.dataUrl;
        if (typeof editorImageList[fileUrl] !== 'undefined') {
            continue;
        }
        myDropzone.removeFile(file);
    }
}

tinymce.baseURL = tinyMCEBaseURL;
tinymce.init({
    selector: "textarea", // id="tinymce"の場所にTinyMCEを適用
    language: "ja", // 言語 = 日本語
    height : 500,
    width: '100%',
    inline: false,
    theme: 'silver',
//    plugins: [
//        'advlist autolink lists link charmap print preview anchor pagebreak',
//        'searchreplace visualblocks code fullscreen colorpicker',
//        'insertdatetime media table contextmenu paste code image emoticons',
//        'textcolor hr'
//    ],
//    toolbar1: 'bold italic underline strikethrough hr | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent',
//    toolbar2: 'forecolor backcolor | link unlink | table | pagebreak | undo redo | searchreplace | fullscreen | code | image emoticons',
//    toolbar3: 'styleselect formatselect fontselect fontsizeselect',
    
    plugins: 'print preview fullpage paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap emoticons table',
    menubar: 'file edit view insert format tools table help',
    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample| table | ltr rtl',
    // toolbar_drawer: 'sliding',

    // モバイルのテーマ
    mobile: {
        theme: 'silver',
        // plugins: [ 'autosave', 'lists', 'autolink', 'textcolor' ],
        // toolbar: [ 'undo', 'bold', 'italic', 'underline', 'alignleft', 'aligncenter', 'alignright', 'alignjustify', 'bullist', 'numlist', 'backcolor', 'forecolor', 'styleselect', 'link' ]
    },
    // contextmenu: "cut copy paste selectall formats link inserttable | cell row column deletetable",
    contextmenu: true,

    menubar  : false,
    remove_script_host : false,
    relative_urls : false,
    suffix: '.min',
    branding: false, // クレジットの削除
    color_map: [
        "000000", "Black",
        "993300", "Burnt orange",
        "333300", "Dark olive",
        "003300", "Dark green",
        "003366", "Dark azure",
        "000080", "Navy Blue",
        "333399", "Indigo",
        "333333", "Very dark gray",
        "800000", "Maroon",
        "FF6600", "Orange",
        "808000", "Olive",
        "008000", "Green",
        "008080", "Teal",
        "0000FF", "Blue",
        "666699", "Grayish blue",
        "808080", "Gray",
        "FF0000", "Red",
        "FF9900", "Amber",
        "99CC00", "Yellow green",
        "339966", "Sea green",
        "33CCCC", "Turquoise",
        "3366FF", "Royal blue",
        "800080", "Purple",
        "999999", "Medium gray",
        "FF00FF", "Magenta",
        "FFCC00", "Gold",
        "FFFF00", "Yellow",
        "00FF00", "Lime",
        "00FFFF", "Aqua",
        "00CCFF", "Sky blue",
        "993366", "Red violet",
        "FFFFFF", "White",
        "FF99CC", "Pink",
        "FFCC99", "Peach",
        "FFFF99", "Light yellow",
        "CCFFCC", "Pale green",
        "CCFFFF", "Pale cyan",
        "99CCFF", "Light sky blue",
        "CC99FF", "Plum"
  ],
  
  init_instance_callback: function (editor) {
    editor.on('KeyUp', function (e) {
        checkImageExistence(editor.getContent());
    });
  }
});