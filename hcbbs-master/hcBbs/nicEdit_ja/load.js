/**
 * nicEditのソース
 */
var cacheIdx = 0;
var area2 = new nicEditor({fullPanel : true,maxHeight : 600,convertToText : false}).panelInstance('text-editor');

function addArea2() {
  var nicsrc = $('#text-editor').val();
  cacheIdx++;
  nicsrc = nicsrc.replace(/cachetime_[0-9]+/g,'cachetime_' + cacheIdx);
  nicsrc = nicsrc.replace(/\[NOWTIME\]/g,cacheIdx);
  $('#text-editor').val(nicsrc);
  area2 = new nicEditor({fullPanel : true,maxHeight : 600,convertToText : false}).panelInstance('text-editor');

}

function removeArea2() {
  area2.removeInstance('text-editor');
}

function wysReload(){
    removeArea2();
    addArea2();
}
