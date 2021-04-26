@if($dataType == 'object' && isset($row->inquiry_method))
    @if($row->inquiry_method == 'mail')
<a href="mailto:{{ $row->mail_addr }}?Subject={{ $row->inquiry_inscription }}">{{ $row->inquiry_inscription }}</a>
    @endif
    @if($row->inquiry_method =='form')
<a href="http://www.hondanet.co.jp/cgi/form_port.cgi?id=0000001/infobbs&code=06&お問合せ内容=の件&ご用件=お問合せ&kyoten=01" 
   target="_BLANK">{{ $row->inquiry_inscription }}</a>
    @endif
    @if($row->inquiry_method =='url')
<a href="{{ $row->form_addr }}" target="_BLANK">{{ $row->inquiry_inscription }}</a>
    @endif
@endif

@if($dataType == 'array')
    @if(isset($data['inquiry_method']))
        @if($data['inquiry_method'] =='mail')
        <a href="mailto:{{ $data['mail_addr'] }}?Subject={{ $data['inquiry_inscription'] }}">{{ $data['inquiry_inscription'] }}</a>
        @endif
        @if($data['inquiry_method'] =='form')
        <a href="http://www.hondanet.co.jp/cgi/form_port.cgi?id=0000001/infobbs&code=06&お問合せ内容=の件&ご用件=お問合せ&kyoten=01" 
       target="_BLANK">{{ $data['inquiry_inscription'] }}</a>
        @endif
        @if($data['inquiry_method'] =='url')
        <a href="{{ $data['form_addr'] }}" target="_BLANK">{{ $data['inquiry_inscription'] }}</a>
        @endif
    @endif
@endif
